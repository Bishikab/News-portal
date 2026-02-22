<?php
session_start();
include("config/connection.php");

if(!isset($_SESSION['user_id'])){
echo "Login required";
exit();
}

$news_id = intval($_POST['news_id']);
$user_id = $_SESSION['user_id'];

$check = mysqli_query($conn,"SELECT * FROM likes WHERE news_id=$news_id AND user_id=$user_id");

if(mysqli_num_rows($check)==0){
mysqli_query($conn,"INSERT INTO likes (news_id,user_id) VALUES ($news_id,$user_id)");
}

$total = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS total FROM likes WHERE news_id=$news_id"));

echo $total['total'];
