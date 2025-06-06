<?php

include '../connect.php';

if(isset($_COOKIE['admin_id'])){
   $admin_id = $_COOKIE['admin_id'];
}else{
   $admin_id = '';
   header('location:login.php');
   exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>

   <!-- Font Awesome CDN -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- Custom CSS -->
    <style>
      /* Admin Dashboard CSS */

:root {
    --primary-color: #4CAF50;
    --secondary-color: #333;
    --background-color: #f4f4f4;
    --text-color: #222;
    --white: #fff;
    --shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    --border-radius: 10px;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background-color: var(--background-color);
    color: var(--text-color);
}

.heading {
    text-align: center;
    font-size: 2rem;
    margin: 20px 0;
    color: var(--secondary-color);
    text-transform: uppercase;
}

.dashboard {
    max-width: 1100px;
    margin: 20px auto;
    padding: 20px;
    background: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
}

.box-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    padding: 20px;
}

.box {
    background: var(--white);
    padding: 20px;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    text-align: center;
    transition: transform 0.3s ease-in-out;
}

.box:hover {
    transform: translateY(-5px);
}

.box h3 {
    font-size: 2rem;
    color: var(--primary-color);
}

.box p {
    font-size: 1.2rem;
    margin: 10px 0;
    color: var(--secondary-color);
}

.btn {
    display: inline-block;
    text-decoration: none;
    padding: 10px 15px;
    font-size: 1rem;
    color: var(--white);
    background: var(--primary-color);
    border-radius: 5px;
    transition: background 0.3s;
}

.btn:hover {
    background: #388e3c;
}

@media (max-width: 768px) {
    .box-container {
        grid-template-columns: 1fr;
    }
}

    </style>
</head>
<body>
   
<!-- Header Section -->
<?php include '../Admin/admin_header.php'; ?>
<!-- Header Section Ends -->

<!-- Dashboard Section -->
<section class="dashboard">

   <h1 class="heading">dashboard</h1>

   <div class="box-container">

   <div class="box">
      <?php
         $stmt = mysqli_prepare($conn, "SELECT * FROM `admins` WHERE id = ? LIMIT 1");
         mysqli_stmt_bind_param($stmt, "i", $admin_id);
         mysqli_stmt_execute($stmt);
         $result = mysqli_stmt_get_result($stmt);
         $fetch_profile = mysqli_fetch_assoc($result);
      ?>
      <h3>Welcome!</h3>
      <p><?= htmlspecialchars($fetch_profile['name']); ?></p>
      <a href="update.php" class="btn">Update Profile</a>
   </div>

   <div class="box">
      <?php
         $result = mysqli_query($conn, "SELECT * FROM `property`");
         $count_listings = mysqli_num_rows($result);
      ?>
      <h3><?= $count_listings; ?></h3>
      <p>Property Posted</p>
      <a href="listings.php" class="btn">View Listings</a>
   </div>

   <div class="box">
      <?php
         $result = mysqli_query($conn, "SELECT * FROM `users`");
         $count_users = mysqli_num_rows($result);
      ?>
      <h3><?= $count_users; ?></h3>
      <p>Total Users</p>
      <a href="users.php" class="btn">View Users</a>
   </div>

   <div class="box">
      <?php
         $result = mysqli_query($conn, "SELECT * FROM `admins`");
         $count_admins = mysqli_num_rows($result);
      ?>
      <h3><?= $count_admins; ?></h3>
      <p>Total Admins</p>
      <a href="admins.php" class="btn">View Admins</a>
   </div>

   <div class="box">
      <?php
         $result = mysqli_query($conn, "SELECT * FROM `messages`");
         $count_messages = mysqli_num_rows($result);
      ?>
      <h3><?= $count_messages; ?></h3>
      <p>New Messages</p>
      <a href="messages.php" class="btn">View Messages</a>
   </div>

   </div>

</section>
<!-- Dashboard Section Ends -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- Custom JS File -->
<script src="../assets/js/admin_script.js"></script>

<?php include '../Admin/message.php'; ?>

</body>
</html>
