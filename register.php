<?php
include "config/connection.php";
$msg = "";

if (isset($_POST['submit'])) {

    $username  = $_POST['username'];
    $email     = $_POST['email'];
    $password  = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $role      = $_POST['role'];

    if ($password != $cpassword) {
        $msg = "Password Not Matched";
    } else {

        $select = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $select);

        if (mysqli_num_rows($result) > 0) {
            $msg = "User already exists";
        } else {
            $insert = "INSERT INTO users (name, email, password, role)
                       VALUES ('$username', '$email', '$password', '$role')";
            mysqli_query($conn, $insert);
            header("Location: login.php");
            exit;
        }
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
            <h2>Register</h2>
            <p class="msg"><?php echo $msg?></p>
            <div class="form-group">
            <input type="text" name="username" placeholder="Enter your Name" class="form-control" required>
            </div>
            <div class="form-group">
            <input type="email" name="email" placeholder="Enter your Email" class="form-control"required>
            </div>
           
            <div class="form-group">
            <input type="password" name="password" placeholder="Enter your Password" class="form-control" required>
                      </div>
                      <div class="form-group">
            <input type="password" name="cpassword" placeholder="confirm your Password" class="form-control" required>
                      </div>

            <button class="btn font-weight-bold" name="submit">Register Now</button>
            <p>Already have an account? <a href="login.php">Login here</a></p>
            


        </form>
    </div>
    
</body>
</html>