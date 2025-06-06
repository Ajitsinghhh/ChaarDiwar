<?php

include '../connect.php';

if(isset($_COOKIE['admin_id'])){
   $admin_id = $_COOKIE['admin_id'];
} else {
   $admin_id = '';
   header('location:login.php');
   exit();
}

if(isset($_POST['delete'])) {
   $delete_id = mysqli_real_escape_string($conn, $_POST['delete_id']);

   $verify_delete = mysqli_query($conn, "SELECT * FROM `admins` WHERE id = '$delete_id'");

   if(mysqli_num_rows($verify_delete) > 0){
      mysqli_query($conn, "DELETE FROM `admins` WHERE id = '$delete_id'");
      $success_msg[] = 'Admin deleted!';
   } else {
      $warning_msg[] = 'Admin already deleted!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admins</title>

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <!-- Custom CSS -->
    <style>
        /* Import Google Font */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

:root {
    --primary-color: #007bff;
    --secondary-color: #0056b3;
    --danger-color: #dc3545;
    --success-color: #28a745;
    --light-bg: #f8f9fa;
    --dark-bg: #343a40;
    --border-radius: 8px;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background-color: var(--light-bg);
    color: #333;
    padding-top: 80px; /* Adjust for fixed header */
}

/* Header */
header {
    background: var(--dark-bg);
    color: white;
    padding: 15px 30px;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

header a {
    color: white;
    text-decoration: none;
    font-weight: 500;
}

header a:hover {
    color: var(--primary-color);
}

/* Section */
section.grid {
    max-width: 1000px;
    margin: 30px auto;
    padding: 20px;
    background: white;
    border-radius: var(--border-radius);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

/* Heading */
.heading {
    text-align: center;
    font-size: 2rem;
    font-weight: 600;
    color: var(--primary-color);
    margin-bottom: 20px;
}

/* Search Form */
.search-form {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-bottom: 20px;
}

.search-form input {
    width: 70%;
    padding: 10px;
    border: 2px solid var(--primary-color);
    border-radius: var(--border-radius);
    font-size: 1rem;
}

.search-form button {
    background: var(--primary-color);
    color: white;
    padding: 10px 15px;
    border: none;
    cursor: pointer;
    font-size: 1.2rem;
    border-radius: var(--border-radius);
}

.search-form button:hover {
    background: var(--secondary-color);
}

/* Admin Boxes */
.box-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.box {
    background: var(--light-bg);
    padding: 15px;
    border-radius: var(--border-radius);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.box p {
    font-size: 1rem;
    margin-bottom: 10px;
    color: #333;
}

.box span {
    font-weight: bold;
    color: var(--primary-color);
}

/* Buttons */
.btn, .option-btn, .delete-btn {
    display: inline-block;
    padding: 10px 15px;
    font-size: 1rem;
    text-decoration: none;
    border-radius: var(--border-radius);
    margin-top: 10px;
    cursor: pointer;
    transition: 0.3s;
}

.btn {
    background: var(--primary-color);
    color: white;
}

.btn:hover {
    background: var(--secondary-color);
}

.option-btn {
    background: var(--success-color);
    color: white;
}

.option-btn:hover {
    background: #218838;
}

.delete-btn {
    background: var(--danger-color);
    color: white;
    border: none;
}

.delete-btn:hover {
    background: #c82333;
}

/* Empty Message */
.empty {
    text-align: center;
    font-size: 1.2rem;
    color: var(--danger-color);
    margin-top: 20px;
}

/* Responsive */
@media (max-width: 768px) {
    .search-form input {
        width: 100%;
    }

    .box-container {
        grid-template-columns: 1fr;
    }
}

    </style>
</head>
<body>
   
<!-- Header -->
<?php include '../Admin/admin_header.php'; ?>

<!-- Admins Section -->
<section class="grid">

   <h1 class="heading">Admins</h1>

   <form action="" method="POST" class="search-form">
      <input type="text" name="search_box" placeholder="Search admins..." maxlength="100" required>
      <button type="submit" class="fas fa-search" name="search_btn"></button>
   </form>

   <div class="box-container">

   <?php
      if(isset($_POST['search_box']) || isset($_POST['search_btn'])){
         $search_box = mysqli_real_escape_string($conn, $_POST['search_box']);
         $select_admins = mysqli_query($conn, "SELECT * FROM `admins` WHERE name LIKE '%$search_box%'");
      } else {
         $select_admins = mysqli_query($conn, "SELECT * FROM `admins`");
      }

      if(mysqli_num_rows($select_admins) > 0){
         while($fetch_admins = mysqli_fetch_assoc($select_admins)){
   ?>
   <?php if( $fetch_admins['id'] == $admin_id){ ?>
   <div class="box" style="order: -1;">
      <p>Name: <span><?= $fetch_admins['name']; ?></span></p>
      <a href="update.php" class="option-btn">Update Account</a>
      <a href="register.php" class="btn">Register New</a>
   </div>
   <?php } else { ?>
   <div class="box">
      <p>Name: <span><?= $fetch_admins['name']; ?></span></p>
      <form action="" method="POST">
         <input type="hidden" name="delete_id" value="<?= $fetch_admins['id']; ?>">
         <input type="submit" value="Delete Admin" onclick="return confirm('Delete this admin?');" name="delete" class="delete-btn">
      </form>
   </div>
   <?php } ?>
   <?php
      }
   } elseif(isset($_POST['search_box']) || isset($_POST['search_btn'])) {
      echo '<p class="empty">No results found!</p>';
   } else {
   ?>
      <p class="empty">No admins added yet!</p>
      <div class="box" style="text-align: center;">
         <p>Create a new admin</p>
         <a href="register.php" class="btn">Register Now</a>
      </div>
   <?php
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
