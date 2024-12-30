<?php
session_start();
include 'connect.php'; // Ensure 'connect.php' uses MySQLi

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:login.php');
    exit;
}

if(isset($_SESSION['get_id'])){
    $get_id = $_SESSION['get_id'];
 }else{
    $get_id = '';
    header('location:homepage.php');
 }

 function sanitize($data) {
    return htmlspecialchars(strip_tags($data));
}

if(isset($_POST['update'])){
  

}