<?php
session_start();
include("config/connection.php");

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>World News</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Roboto', sans-serif;
    background-color: #f5f6fa;
    color: #2f3640;
}

h2 {
    text-align: center;
    margin: 30px 0;
    font-weight: 700;
}


.container {
    max-width: 1100px;
    margin: auto;
    padding: 0 20px 40px;
}


.news-box {
    background: #ffffff;
    padding: 20px;
    margin-bottom: 25px;
    border-radius: 6px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.06);
}


.news-box h3 {
    font-size: 22px;
    margin-bottom: 10px;
    color: #273c75;
}


.news-box p {
    font-size: 16px;
    line-height: 1.6;
    color: #444;
}


.news-box img {
    width: 100%;
    max-height: 400px;
    object-fit: cover;
    border-radius: 4px;
    margin-top: 15px;
}


.news-box p:only-child {
    text-align: center;
    color: #888;
}

    </style>
</head>

<body>

<h2 style="text-align:center;">Politics News</h2>

<div class="container">
<?php
$query = "SELECT * FROM news WHERE category = 1 ORDER BY id DESC";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="news-box">
            <h3><?php echo $row['title']; ?></h3>
            <p><?php echo $row['content']; ?></p>

            <?php if (!empty($row['image'])) { ?>
                <img src="uploads/<?php echo $row['image']; ?>">
            <?php } ?>
        </div>
        <?php
    }
} else {
    echo "<div class='news-box'><p>No politics news available.</p></div>";
}
?>
</div>

</body>
</html>
