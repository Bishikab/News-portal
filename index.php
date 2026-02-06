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
    <title>NewsVerse</title>
   <style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

    * {
        margin: 0;

        box-sizing: border-box;
        font-family: 'Roboto', sans-serif;
    }

    body {
        background-color: #f4f4f4;
        color: #333;
    }

    .nav-bar {
        display: flex;
        justify-content: flex-start;

        padding: 10px 20px;
    }

    .nav-logo h2 {
        color: #080808ff;
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
    .nav-menu ul{
        display: flex;
        margin: auto;
        gap: 20px;
        align-items: flex-start;
        flex-direction: column;
        list-style: none;
        
        
        

    }

    .nav-menu li {
        margin-left: 20px;
       
        
    }

    .nav-menu a {
       color: white;
        text-decoration: none;
        font-weight: bold;
        font-family: serif;

    }
   .btn {
    padding: 6px 14px;
    color: #783595;
    border-radius: 4px;
    font-size: 14px;
}

 .reg-btn {
     padding: 6px 14px;
    color: #783595;
    border-radius: 4px;
    font-size: 14px;
}


    
    
    
       
.user-info {
    display: flex;
    gap: 15px;
    margin-left: auto;
}


    .container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 0 20px;
    }

    .news-box {
        background-color:white;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .logo-head { 
        height: auto;
        width: 300px;
        border-radius: 5px;
        padding: 25px;
        justify-content: center;

    }

   </style>
</head>
<body>

<header>
    <img src="images/News_logo.jpg" class="logo-head" alt="NewsVerse Logo">
     

    <nav class="nav-bar">
        <a href="index.php" class="nav-logo"></a>
        <ul class="nav-menu">
    

            <li><a href="World.php">World</a></li>
            <li><a href="Politics.php">Politics</a></li>
            <li><a href="Entertainment.php">Entertainment</a></li>
            <li><a href="Sports.php">Sports</a></li>
            <li><a href="Science.php">Science</a></li>
            <li><a href="Travel.php">Travel</a></li>
            <li><a href="Health.php">Health</a></li> 



      
        
           <!-- <span><?php echo $_SESSION['user']; ?></span> -->
           <div class="user-info">
    <li><a href="logout.php" class="btn">Log out</a></li>
    <li><a href="Register.php" class="reg-btn">Sign in</a></li>
</div>

</ul>

       
    </nav>
   
</header>

<main class="container">
    <h2>Latest News</h2>

    <?php
    $query = "SELECT * FROM news ORDER BY id DESC";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="news-box">
                <h3><?php echo $row['title']; ?></h3>
                <p><?php echo $row['content']; ?></p>
                <img src="uploads/<?php echo $row['image']; ?>" width="300">
            </div>
            <?php
        }
    } else {
        echo "<div class='news-box'><p>No news available yet.</p></div>";
    }
    ?>
</main>


</body>
</html>