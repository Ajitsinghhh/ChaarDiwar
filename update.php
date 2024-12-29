<?php
session_start();
include 'connect.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:login.php');
    exit;
}

// Fetch user details
$query = "SELECT * FROM `users` WHERE id = '$user_id' LIMIT 1";
$result = mysqli_query($conn, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $fetch_user = mysqli_fetch_assoc($result);
} else {
    header('location:login.php');
    exit;
}

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, filter_var($_POST['name'], FILTER_SANITIZE_STRING));
    $number = mysqli_real_escape_string($conn, filter_var($_POST['number'], FILTER_SANITIZE_STRING));
    $email = mysqli_real_escape_string($conn, filter_var($_POST['email'], FILTER_SANITIZE_STRING));

    if (!empty($name)) {
        $update_name_query = "UPDATE `users` SET name = '$name' WHERE id = '$user_id'";
        mysqli_query($conn, $update_name_query);
        $success_msg[] = 'Name updated!';
    }

    if (!empty($email)) {
        $verify_email_query = "SELECT email FROM `users` WHERE email = '$email'";
        $verify_email_result = mysqli_query($conn, $verify_email_query);
        if (mysqli_num_rows($verify_email_result) > 0) {
            $warning_msg[] = 'Email already taken!';
        } else {
            $update_email_query = "UPDATE `users` SET email = '$email' WHERE id = '$user_id'";
            mysqli_query($conn, $update_email_query);
            $success_msg[] = 'Email updated!';
        }
    }

    if (!empty($number)) {
        $verify_number_query = "SELECT number FROM `users` WHERE number = '$number'";
        $verify_number_result = mysqli_query($conn, $verify_number_query);
        if (mysqli_num_rows($verify_number_result) > 0) {
            $warning_msg[] = 'Number already taken!';
        } else {
            $update_number_query = "UPDATE `users` SET number = '$number' WHERE id = '$user_id'";
            mysqli_query($conn, $update_number_query);
            $success_msg[] = 'Number updated!';
        }
    }

    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    $prev_pass = $fetch_user['password'];
    $old_pass = sha1($_POST['old_pass']);
    $new_pass = sha1($_POST['new_pass']);
    $c_pass = sha1($_POST['c_pass']);

    if ($old_pass != $empty_pass) {
        if ($old_pass != $prev_pass) {
            $warning_msg[] = 'Old password not matched!';
        } elseif ($new_pass != $c_pass) {
            $warning_msg[] = 'Confirm password not matched!';
        } else {
            if ($new_pass != $empty_pass) {
                $update_pass_query = "UPDATE `users` SET password = '$c_pass' WHERE id = '$user_id'";
                mysqli_query($conn, $update_pass_query);
                $success_msg[] = 'Password updated successfully!';
            } else {
                $warning_msg[] = 'Please enter a new password!';
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
<style>
     body {
         font-family: 'Roboto', sans-serif;
         background: #f0f2f5;
         margin: 0;
         padding: 0;
      }


      .form-container {
         background: #fff;
         padding: 30px;
         border-radius: 10px;
         box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
         max-width: 400px;
         width: 100%;
         margin: 20px auto 0; /* Adjusted margin to account for fixed navbar */
      }

      .form-container h3 {
         margin-bottom: 20px;
         font-size: 24px;
         color: #333;
         text-align: center;
      }

      .form-container .box {
         width: 100%;
         padding: 10px;
         margin: 5px 0;
         border: 1px solid #ccc;
         border-radius: 5px;
         font-size: 16px;
      }

      .form-container .btn {
         width: 100%;
         padding: 10px;
         border: none;
         border-radius: 5px;
         background: #007bff;
         color: #fff;
         font-size: 18px;
         cursor: pointer;
         transition: background 0.3s;
      }

      .form-container .btn:hover {
         background: #0056b3;
      }

      .form-container .box::placeholder {
         color: #999;
      }
   </style>
</head>
<body>
   
<?php include 'header_nav.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>update your account!</h3>
      <input type="tel" name="name" maxlength="50" placeholder="<?= $fetch_user['name']; ?>" class="box">
      <input type="email" name="email" maxlength="50" placeholder="<?= $fetch_user['email']; ?>" class="box">
      <input type="number" name="number" min="0" max="9999999999" maxlength="10" placeholder="<?= $fetch_user['number']; ?>" class="box">
      <input type="password" name="old_pass" maxlength="20" placeholder="enter your old password" class="box">
      <input type="password" name="new_pass" maxlength="20" placeholder="enter your new password" class="box">
      <input type="password" name="c_pass" maxlength="20" placeholder="confirm your new password" class="box">
      <input type="submit" value="update now" name="submit" class="btn">
   </form>

</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

</body>
</html>