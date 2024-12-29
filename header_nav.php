<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
include_once 'connect.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
    <link rel="stylesheet" href="/assets/css/navbar.css" />

  </head>
<body>
  <div class="section-six">
    <nav class="navbar">
        ChaarDiwaar
        <button  class="PostProperty-button"> <a href="post.php">POST PROPERTY</a></button>
        <div class="profile-dropdown">
          <div onclick="toggle()" class="profile-dropdown-btn">
            <div class="profile-img">
              <i class="fa-solid fa-circle"></i>
            </div>
  
            <span><?php
              if (isset($_SESSION['email'])) {
                  $email = $_SESSION['email'];
                  $query = mysqli_query($conn, "SELECT users.* FROM `users` WHERE users.email='$email'");
                  if(!$query){
                    echo "Error: ".mysqli_error($conn);
                  }
                  while ($row = mysqli_fetch_array($query)) {
                      echo $row['name'];
                  }
              }
              ?>
            </span>
          </div>
  
          <ul class="profile-dropdown-list">
            <li class="profile-dropdown-list-item">
              <a href="#">
                <i class="fa-regular fa-user"></i>
                Edit Profile
              </a>
            </li>
  
            <li class="profile-dropdown-list-item">
              <a href="#">
                <i class="fa-regular fa-envelope"></i>
                Inbox
              </a>
            </li>
  
            <li class="profile-dropdown-list-item">
              <a href="#">
                <i class="fa-solid fa-sliders"></i>
                Settings
              </a>
            </li>
  
            <li class="profile-dropdown-list-item">
              <a href="#">
                <i class="fa-regular fa-circle-question"></i>
                Help & Support
              </a>
            </li>
            <hr />
  
            <li class="profile-dropdown-list-item">
              <a href="logout.php">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                Log out
              </a>
            </li>
          </ul>
        </div>
      </nav>
    </div>

    </body>
<script src="/assets/js/homepage.js"></script>
</html>