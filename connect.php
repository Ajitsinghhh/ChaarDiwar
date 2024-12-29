<?php
 
 $host="localhost";
 $user="root";
 $pass="";
 $db="home_db";
 $conn= new mysqli($host,$user,$pass,$db);

 if($conn->connect_error){
    echo "Faild to connect DB ajit kuch kar yaar".$conn->connect_error;
 }

 if (!function_exists('create_unique_id')) {
   function create_unique_id() {
       $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
       $charactersLength = strlen($characters);
       $randomString = '';
       for ($i = 0; $i < 20; $i++) {
           $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
       }
       return $randomString;
   }
}
?>