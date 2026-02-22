<?php
session_start();
include("../config/connection.php");


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporter Dashboard</title>
    <style>

    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Roboto', sans-serif;
    background-color: #f4f6f8;
    color: #2f3640;
}


.sidebar {
    width: 230px;
    height: 100vh;
    background: #783595;
    color: white;
    padding: 20px 0;
    position: fixed;
    top: 0;
    left: 0;
    overflow-y: auto;
}



.sidebar-menu {
    list-style: none;
}

.sidebar-menu li {
    margin-bottom: 8px;
}

.sidebar-menu li a {
    display: block;
    padding: 12px 22px;
    color: #f1f1f1;
    text-decoration: none;
    font-size: 15px;
    border-radius: 4px;
    transition: background 0.2s ease;
}

.sidebar-menu li a:hover {
    background: rgba(255, 255, 255, 0.15);
}

.sidebar-menu li a.active {
    background: #ffffff;
    color: #783595;
    font-weight: 600;
}


.main-content {
    margin-left: 230px;
    padding: 30px;
    min-height: 100vh;
}

.main-content h1 {
    font-size: 26px;
    margin-bottom: 10px;
}

.main-content p {
    font-size: 16px;
    margin-bottom: 30px;
}





    </style>
</head>

<body>
    <header>
        <aside class="sidebar">
    

    <ul class="sidebar-menu">
        <li><a href="add-news.php">Add News</a></li>
        <li><a href="view-news.php">View News</a></li>
        <li><a href="manage-news.php">Manage News</a></li>
                <li><a href="../logout.php">Logout</a></li>

    </ul>
</aside>
<main class="main-content">
    <h1>Welcome, Reporter</h1>
    <p>This is the reporter dashboard where you can add and manage news content.</p>


    </div>
</main>

</body>
</html>
        







    </div>
</body>
</html>
