<?php
 
 $host="localhost";
 $user="root";
 $pass="";
 $db="login";
 $conn= new mysqli($host,$user,$pass,$db);

 if($conn->connect_error){
    echo "Faild to connect DB ajit kuch kar yaar".$conn->connect_error;
 }
?>