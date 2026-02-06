<?php
session_start();
include "config/connection.php";

$msg = '';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $select1 = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $select_user = mysqli_query($conn, $select1);

    if (mysqli_num_rows($select_user) > 0) {
        $row1 = mysqli_fetch_assoc($select_user);

    
        $role = strtolower(trim($row1['role']));

        if ($role === 'admin') {
            $_SESSION['admin'] = $row1['email'];
            $_SESSION['id']    = $row1['id'];
            header('Location: dashboard/dashboard.php');
            exit;
        } 
        elseif ($role === 'user') {
            $_SESSION['user'] = $row1['email'];
            $_SESSION['id']   = $row1['id'];
            header('Location: index.php');
            exit;
        }
    } 
    else {
        $msg = "Incorrect email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="static/style.css">
    
</head>
<body>
    <div class="form">
        <form action=""  method="post">
            <h2>Login</h2>
            <p class="msg"></p>
            
            <div class="form-group">
            <input type="email" name="email" placeholder="Enter your Email" class="form-control"required>
        
            
            <div class="form-group">
            <input type="password" name="password" placeholder="Enter your Password" class="form-control" required>
                      </div>
                   

            <button class="btn font-weight-bold" name="submit">Login</button>
            <p>Don't have an account? <a href="register.php">Register here</a></p>
            


        </form>
    </div>
    
</body>
</html>