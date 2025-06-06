<?php
session_start(); // Start the session

// Include database connection
include './connect.php'; // Ensure this file initializes a MySQLi connection as $conn

// Check if the user is logged in using sessions
if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
}

// Check if the property ID is provided in the URL
if (isset($_GET['get_id'])) {
   $get_id = $_GET['get_id'];
   error_log("Received Property ID: " . $get_id); // Debugging statement to log the property ID
} else {
   $get_id = '';
   header('location: homepage.php'); // Redirect if no property ID is provided
   exit();
}

// Include save and send functionality
include './save_send.php'; // Ensure this file is updated to use MySQLi
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>View Property</title>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <style>
      /* General Styles */
      body {
         font-family: 'Poppins', sans-serif;
         background-color: #f4f4f9;
         color: #333;
         margin: 0;
         padding: 0;
         line-height: 1.6;
      }

      .heading {
         text-align: center;
         font-size: 2.5rem;
         color: #2c3e50;
         margin-bottom: 2rem;
         text-transform: uppercase;
         letter-spacing: 2px;
         font-weight: 700;
      }

      /* View Property Section */
      .view-property {
         padding: 2rem 5%;
         max-width: 1200px;
         margin: 0 auto;
      }

      .details {
         background: #fff;
         border-radius: 15px;
         box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
         padding: 2rem;
         margin-bottom: 2rem;
         transition: transform 0.3s ease, box-shadow 0.3s ease;
      }

      .details:hover {
         transform: translateY(-5px);
         box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
      }

      /* Swiper Image Container */
      .images-container {
         width: 100%;
         height: 400px;
         border-radius: 15px;
         overflow: hidden;
         margin-bottom: 2rem;
         position: relative;
      }

      .images-container .swiper-slide {
         width: 100%;
         height: 100%;
         object-fit: cover;
      }

      .images-container .swiper-pagination {
         bottom: 20px;
      }

      .images-container .swiper-pagination-bullet {
         background: #fff;
         opacity: 0.7;
         width: 10px;
         height: 10px;
         margin: 0 5px;
         transition: all 0.3s ease;
      }

      .images-container .swiper-pagination-bullet-active {
         background: #ff6b6b;
         opacity: 1;
         transform: scale(1.2);
      }

      /* Property Name and Location */
      .name {
         font-size: 2rem;
         color: #2c3e50;
         margin-bottom: 1rem;
         font-weight: 700;
      }

      .location {
         font-size: 1.2rem;
         color: #666;
         margin-bottom: 1.5rem;
      }

      .location i {
         color: #ff6b6b;
         margin-right: 0.5rem;
      }

      /* Property Info */
      .info {
         display: flex;
         flex-wrap: wrap;
         gap: 1.5rem;
         margin-bottom: 2rem;
      }

      .info p {
         flex: 1 1 200px;
         font-size: 1rem;
         color: #555;
      }

      .info i {
         color: #ff6b6b;
         margin-right: 0.5rem;
      }

      /* Flex Boxes for Details */
      .flex {
         display: flex;
         gap: 2rem;
         margin-bottom: 2rem;
      }

      .box {
         flex: 1;
         background: #f9f9f9;
         padding: 1.5rem;
         border-radius: 10px;
         box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      }

      .box p {
         font-size: 0.95rem;
         color: #555;
         margin-bottom: 0.75rem;
      }

      .box i {
         color: #ff6b6b;
         margin-right: 0.5rem;
      }

      /* Amenities Section */
      .title {
         font-size: 1.5rem;
         color: #2c3e50;
         margin-bottom: 1rem;
         font-weight: 600;
      }

      .amenities .box {
         background: #fff;
         padding: 1rem;
         border-radius: 10px;
         box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      }

      .amenities i {
         color: #ff6b6b;
         margin-right: 0.5rem;
      }

      /* Description */
      .description {
         font-size: 1rem;
         color: #555;
         line-height: 1.8;
         margin-bottom: 2rem;
      }

      /* Save and Enquiry Buttons */
      .flex-btn {
         display: flex;
         gap: 1rem;
         justify-content: flex-start;
      }

      .save, .btn {
         padding: 0.75rem 1.5rem;
         border: none;
         border-radius: 25px;
         font-size: 1rem;
         cursor: pointer;
         transition: all 0.3s ease;
         display: flex;
         align-items: center;
         gap: 0.5rem;
      }

      .save {
         background: #ff6b6b;
         color: #fff;
      }

      .save:hover {
         background: #ff4757;
         transform: scale(1.05);
      }

      .btn {
         background: #2c3e50;
         color: #fff;
      }

      .btn:hover {
         background: #34495e;
         transform: scale(1.05);
      }

      /* Responsive Design */
      @media (max-width: 768px) {
         .flex {
            flex-direction: column;
         }

         .info {
            flex-direction: column;
         }

         .images-container {
            height: 300px;
         }

         .name {
            font-size: 1.75rem;
         }

         .heading {
            font-size: 2rem;
         }
      }
   </style>
</head>
<body>

<?php include './header_nav.php'; ?>

<!-- View Property Section -->
<section class="view-property">
   <h1 class="heading">Property Details</h1>

   <?php
   // Fetch property details using MySQLi
   $select_properties = $conn->prepare("SELECT * FROM `property` WHERE id = ? LIMIT 1");
   $select_properties->bind_param("i", $get_id);
   $select_properties->execute();
   $result = $select_properties->get_result();

   if ($result && $result->num_rows > 0) {
      while ($fetch_property = $result->fetch_assoc()) {
         $property_id = $fetch_property['id'];

         // Fetch user details who posted the property
         $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ? LIMIT 1");
         $select_user->bind_param("i", $fetch_property['user_id']);
         $select_user->execute();
         $fetch_user = $select_user->get_result()->fetch_assoc();

         // Check if the property is saved by the current user
         $select_saved = $conn->prepare("SELECT * FROM `saved` WHERE property_id = ? AND user_id = ? LIMIT 1");
         $select_saved->bind_param("ii", $fetch_property['id'], $user_id);
         $select_saved->execute();
         $select_saved->store_result();
   ?>

   <div class="details">
      <!-- Property Images Slider -->
      <div class="swiper images-container">
         <div class="swiper-wrapper">
            <img src="uploaded_files/<?= $fetch_property['image_01']; ?>" alt="" class="swiper-slide">
            <?php if (!empty($fetch_property['image_02'])) { ?>
               <img src="uploaded_files/<?= $fetch_property['image_02']; ?>" alt="" class="swiper-slide">
            <?php } ?>
            <?php if (!empty($fetch_property['image_03'])) { ?>
               <img src="uploaded_files/<?= $fetch_property['image_03']; ?>" alt="" class="swiper-slide">
            <?php } ?>
            <?php if (!empty($fetch_property['image_04'])) { ?>
               <img src="uploaded_files/<?= $fetch_property['image_04']; ?>" alt="" class="swiper-slide">
            <?php } ?>
            <?php if (!empty($fetch_property['image_05'])) { ?>
               <img src="uploaded_files/<?= $fetch_property['image_05']; ?>" alt="" class="swiper-slide">
            <?php } ?>
         </div>
         <div class="swiper-pagination"></div>
      </div>

      <!-- Property Details -->
      <h3 class="name"><?= $fetch_property['property_name']; ?></h3>
      <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_property['address']; ?></span></p>
      <div class="info">
         <p><i class="fas fa-indian-rupee-sign"></i><span><?= $fetch_property['price']; ?></span></p>
         <p><i class="fas fa-user"></i><span><?= $fetch_user['name']; ?></span></p>
         <p><i class="fas fa-phone"></i><a href="tel:1234567890"><?= $fetch_user['number']; ?></a></p>
         <p><i class="fas fa-building"></i><span><?= $fetch_property['type']; ?></span></p>
         <p><i class="fas fa-house"></i><span><?= $fetch_property['offer']; ?></span></p>
         <p><i class="fas fa-calendar"></i><span><?= $fetch_property['date']; ?></span></p>
      </div>

      <!-- Additional Details -->
      <h3 class="title">Details</h3>
      <div class="flex">
         <div class="box">
            <p><i>Rooms :</i><span><?= $fetch_property['bhk']; ?> BHK</span></p>
            <p><i>Deposit Amount :</i><span><span class="fas fa-indian-rupee-sign" style="margin-right: .5rem;"></span><?= $fetch_property['deposite']; ?></span></p>
            <p><i>Status :</i><span><?= $fetch_property['status']; ?></span></p>
            <p><i>Bedroom :</i><span><?= $fetch_property['bedroom']; ?></span></p>
            <p><i>Bathroom :</i><span><?= $fetch_property['bathroom']; ?></span></p>
            <p><i>Balcony :</i><span><?= $fetch_property['balcony']; ?></span></p>
         </div>
         <div class="box">
            <p><i>Carpet Area :</i><span><?= $fetch_property['carpet']; ?> sqft</span></p>
            <p><i>Age :</i><span><?= $fetch_property['age']; ?> years</span></p>
            <p><i>Total Floors :</i><span><?= $fetch_property['total_floors']; ?></span></p>
            <p><i>Room Floor :</i><span><?= $fetch_property['room_floor']; ?></span></p>
            <p><i>Furnished :</i><span><?= $fetch_property['furnished']; ?></span></p>
            <p><i>Loan :</i><span><?= $fetch_property['loan']; ?></span></p>
         </div>
      </div>

      <!-- Amenities -->
      <h3 class="title">Amenities</h3>
      <div class="flex">
         <div class="box">
            <p><i class="fas fa-<?= ($fetch_property['lift'] == 'yes') ? 'check' : 'times'; ?>"></i><span>Lifts</span></p>
            <p><i class="fas fa-<?= ($fetch_property['security_guard'] == 'yes') ? 'check' : 'times'; ?>"></i><span>Security Guards</span></p>
            <p><i class="fas fa-<?= ($fetch_property['play_ground'] == 'yes') ? 'check' : 'times'; ?>"></i><span>Play Ground</span></p>
            <p><i class="fas fa-<?= ($fetch_property['garden'] == 'yes') ? 'check' : 'times'; ?>"></i><span>Gardens</span></p>
            <p><i class="fas fa-<?= ($fetch_property['water_supply'] == 'yes') ? 'check' : 'times'; ?>"></i><span>Water Supply</span></p>
            <p><i class="fas fa-<?= ($fetch_property['power_backup'] == 'yes') ? 'check' : 'times'; ?>"></i><span>Power Backup</span></p>
         </div>
         <div class="box">
            <p><i class="fas fa-<?= ($fetch_property['parking_area'] == 'yes') ? 'check' : 'times'; ?>"></i><span>Parking Area</span></p>
            <p><i class="fas fa-<?= ($fetch_property['gym'] == 'yes') ? 'check' : 'times'; ?>"></i><span>Gym</span></p>
            <p><i class="fas fa-<?= ($fetch_property['shopping_mall'] == 'yes') ? 'check' : 'times'; ?>"></i><span>Shopping Mall</span></p>
            <p><i class="fas fa-<?= ($fetch_property['hospital'] == 'yes') ? 'check' : 'times'; ?>"></i><span>Hospital</span></p>
            <p><i class="fas fa-<?= ($fetch_property['school'] == 'yes') ? 'check' : 'times'; ?>"></i><span>Schools</span></p>
            <p><i class="fas fa-<?= ($fetch_property['market_area'] == 'yes') ? 'check' : 'times'; ?>"></i><span>Market Area</span></p>
         </div>
      </div>

      <!-- Description -->
      <h3 class="title">Description</h3>
      <p class="description"><?= $fetch_property['description']; ?></p>

      <!-- Save and Enquiry Buttons -->
      <form action="" method="post" class="flex-btn">
         <input type="hidden" name="property_id" value="<?= $property_id; ?>">
         <?php if ($select_saved->num_rows > 0) { ?>
            <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>Saved</span></button>
         <?php } else { ?>
            <button type="submit" name="save" class="save"><i class="far fa-heart"></i><span>Save</span></button>
         <?php } ?>
         <input type="submit" value="Send Enquiry" name="send" class="btn">
      </form>
   </div>

   <?php
      }
   } else {
      echo '<p class="empty">Property not found! <a href="post_property.php" style="margin-top:1.5rem;" class="btn">Add New</a></p>';
   }
   ?>
</section>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/script.js"></script>
<script>
   var swiper = new Swiper(".images-container", {
      effect: "coverflow",
      grabCursor: true,
      centeredSlides: true,
      slidesPerView: "auto",
      loop: true,
      coverflowEffect: {
         rotate: 0,
         stretch: 0,
         depth: 200,
         modifier: 3,
         slideShadows: true,
      },
      pagination: {
         el: ".swiper-pagination",
      },
   });
</script>
</body>
</html>