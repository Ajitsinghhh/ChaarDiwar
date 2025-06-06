<?php
session_start(); // Start session

include 'connect.php';

// Check if user_id exists in session
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
}

include 'save_send.php';


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

    <style>
      /* General Styles */
      body {
          font-family: 'Poppins', sans-serif;
          margin: 0;
          padding: 0;
          background-color: #f8f9fa; /* Light gray background */
          color: #333; /* Dark gray text */
      }

      /* Listings Section */
      .listings {
          padding: 2rem;
          max-width: 1200px;
          margin: 0 auto;
      }

      .listings .heading {
          font-size: 2.5rem;
          text-align: center;
          color: #1a73e8; 
          font-weight: bold;
          margin-bottom: 2rem;
          text-transform: capitalize;
          position: relative;
      }

      .listings .heading::after {
          content: '';
          width: 80px;
          height: 3px;
          background: #1a73e8; 
          display: block;
          margin: 0.5rem auto;
      }

      /* Box Container Grid */
      .listings .box-container {
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
          gap: 1.5rem;
      }

      /* Individual Box */
      .listings .box {
          background: #ffffff; /* White background */
          border-radius: 12px;
          box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
          overflow: hidden;
          transition: transform 0.3s, box-shadow 0.3s;
          display: flex;
          flex-direction: column;
          justify-content: space-between;
      }

      .listings .box:hover {
          transform: translateY(-10px);
          box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
      }

      /* Thumbnail Section */
      .listings .thumb {
          position: relative;
          height: 200px;
          overflow: hidden;
      }

      .listings .thumb img {
          width: 100%;
          height: 100%;
          object-fit: cover;
          transition: transform 0.3s;
      }

      .listings .thumb img:hover {
          transform: scale(1.1);
      }

      .listings .thumb .total-images {
          position: absolute;
          top: 10px;
          right: 10px;
          background: rgba(0, 0, 0, 0.7);
          color: #ffffff;
          padding: 5px 12px;
          font-size: 0.85rem;
          border-radius: 15px;
      }

      /* Admin Section */
      .listings .admin {
          display: flex;
          align-items: center;
          padding: 1rem;
          background-color: #f1f3f4; /* Light gray */
          border-bottom: 1px solid #e0e0e0; /* Light gray border */
      }

      .listings .admin h3 {
          background: #1a73e8; /* DeepSeek blue */
          color: #ffffff;
          font-size: 1.4rem;
          width: 40px;
          height: 40px;
          display: flex;
          align-items: center;
          justify-content: center;
          border-radius: 50%;
          margin-right: 1rem;
      }

      .listings .admin div p {
          font-weight: bold;
          color: #333; /* Dark gray text */
          margin: 0;
      }

      .listings .admin div span {
          font-size: 0.85rem;
          color: #666; /* Medium gray */
      }

      /* Property Details */
      .listings .box .price {
          font-size: 1.5rem;
          font-weight: bold;
          color: #1a73e8; /* DeepSeek blue */
          padding: 1rem 1rem 0.5rem;
      }

      .listings .box .name {
          font-size: 1.2rem;
          font-weight: 600;
          margin: 0.5rem 1rem;
          color: #333; /* Dark gray text */
      }

      .listings .box .location {
          font-size: 0.9rem;
          color: #666; /* Medium gray */
          padding: 0 1rem 0.5rem;
      }

      .listings .flex {
          display: flex;
          flex-wrap: wrap;
          gap: 0.5rem;
          padding: 0.5rem 1rem;
      }

      .listings .flex p {
          display: flex;
          align-items: center;
          gap: 0.5rem;
          font-size: 0.85rem;
          color: #666; /* Medium gray */
      }

      /* Buttons */
      .listings .flex-btn {
          display: flex;
          justify-content: space-between;
          padding: 1rem;
      }

      .listings .btn {
          background: #1a73e8; 
          color: #ffffff;
          padding: 0.8rem 1.5rem;
          border: none;
          border-radius: 8px;
          text-transform: uppercase;
          font-size: 0.9rem;
          cursor: pointer;
          transition: background 0.3s, transform 0.3s;
      }

      .listings .btn:hover {
          background: #1557b0; /* Darker blue */
          transform: scale(1.05);
      }

      .listings .save {
          background: none;
          border: none;
          color: #ff6b6b; /* Red for save button */
          font-size: 1rem;
          cursor: pointer;
          display: flex;
          align-items: center;
          gap: 0.5rem;
      }

      .listings .save:hover {
          color: #d32f2f; /* Darker red on hover */
      }

      /* View All Button */
      .inline-btn {
          background: #1a73e8; /* DeepSeek blue */
          color: #ffffff;
          padding: 0.8rem 1.5rem;
          border-radius: 8px;
          text-transform: uppercase;
          text-decoration: none;
          transition: background 0.3s, transform 0.3s;
      }

      .inline-btn:hover {
          background: #1557b0; /* Darker blue */
          transform: scale(1.05);
      }

      /* Empty Message */
      .empty {
          text-align: center;
          font-size: 1.1rem;
          color: #666; /* Medium gray */
          margin-top: 1.5rem;
      }

      .empty .btn {
          margin-top: 1rem;
          background: #1a73e8; /* DeepSeek blue */
          color: white;
          padding: 0.8rem 1.5rem;
          border-radius: 8px;
          text-decoration: none;
          transition: background 0.3s;
      }

      .empty .btn:hover {
          background: #1557b0; /* Darker blue */
      }

      /* Hero Section */
      .hero {
          position: relative;
          width: 100%;
          height: 100vh;
          overflow: hidden;
      }

      .hero-image img {
          width: 100%;
          height: 100%;
          object-fit: cover;
      }

      /* Search Form */
      .search-form-container {
          position: absolute;
          top: 50%;
          left: 25%;
          transform: translate(-50%, -50%);
          width: 100%;
          max-width: 500px;
          padding: 20px;
          text-align: center;
      }

      .search-form-container form {
          display: flex;
          justify-content: center;
          align-items: center;
          gap: 10px;
          background-color: rgba(255, 255, 255, 0.9);
          padding: 20px;
          border-radius: 15px;
          box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      }

      .search-form-container input[type="text"] {
          width: 70%;
          padding: 12px 15px;
          border: 2px solid #ddd;
          border-radius: 25px;
          font-size: 16px;
          outline: none;
          transition: border-color 0.3s ease, box-shadow 0.3s ease;
      }

      .search-form-container input[type="text"]:focus {
          border-color: #1a73e8; /* DeepSeek blue */
          box-shadow: 0 0 8px rgba(26, 115, 232, 0.3);
      }

      .search-form-container button[type="submit"] {
          padding: 12px 25px;
          background-color: #1a73e8; /* DeepSeek blue */
          color: white;
          border: none;
          border-radius: 25px;
          font-size: 16px;
          cursor: pointer;
          transition: background-color 0.3s ease, transform 0.2s ease;
      }

      .search-form-container button[type="submit"]:hover {
          background-color: #1557b0; /* Darker blue */
          transform: scale(1.05);
      }

      /* Chatbot Icon */
      .chatbot-icon {
          position: fixed;
          bottom: 20px;
          right: 20px;
          z-index: 1000;
      }

      .chatbot-icon img {
          width: 250px;
          height: auto;
          cursor: pointer;
          transition: transform 0.3s ease;
      }

      .chatbot-icon img:hover {
          transform: scale(1.1);
      }

    </style>

  </head>
<body>
  <div class="section-six">
    <nav class="navbar">
        MoovIN
        <button  class="ForPropertyOwner-button"> <a href="post.php">FOR PROPERTY OWNER</a></button>
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
              <a href="update.php">
                <i class="fa-regular fa-user"></i>
                Edit Profile
              </a>
            </li>
  
            <li class="profile-dropdown-list-item">
              <a href="request.php">
                <i class="fa-regular fa-envelope"></i>
                Inbox
              </a>
            </li>
  
            <li class="profile-dropdown-list-item">
              <a href="my_listings.php">
                <i class="fa-solid fa-sliders"></i>
                My Listings
              </a>
            </li>

            <li class="profile-dropdown-list-item">
              <a href="saved.php">
                <i class="fa-solid fa-sliders"></i>
                Saved
              </a>
            </li>
  
            <li class="profile-dropdown-list-item">
              <a href="#">
                <i class="fa-regular fa-circle-question"></i>
                Contact Us
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

    <section class="hero">
    <div class="hero-image">
        <img src="assets/images/Screenshot 2024-12-08 204457-Photoroom.png" alt="house image">
        <div class="search-form-container">
            <form action="search.php" method="GET">
                <input type="text" name="location" placeholder="Enter location..." required>
                <button type="submit">Search</button>
            </form>
        </div>
    </div>
</section>
<!-- Chatbot Icon with Link -->
<div class="chatbot-icon">
    <a href="/chatbot/chat.html" target="_blank">
        <img src="assets/images/chatbot-removebg-preview.png" alt="Chatbot">
    </a>
</div>


  <!--Hero Section end-->


  <section class="listings">

   <h1 class="heading">Latest Listings</h1>

   <div class="box-container">
      <?php
         $total_images = 0;
         // Query to fetch properties
         $select_properties = mysqli_query($conn, "SELECT * FROM `property` ORDER BY date DESC LIMIT 6");

         if(mysqli_num_rows($select_properties) > 0){
            while($fetch_property = mysqli_fetch_assoc($select_properties)){

            // Fetch user details
            $user_id_property = $fetch_property['user_id'];
            $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id_property'");
            $fetch_user = mysqli_fetch_assoc($select_user);

            // Calculate the total images
            $total_images = 1; // Count `image_01` as default
            for($i = 2; $i <= 5; $i++) {
               $image_field = "image_0$i";
               if(!empty($fetch_property[$image_field])){
                  $total_images++;
               }
            }

            // Check if the property is saved
            $property_id = $fetch_property['id'];
            $check_saved = mysqli_query($conn, "SELECT * FROM `saved` WHERE property_id = '$property_id' AND user_id = '$user_id'");
      ?>
      <form action="" method="POST">
         <div class="box">
            <input type="hidden" name="property_id" value="<?= htmlspecialchars($property_id); ?>">
            <?php
               if(mysqli_num_rows($check_saved) > 0){
            ?>
            <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>Saved</span></button>
            <?php
               }else{ 
            ?>
            <button type="submit" name="save" class="save"><i class="far fa-heart"></i><span>Save</span></button>
            <?php
               }
            ?>
            <div class="thumb">
               <p class="total-images"><i class="far fa-image"></i><span><?= $total_images; ?></span></p> 
               <img src="uploaded_files/<?= htmlspecialchars($fetch_property['image_01']); ?>" alt="">
            </div>
            <div class="admin">
               <h3><?= htmlspecialchars(substr($fetch_user['name'], 0, 1)); ?></h3>
               <div>
                  <p><?= htmlspecialchars($fetch_user['name']); ?></p>
                  <span><?= htmlspecialchars($fetch_property['date']); ?></span>
               </div>
            </div>
         </div>
         <div class="box">
            <div class="price"><i class="fas fa-indian-rupee-sign"></i><span><?= htmlspecialchars($fetch_property['price']); ?></span></div>
            <h3 class="name"><?= htmlspecialchars($fetch_property['property_name']); ?></h3>
            <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= htmlspecialchars($fetch_property['address']); ?></span></p>
            <div class="flex">
               <p><i class="fas fa-house"></i><span><?= htmlspecialchars($fetch_property['type']); ?></span></p>
               <p><i class="fas fa-tag"></i><span><?= htmlspecialchars($fetch_property['offer']); ?></span></p>
               <p><i class="fas fa-bed"></i><span><?= htmlspecialchars($fetch_property['bhk']); ?> BHK</span></p>
               <p><i class="fas fa-trowel"></i><span><?= htmlspecialchars($fetch_property['status']); ?></span></p>
               <p><i class="fas fa-couch"></i><span><?= htmlspecialchars($fetch_property['furnished']); ?></span></p>
               <p><i class="fas fa-maximize"></i><span><?= htmlspecialchars($fetch_property['carpet']); ?> sqft</span></p>
            </div>
            <div class="flex-btn">
               <a href="view_property.php?get_id=<?= htmlspecialchars($fetch_property['id']); ?>" class="btn">View Property</a>
               <input type="submit" value="Send Enquiry" name="send" class="btn">
            </div>
         </div>
      </form>
      <?php
         }
      }else{
         echo '<p class="empty">No properties added yet! <a href="post_property.php" style="margin-top:1.5rem;" class="btn">Add New</a></p>';
      }
      ?>
      
   </div>

   <div style="margin-top: 2rem; text-align:center;">
      <a href="listings.php" class="inline-btn">View All</a>
   </div>

</section>

      
</body>
<script src="/assets/js/homepage.js"></script>
</html>