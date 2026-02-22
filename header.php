<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<style>
  body {
    margin: 0;
    padding-top: 95px; 
}

header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background-color:whitesmoke;
    z-index: 1000;
}

.nav-bar {
    display: flex;
    justify-content: flex-start;
    padding: 8px 20px;
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
    padding: 5px 12px;
    color: #783595;
    border-radius: 4px;
    font-size: 13px;
}

 .reg-btn {
     padding: 5px 12px;
    color: #783595;
    border-radius: 4px;
    font-size: 13px;
}


    
    
    
       
.user-info {
    display: flex;
    gap: 15px;
    margin-left: auto;
}


   


.logo-head {
   
    width: 200px;
    border-radius: 5px;
    padding: 10px 0;
}


.user-info {
    display: flex;
    gap: 10px;
    margin-left: auto;
}
</style>

<header>
   <a href="index.php"> <img src="images/News_logo.jpg" class="logo-head" alt="NewsVerse Logo"></a>

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
            <li><a href="style.php">Style</a></li>
           
          

        <div class="user-info">
    <li><a href="logout.php" class="btn">Log out</a></li>
    <li><a href="Register.php" class="reg-btn">Sign in</a></li>
</div>

        </ul>
    </nav>
</header>