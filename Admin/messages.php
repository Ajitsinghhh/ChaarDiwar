<?php

include '../connect.php';

if(isset($_COOKIE['admin_id'])){
   $admin_id = $_COOKIE['admin_id'];
} else {
   $admin_id = '';
   header('location:login.php');
   exit();
}

if(isset($_POST['delete'])){
   $delete_id = mysqli_real_escape_string($conn, $_POST['delete_id']);

   $verify_delete = mysqli_query($conn, "SELECT * FROM `messages` WHERE id = '$delete_id'");

   if(mysqli_num_rows($verify_delete) > 0){
      mysqli_query($conn, "DELETE FROM `messages` WHERE id = '$delete_id'");
      $success_msg[] = 'Message deleted!';
   } else {
      $warning_msg[] = 'Message deleted already!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Messages</title>

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <style>
      /* Import Google Font */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

:root {
    --primary-color: #2c3e50;
    --secondary-color: #34495e;
    --accent-color: #f39c12;
    --light-bg: #ecf0f1;
    --dark-bg: #222;
    --text-color: #333;
    --white: #fff;
    --border-radius: 10px;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background-color: var(--light-bg);
    color: var(--text-color);
}

/* Header */
.heading {
    text-align: center;
    font-size: 2rem;
    color: var(--primary-color);
    margin: 20px 0;
}

/* Search Form */
.search-form {
    display: flex;
    justify-content: center;
    margin: 20px 0;
}

.search-form input {
    width: 60%;
    max-width: 400px;
    padding: 10px;
    font-size: 1rem;
    border: 2px solid var(--primary-color);
    border-radius: var(--border-radius);
    outline: none;
}

.search-form button {
    padding: 10px 15px;
    background-color: var(--primary-color);
    color: var(--white);
    border: none;
    cursor: pointer;
    transition: 0.3s;
}

.search-form button:hover {
    background-color: var(--accent-color);
}

/* Message Container */
.box-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    padding: 20px;
}

/* Message Box */
.box {
    background: var(--white);
    padding: 20px;
    border-radius: var(--border-radius);
    box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.1);
    transition: 0.3s;
}

.box:hover {
    transform: translateY(-5px);
    box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2);
}

.box p {
    font-size: 1rem;
    margin-bottom: 10px;
}

.box a {
    color: var(--accent-color);
    text-decoration: none;
    font-weight: 600;
}

.box a:hover {
    text-decoration: underline;
}

/* Delete Button */
.delete-btn {
    display: inline-block;
    background-color: #e74c3c;
    color: var(--white);
    padding: 8px 12px;
    border: none;
    border-radius: var(--border-radius);
    font-size: 1rem;
    cursor: pointer;
    transition: 0.3s;
}

.delete-btn:hover {
    background-color: #c0392b;
}

/* Empty Message */
.empty {
    text-align: center;
    font-size: 1.2rem;
    color: var(--secondary-color);
    margin-top: 20px;
}

/* Responsive */
@media (max-width: 600px) {
    .search-form input {
        width: 80%;
    }

    .box-container {
        grid-template-columns: 1fr;
    }
}

   </style>
   <!-- Custom CSS -->
</head>
<body>
   
<!-- Header -->
<?php include '../Admin/admin_header.php'; ?>

<!-- Messages Section -->
<section class="grid">

   <h1 class="heading">Messages</h1>

   <form action="" method="POST" class="search-form">
      <input type="text" name="search_box" placeholder="Search messages..." maxlength="100" required>
      <button type="submit" class="fas fa-search" name="search_btn"></button>
   </form>

   <div class="box-container">

   <?php
      if(isset($_POST['search_box']) || isset($_POST['search_btn'])){
         $search_box = mysqli_real_escape_string($conn, $_POST['search_box']);
         $select_messages = mysqli_query($conn, "SELECT * FROM `messages` WHERE name LIKE '%$search_box%' OR number LIKE '%$search_box%' OR email LIKE '%$search_box%'");
      } else {
         $select_messages = mysqli_query($conn, "SELECT * FROM `messages`");
      }

      if(mysqli_num_rows($select_messages) > 0){
         while($fetch_messages = mysqli_fetch_assoc($select_messages)){
   ?>
   <div class="box">
      <p>Name: <span><?= $fetch_messages['name']; ?></span></p>
      <p>Email: <a href="mailto:<?= $fetch_messages['email']; ?>"><?= $fetch_messages['email']; ?></a></p>
      <p>Number: <a href="tel:<?= $fetch_messages['number']; ?>"><?= $fetch_messages['number']; ?></a></p>
      <p>Message: <span><?= $fetch_messages['message']; ?></span></p>
      <form action="" method="POST">
         <input type="hidden" name="delete_id" value="<?= $fetch_messages['id']; ?>">
         <input type="submit" value="Delete Message" onclick="return confirm('Delete this message?');" name="delete" class="delete-btn">
      </form>
   </div>
   <?php
      }
   } elseif(isset($_POST['search_box']) || isset($_POST['search_btn'])) {
      echo '<p class="empty">Results not found!</p>';
   } else {
      echo '<p class="empty">You have no messages!</p>';
   }
   ?>

   </div>

</section>

<!-- SweetAlert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<!-- Custom JS -->
<script src="../js/admin_script.js"></script>

<?php include '../Admin/message.php'; ?>

</body>
</html>
