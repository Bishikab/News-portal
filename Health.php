<?php
session_start();
include("config/connection.php");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health News</title>
    <link rel="stylesheet" href="css/style.css">

    <style>
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
            margin-top: 120px;
        }
        .news-box {
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
        }
    </style>
</head>

<body>

<?php include("includes/header.php"); ?>

<h2 style="text-align:center;">Health News</h2>

<div class="container">
<?php
$query = "SELECT * FROM news WHERE category = 3 ORDER BY id DESC";
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
    echo "<div class='news-box'>
            <p>No Health news available.</p>
          </div>";
}
?>
</div>

<?php include("includes/footer.php"); ?>

</body>
</html>