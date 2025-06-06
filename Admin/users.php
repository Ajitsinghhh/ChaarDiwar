<?php
include '../connect.php';

if (isset($_COOKIE['admin_id'])) {
    $admin_id = $_COOKIE['admin_id'];
} else {
    $admin_id = '';
    header('location:login.php');
    exit();
}

if (isset($_POST['delete'])) {
    $delete_id = mysqli_real_escape_string($conn, $_POST['delete_id']);

    $verify_delete = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$delete_id'");
    
    if (mysqli_num_rows($verify_delete) > 0) {
        $select_images = mysqli_query($conn, "SELECT * FROM `property` WHERE user_id = '$delete_id'");
        
        while ($fetch_images = mysqli_fetch_assoc($select_images)) {
            foreach (['image_01', 'image_02', 'image_03', 'image_04', 'image_05'] as $img) {
                if (!empty($fetch_images[$img])) {
                    unlink('../uploaded_files/' . $fetch_images[$img]);
                }
            }
        }
        
        mysqli_query($conn, "DELETE FROM `property` WHERE user_id = '$delete_id'");
        mysqli_query($conn, "DELETE FROM `requests` WHERE sender = '$delete_id' OR receiver = '$delete_id'");
        mysqli_query($conn, "DELETE FROM `saved` WHERE user_id = '$delete_id'");
        mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'");
        
        $success_msg[] = 'User deleted!';
    } else {
        $warning_msg[] = 'User already deleted!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Users</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <style>
    /* Import Google Fonts */
/* Import Google Font */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

:root {
    --primary-color: #4a90e2;
    --secondary-color: #222;
    --light-bg: #f9f9f9;
    --dark-bg: #1a1a1a;
    --border-radius: 10px;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background: var(--light-bg);
    color: var(--secondary-color);
}

/* Grid Layout */
.grid {
    max-width: 1100px;
    margin: 40px auto;
    padding: 20px;
    text-align: center;
}

.heading {
    font-size: 2rem;
    color: var(--primary-color);
    margin-bottom: 20px;
    text-transform: uppercase;
}

/* Search Bar */
.search-form {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

.search-form input {
    width: 60%;
    padding: 12px;
    border-radius: var(--border-radius) 0 0 var(--border-radius);
    border: 2px solid var(--primary-color);
    outline: none;
    font-size: 16px;
}

.search-form button {
    padding: 12px 15px;
    background: var(--primary-color);
    color: #fff;
    border: 2px solid var(--primary-color);
    border-radius: 0 var(--border-radius) var(--border-radius) 0;
    cursor: pointer;
    font-size: 16px;
}

.search-form button:hover {
    background: #357abd;
}

/* Users Box Container */
.box-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

/* User Box */
.box {
    background: #fff;
    padding: 20px;
    border-radius: var(--border-radius);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: 0.3s;
    position: relative;
}

.box:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.box p {
    font-size: 15px;
    margin: 8px 0;
    color: var(--secondary-color);
}

.box span {
    font-weight: 600;
    color: var(--primary-color);
}

.box a {
    text-decoration: none;
    color: var(--secondary-color);
    font-weight: 500;
}

.box a:hover {
    color: var(--primary-color);
}

/* Delete Button */
.delete-btn {
    background: crimson;
    color: white;
    padding: 10px 15px;
    border-radius: var(--border-radius);
    border: none;
    cursor: pointer;
    font-size: 14px;
    transition: 0.3s;
    display: inline-block;
    margin-top: 10px;
}

.delete-btn:hover {
    background: darkred;
}

/* Empty Message */
.empty {
    font-size: 18px;
    color: #999;
    text-align: center;
    margin-top: 20px;
}

/* Responsive */
@media (max-width: 768px) {
    .search-form input {
        width: 80%;
    }

    .box-container {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    }
}


   </style>
</head>
<body>

<?php include '../Admin/admin_header.php'; ?>

<section class="grid">
   <h1 class="heading">Users</h1>
   <form action="" method="POST" class="search-form">
      <input type="text" name="search_box" placeholder="Search users..." maxlength="100" required>
      <button type="submit" class="fas fa-search" name="search_btn"></button>
   </form>

   <div class="box-container">
   <?php
      if (isset($_POST['search_box']) || isset($_POST['search_btn'])) {
          $search_box = mysqli_real_escape_string($conn, $_POST['search_box']);
          $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE name LIKE '%$search_box%' OR number LIKE '%$search_box%' OR email LIKE '%$search_box%'");
      } else {
          $select_users = mysqli_query($conn, "SELECT * FROM `users`");
      }

      if (mysqli_num_rows($select_users) > 0) {
          while ($fetch_users = mysqli_fetch_assoc($select_users)) {
              $user_id = $fetch_users['id'];
              $count_property = mysqli_query($conn, "SELECT * FROM `property` WHERE user_id = '$user_id'");
              $total_properties = mysqli_num_rows($count_property);
   ?>
   <div class="box">
      <p>Name: <span><?= htmlspecialchars($fetch_users['name']); ?></span></p>
      <p>Number: <a href="tel:<?= htmlspecialchars($fetch_users['number']); ?>"><?= htmlspecialchars($fetch_users['number']); ?></a></p>
      <p>Email: <a href="mailto:<?= htmlspecialchars($fetch_users['email']); ?>"><?= htmlspecialchars($fetch_users['email']); ?></a></p>
      <p>Properties Listed: <span><?= $total_properties; ?></span></p>
      <form action="" method="POST">
         <input type="hidden" name="delete_id" value="<?= $fetch_users['id']; ?>">
         <input type="submit" value="Delete User" onclick="return confirm('Delete this user?');" name="delete" class="delete-btn">
      </form>
   </div>
   <?php
      }
   } elseif (isset($_POST['search_box']) || isset($_POST['search_btn'])) {
      echo '<p class="empty">Results not found!</p>';
   } else {
      echo '<p class="empty">No user accounts added yet!</p>';
   }
   ?>
   </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/admin_script.js"></script>
<?php include '../Admin/message.php'; ?>
</body>
</html>
