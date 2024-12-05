<?php
session_start();
include("connect.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
    <link rel="stylesheet" href="/assets/css/homepage.css" />
    <link rel="stylesheet" href="/assets/css/style.css">

  </head>
<body>
  <div class="section-six">
    <nav class="navbar">
        ChaarDiwaar
        <button  class="ForPropertyOwner-button"> <a href="#">FOR PROPERTY OWNER</a></button>
        <div class="profile-dropdown">
          <div onclick="toggle()" class="profile-dropdown-btn">
            <div class="profile-img">
              <i class="fa-solid fa-circle"></i>
            </div>
  
            <span><?php
              if (isset($_SESSION['email'])) {
                  $email = $_SESSION['email'];
                  $query = mysqli_query($conn, "SELECT users.* FROM `users` WHERE users.email='$email'");
                  while ($row = mysqli_fetch_array($query)) {
                      echo $row['firstName'] ;
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

      <!--Hero Section start-->
  <section class="hero">
    <div class="hero-text">
      <h1>
        Easiest way to find your dream place
      </h1>
      <p>
        this is where you can find a dream place for you of various types, all over the world at affordable prices.
      </p>

      <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
        <input type="text" class="form-control" placeholder="Search" aria-label="Search"
          aria-describedby="basic-addon1">
      </div>
    </div>
    <div class="hero-image">
      <img src="assets/images/house1-removebg-preview.png" alt="house image">
    </div>
  </section>
  <!--Hero Section end-->

</body>
<script src="/assets/js/homepage.js"></script>
</html>