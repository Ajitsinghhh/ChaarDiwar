<?php

include '../connect.php';

if(isset($_COOKIE['admin_id'])){
   $admin_id = $_COOKIE['admin_id'];
} else {
   $admin_id = '';
   header('location:login.php');
   exit;
}

// Fetch admin details
$query = "SELECT * FROM `admins` WHERE id = ? LIMIT 1";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $admin_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$fetch_profile = mysqli_fetch_assoc($result);

if(isset($_POST['submit'])){

   $name = trim($_POST['name']);
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   if(!empty($name)){
      $query = "SELECT * FROM `admins` WHERE name = ?";
      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, "s", $name);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);

      if(mysqli_stmt_num_rows($stmt) > 0){
         $warning_msg[] = 'Username already taken!';
      } else {
         $query = "UPDATE `admins` SET name = ? WHERE id = ?";
         $stmt = mysqli_prepare($conn, $query);
         mysqli_stmt_bind_param($stmt, "si", $name, $admin_id);
         mysqli_stmt_execute($stmt);
         $success_msg[] = 'Username updated!';
      }
   }

   $empty_pass = sha1('');
   $prev_pass = $fetch_profile['password'];
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $c_pass = sha1($_POST['c_pass']);
   $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING);

   if($old_pass !== $empty_pass){
      if($old_pass !== $prev_pass){
         $warning_msg[] = 'Old password not matched!';
      } elseif($c_pass !== $new_pass){
         $warning_msg[] = 'New password not matched!';
      } else {
         if($new_pass !== $empty_pass){
            $query = "UPDATE `admins` SET password = ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "si", $c_pass, $admin_id);
            mysqli_stmt_execute($stmt);
            $success_msg[] = 'Password updated!';
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
   <title>Update Profile</title>

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- Custom CSS -->
    <style>
        /* General Styles */
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f4f7f6;
    margin: 0;
    padding: 0;
    color: #333;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

/* Form Container */
.form-container {
    background: #ffffff;
    padding: 2.5rem;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    text-align: center;
    animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Form Heading */
.form-container h3 {
    font-size: 1.8rem;
    color: #2c3e50;
    margin-bottom: 1.5rem;
    font-weight: 600;
}

/* Input Fields */
.form-container .box {
    width: 100%;
    padding: 0.8rem;
    margin: 0.8rem 0;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 1rem;
    color: #333;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.form-container .box:focus {
    border-color: #4caf50;
    outline: none;
    box-shadow: 0 0 8px rgba(76, 175, 80, 0.3);
}

/* Submit Button */
.form-container .btn {
    width: 100%;
    padding: 0.8rem;
    background-color: #4caf50;
    color: #ffffff;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.form-container .btn:hover {
    background-color: #388e3c;
    transform: translateY(-2px);
}

.form-container .btn:active {
    transform: translateY(0);
}

/* Placeholder Styling */
.form-container .box::placeholder {
    color: #999;
}

/* Responsive Design */
@media (max-width: 480px) {
    .form-container {
        padding: 1.5rem;
    }

    .form-container h3 {
        font-size: 1.5rem;
    }

    .form-container .box {
        padding: 0.7rem;
        font-size: 0.9rem;
    }

    .form-container .btn {
        padding: 0.7rem;
        font-size: 0.9rem;
    }
}

/* SweetAlert Customization */
.swal2-popup {
    font-family: 'Poppins', sans-serif;
    border-radius: 10px;
}

.swal2-title {
    font-size: 1.2rem;
    color: #2c3e50;
}

.swal2-confirm {
    background-color: #4caf50 !important;
    border: none !important;
    border-radius: 8px !important;
    padding: 0.6rem 1.2rem !important;
    font-size: 1rem !important;
    transition: background-color 0.3s ease !important;
}

.swal2-confirm:hover {
    background-color: #388e3c !important;
}
    </style>
</head>
<body>

<!-- Header -->
<?php include '../Admin/admin_header.php'; ?>

<!-- Update Section -->
<section class="form-container">
   <form action="" method="POST">
      <h3>Update Profile</h3>
      <input type="text" name="name" placeholder="<?= htmlspecialchars($fetch_profile['name']); ?>" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="old_pass" placeholder="Enter old password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" placeholder="Enter new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="c_pass" placeholder="Confirm new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Update Now" name="submit" class="btn">
   </form>
</section>

<!-- SweetAlert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- Custom JS -->
<script>
    let header = document.querySelector('.header');

document.querySelector('#menu-btn').onclick = () =>{
   header.classList.add('active');
}

document.querySelector('#close-btn').onclick = () =>{
   header.classList.remove('active');
}

window.onscroll = () =>{
   header.classList.remove('active');
}

document.querySelectorAll('input[type="number"]').forEach(inputNumbmer => {
   inputNumbmer.oninput = () =>{
      if(inputNumbmer.value.length > inputNumbmer.maxLength) inputNumbmer.value = inputNumbmer.value.slice(0, inputNumbmer.maxLength);
   }
});
</script>

<?php include '../Admin/message.php'; ?>
</body>
</html>
