<?php
session_start();
include("../config/connection.php");

if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    header("Location: ../login.php");
    exit();
}

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM news WHERE id = $id");
$news = mysqli_fetch_assoc($result);

if (!$news) {
    header("Location: manage-news.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category = intval($_POST['category']);

    mysqli_query($conn, "UPDATE news 
                         SET title='$title', 
                             content='$content', 
                             category='$category'
                         WHERE id=$id");

    $_SESSION['success'] = "News updated successfully!";
    header("Location: manage-news.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit News</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f8;
        }

        .header {
            background: #783595;
            color: white;
            padding: 15px 30px;
            font-size: 20px;
            font-weight: 600;
        }

        .container {
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }

        .card {
            background: white;
            width: 600px;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
        }

        .card h2 {
            margin-bottom: 20px;
            color: #333;
        }

        label {
            font-weight: 500;
            display: block;
            margin-bottom: 6px;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            transition: 0.3s;
        }

        input[type="text"]:focus,
        textarea:focus,
        select:focus {
            border-color: #783595;
            outline: none;
            box-shadow: 0 0 5px rgba(120,53,149,0.3);
        }

        textarea {
            height: 120px;
            resize: vertical;
        }

        .image-preview {
            margin-bottom: 20px;
        }

        .image-preview img {
            width: 100%;
            max-height: 250px;
            object-fit: cover;
            border-radius: 6px;
        }

        .btn-group {
            display: flex;
            justify-content: space-between;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            text-align: center;
        }

        .update-btn {
            background: #783595;
            color: white;
        }

        .update-btn:hover {
            background: #5e2875;
        }

        .cancel-btn {
            background: #dc3545;
            color: white;
        }

        .cancel-btn:hover {
            background: #b52a37;
        }
    </style>
</head>
<body>

<div class="header">
    Edit News Article
</div>

<div class="container">
    <div class="card">
        <h2>Edit News</h2>

        <form method="POST">
            
            <label>News Title</label>
            <input type="text" name="title" 
                value="<?php echo htmlspecialchars($news['title']); ?>" required>

            <label>Category</label>
            <select name="category" required>
                <option value="1" <?php if($news['category']==1) echo "selected"; ?>>Politics</option>
                <option value="2" <?php if($news['category']==2) echo "selected"; ?>>Sports</option>
                <option value="3" <?php if($news['category']==3) echo "selected"; ?>>Technology</option>
                <option value="4" <?php if($news['category']==4) echo "selected"; ?>>Entertainment</option>
                <option value="5" <?php if($news['category']==5) echo "selected"; ?>>Style</option>
                <option value="6" <?php if($news['category']==6) echo "selected"; ?>>Science</option>
                <option value="7" <?php if($news['category']==7) echo "selected"; ?>>Travel</option>
                <option value="8" <?php if($news['category']==8) echo "selected"; ?>>World</option>
            </select>

            <label>Content</label>
            <textarea name="content" required><?php echo htmlspecialchars($news['content']); ?></textarea>

            <label>Current Image</label>
            <div class="image-preview">
                <img src="../uploads/<?php echo $news['image']; ?>">
            </div>

            <div class="btn-group">
                <button type="submit" class="btn update-btn">Update News</button>
                <a href="manage-news.php" class="btn cancel-btn">Cancel</a>
            </div>

        </form>
    </div>
</div>

</body>
</html>