<?php
include '../connect.php';
if(isset($_POST['submit'])){
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING); 
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING); 

   $query = "SELECT * FROM `admins` WHERE name = ? AND password = ? LIMIT 1";
   $stmt = mysqli_prepare($conn, $query);
   mysqli_stmt_bind_param($stmt, "ss", $name, $pass);
   mysqli_stmt_execute($stmt);
   $result = mysqli_stmt_get_result($stmt);

   if(mysqli_num_rows($result) > 0){
      $row = mysqli_fetch_assoc($result);
      setcookie('admin_id', $row['id'], time() + 60*60*24*30, '/');
      header('location:dashboard.php');
   }else{
      $warning_msg[] = 'Incorrect username or password!';
   }
   mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <style>
    /* General Styles */
/* General Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: #0f0f0f;
    color: #fff;
    padding: 40px 0; /* Added padding for top and bottom margin */
}

/* Form Container */
.form-container {
    width: 100%;
    max-width: 320px; /* Reduced width to fit display elements */
    padding: 20px;
    background: rgba(0, 0, 0, 0.9);
    border-radius: 12px;
    box-shadow: 0 0 10px rgba(0, 255, 255, 0.5);
    text-align: center;
    position: relative;
    overflow: hidden;
    margin: 20px 0; /* Added margin from top and bottom */
}

/* Neon Border Animation */
.form-container::before {
    content: "";
    position: absolute;
    top: -5px;
    left: -5px;
    right: -5px;
    bottom: -12px;
    background: linear-gradient(45deg, cyan, magenta);
    z-index: -1;
    filter: blur(12px);
}

/* Heading */
.form-container h3 {
    font-size: 20px; /* Slightly reduced */
    margin-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #00eaff;
}

/* Default Credentials */
.form-container p {
    font-size: 13px;
    color: #ccc;
    margin-bottom: 15px;
}

.form-container p span {
    font-weight: bold;
    color: #ff0077;
}

/* Input Fields */
.form-container .box {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
    border: 2px solid #00eaff;
    border-radius: 6px;
    font-size: 14px;
    background: transparent;
    color: #fff;
    outline: none;
    transition: 0.3s;
    text-align: center;
}

.form-container .box::placeholder {
    color: rgba(255, 255, 255, 0.5);
}

.form-container .box:focus {
    border-color: #ff0077;
    box-shadow: 0 0 8px #ff0077;
}

/* Login Button */
.form-container .btn {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    background: linear-gradient(90deg, #ff0077, #00eaff);
    color: #fff;
    font-size: 16px;
    font-weight: bold;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.3s;
    text-transform: uppercase;
}

.form-container .btn:hover {
    background: linear-gradient(90deg, #00eaff, #ff0077);
    box-shadow: 0 0 10px rgba(0, 255, 255, 0.5);
}

/* Responsive */
@media (max-width: 450px) {
    .form-container {
        max-width: 85%;
        padding: 15px;
    }
}
</style>
</head>
<body style="padding-left: 0;">

<!-- login section starts  -->

<section class="form-container" style="min-height: 100vh;">

   <form action="" method="POST">
      <h3>welcome back!</h3>
      <p>default name = <span>admin</span> & password = <span>111</span></p>
      <input type="text" name="name" placeholder="enter username" maxlength="20" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" placeholder="enter password" maxlength="20" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="login now" name="submit" class="btn">
   </form>
 
</section>

<!-- login section ends -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

</body>
</html>
