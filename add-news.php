<?php
session_start();
include("../config/connection.php");



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $title = trim($_POST['title'] ?? '');
    $category = intval($_POST['category_id'] ?? 0); 
    $content = trim($_POST['content'] ?? '');
    
    
    if (empty($title) || empty($content) || $category < 1 || $category > 8) {
        $_SESSION['error'] = "All fields are required, and category must be valid.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    
    
    $upload_dir = __DIR__ . "/../uploads/";
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    $image_name = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['image']['tmp_name'];
        $original_name = basename($_FILES['image']['name']);
        
        
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = mime_content_type($tmp_name);
        $file_size = $_FILES['image']['size'];
        
        if (!in_array($file_type, $allowed_types) || $file_size > 5 * 1024 * 1024) {
            $_SESSION['error'] = "Invalid image file (must be JPEG/PNG/GIF under 5MB).";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
        
        
        $image_name = time() . "_" . preg_replace('/[^a-zA-Z0-9\._-]/', '', $original_name);

        
        if (!move_uploaded_file($tmp_name, $upload_dir . $image_name)) {
            $_SESSION['error'] = "Failed to upload image.";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();

        }
    } else {
        $_SESSION['error'] = "Image upload is required.";
        header("Location: " . $_SERVER['PHP_SELF']);

        exit();
    }
    

    $stmt = $conn->prepare("INSERT INTO news (title, category, content, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $title, $category, $content, $image_name);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "News added successfully.";
    } else {
        $_SESSION['error'] = "Database error: " . $stmt->error;
    }
    $stmt->close();
   
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}



$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';
unset($_SESSION['success'], $_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add News - Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
        }
        nav {
            text-align: center;
            margin-bottom: 20px;
        }
        nav a {
            margin: 0 15px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            background-color: #783595;
            
        }
        .nav-menu li {
        margin-left: 20px;
       
        
    }
            .nav-menu {
        list-style: none;
        display: flex;
        padding: 10px 0;
        justify-content: flex-start;
        align-items: center;
         background-color: #783595;
         width: 100%;
    }
    
        main {
            display: flex;
            justify-content: center;
        }
        .news {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        .news input[type="text"], .news select, .news textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        .message {
            text-align: center;
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 3px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <h1>Add News Article</h1>
    <nav>
        <ul class="nav-menu">
        <a href="dashboard.php">Dashboard</a>
        <a href="view-news.php">View News</a>
      <a href="../logout.php">Log out</a>
        </ul>

    </nav>
    <main>
        <div class="news">
            <?php if ($success): ?>
                <div class="message success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="message error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form method="POST" enctype="multipart/form-data">
                <input type="text" name="title" placeholder="News Title" required><br><br>
                <select name="category_id" required>
                    <option value="">Select Category</option>
                    <option value="1">Politics</option>
                    <option value="2">Sports</option>
                    <option value="3">Technology</option>
                    <option value="4">Entertainment</option>
                    <option value="5">Style</option>
                    <option value="6">Science</option>
                    <option value="7">Travel</option>
                    <option value="8">World</option>
                </select><br><br>
                <textarea name="content" placeholder="News Content" required></textarea><br><br>
                <input type="file" name="image" accept="image/*" required><br><br>
                <button type="submit">Publish</button>
            </form>
        </div>
    </main>
</body>
</html>