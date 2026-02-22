<?php
session_start();
include("../config/connection.php");

if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    header("Location: ../login.php");
    exit();
}

// Track visitor
$today = date("Y-m-d");
mysqli_query($conn, "INSERT INTO visitors (visit_date) VALUES ('$today')");

// ================= COUNTS =================
$news_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM news"))['total'];
$users_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users"))['total'];
$comments_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM comments"))['total'];
$likes_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM likes"))['total'];

$reporter_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role_id=2"))['total'];
$reader_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role_id=3"))['total'];

$visitors_today = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM visitors WHERE visit_date=CURDATE()"))['total'];

// ============ LAST 7 DAYS VISITOR DATA ============
$visitor_chart = mysqli_query($conn, "
    SELECT visit_date, COUNT(*) as total
    FROM visitors
    WHERE visit_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
    GROUP BY visit_date
    ORDER BY visit_date ASC
");

$visitor_dates = [];
$visitor_totals = [];

while($row = mysqli_fetch_assoc($visitor_chart)){
    $visitor_dates[] = $row['visit_date'];
    $visitor_totals[] = $row['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f6f8;
    margin:0;
}

.sidebar {
    width:230px;
    height:100vh;
    background:#783595;
    position:fixed;
    color:white;
    padding:20px 0;
}

.sidebar-title {
    text-align:center;
    font-size:20px;
    margin-bottom:30px;
}

.sidebar-menu {
    list-style:none;
    padding:0;
}

.sidebar-menu li a {
    display:block;
    padding:12px 20px;
    color:white;
    text-decoration:none;
}

.sidebar-menu li a:hover {
    background:rgba(255,255,255,0.2);
}

.main-content {
    margin-left:230px;
    padding:30px;
}

.dashboard-cards {
    display:flex;
    flex-wrap:wrap;
    gap:20px;
}

.card {
    background:white;
    padding:20px;
    flex:1 1 200px;
    border-radius:6px;
    box-shadow:0 4px 10px rgba(0,0,0,0.06);
    text-align:center;
}

.card h3 {
    font-size:28px;
    color:#783595;
}

.chart-container {
    background:white;
    margin-top:40px;
    padding:20px;
    border-radius:6px;
    box-shadow:0 4px 10px rgba(0,0,0,0.06);
}
</style>
</head>

<body>

<aside class="sidebar">
    <div class="sidebar-title">Admin Panel</div>
    <ul class="sidebar-menu">
        <li><a href="add-news.php">Add News</a></li>
        <li><a href="manage-news.php">Manage News</a></li>
        <li><a href="manage-users.php">Manage Users</a></li>
        <li><a href="manage-comments.php">Manage Comments</a></li>
        <li><a href="../logout.php">Logout</a></li>
    </ul>
</aside>

<main class="main-content">
    <h1>Welcome, Admin</h1>

    <div class="dashboard-cards">
        <div class="card"><h3><?= $news_count ?></h3><p>Total News</p></div>
        <div class="card"><h3><?= $users_count ?></h3><p>Total Users</p></div>
        <div class="card"><h3><?= $comments_count ?></h3><p>Total Comments</p></div>
        <div class="card"><h3><?= $likes_count ?></h3><p>Total Likes</p></div>
        <div class="card"><h3><?= $reporter_count ?></h3><p>Reporters</p></div>
        <div class="card"><h3><?= $reader_count ?></h3><p>Readers</p></div>
        <div class="card"><h3><?= $visitors_today ?></h3><p>Visitors Today</p></div>
    </div>

    <!-- Visitors Line Graph -->
    <div class="chart-container">
        <h2>Last 7 Days Visitors</h2>
        <canvas id="visitorChart"></canvas>
    </div>

</main>

<script>
new Chart(document.getElementById('visitorChart'), {
    type: 'line',
    data: {
        labels: <?= json_encode($visitor_dates); ?>,
        datasets: [{
            label: 'Visitors',
            data: <?= json_encode($visitor_totals); ?>,
            borderColor: '#783595',
            fill: false,
            tension: 0.3
        }]
    }
});
</script>

</body>
</html>