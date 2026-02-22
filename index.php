<?php
session_start();
include("config/connection.php");
include("includes/header.php");


if (isset($_POST['like'])) {

    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('Please login first');</script>";
    } else {

        $news_id = intval($_POST['news_id']);
        $user_id = $_SESSION['user_id'];


        $check = mysqli_query($conn, "SELECT * FROM likes 
                                      WHERE news_id='$news_id' 
                                      AND user_id='$user_id'");

        if (mysqli_num_rows($check) == 0) {
            mysqli_query($conn, "INSERT INTO likes (news_id, user_id) 
                                 VALUES ('$news_id', '$user_id')");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NewsVerse</title>
<style>

@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');
* { margin: 0; box-sizing: border-box; font-family: 'Roboto', sans-serif; }
body { background-color: #f4f4f4; color: #333; }
.container { max-width: 1200px; margin: 20px auto; padding: 0 20px; margin-top: 120px; }
.news-box { background-color:white; padding: 20px; margin-bottom: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
.news-content { display: flex; gap: 20px; align-items: stretch; }
.news-content img { width: 280px; height: 100%; object-fit: cover; border-radius: 4px; }
.news-text { flex: 1; }
.news-text p { line-height: 1.6; }
.read-more { display: inline-block; margin-top: 10px; color: #783595; font-weight: bold; text-decoration: none; }
.read-more:hover { text-decoration: underline; }

.like-btn {
    margin-top:10px;
    padding:6px 12px;
    background:#783595;
    color:white;
    border:none;
    border-radius:4px;
    cursor:pointer;
}
.like-btn:hover { opacity:0.9; }
.like-count { margin-left:8px; font-weight:bold; }
</style>
</head>
<body>

<main class="container">
<?php
if (isset($_GET['id'])) {

    $id = intval($_GET['id']);
    $query = "SELECT * FROM news WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $count_query = mysqli_query($conn,
            "SELECT COUNT(*) as total FROM likes WHERE news_id='$id'");
        $count = mysqli_fetch_assoc($count_query);
        ?>

        <div class="news-box">
            <h2><?php echo $row['title']; ?></h2>

            <img src="uploads/<?php echo $row['image']; ?>"
                 style="width:100%; max-height:450px; object-fit:cover; border-radius:6px; margin-bottom:15px;">

            <p style="line-height:1.8;">
                <?php echo nl2br($row['content']); ?>
            </p>

            <form method="POST">
                <input type="hidden" name="news_id" value="<?php echo $id; ?>">
                <button type="submit" name="like" class="like-btn">❤️ Like</button>
                <span class="like-count"><?php echo $count['total']; ?> Likes</span>
            </form>

            <a href="index.php" class="read-more">Back to news</a>
        </div>

        <?php
    } else {
        echo "<p>News not found.</p>";
    }

} else {
?>
<h2>Latest News</h2>
<?php
$query = "SELECT * FROM news ORDER BY id DESC";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $news_id = $row['id'];

  
        $count_query = mysqli_query($conn,
            "SELECT COUNT(*) as total FROM likes WHERE news_id='$news_id'");
        $count = mysqli_fetch_assoc($count_query);
?>
        <div class="news-box">
            <h3><?php echo $row['title']; ?></h3>
            <div class="news-content">
                <img src="uploads/<?php echo $row['image']; ?>" alt="News image">
                <div class="news-text">
                    <p><?php echo substr($row['content'], 0, 250); ?>...</p>
                    <a href="index.php?id=<?php echo $news_id; ?>" class="read-more">Read more</a>

                  
                    <form method="POST">
                        <input type="hidden" name="news_id" value="<?php echo $news_id; ?>">
                        <button type="submit" name="like" class="like-btn">❤️ Like</button>
                        <span class="like-count"><?php echo $count['total']; ?> Likes</span>
                    </form>

                </div>
            </div>
        </div>
<?php
    }
} else {
    echo "<p>No news available.</p>";
}
}
?>
</main>

<?php include("includes/footer.php"); ?>

</body>
</html>