<?php

include '../connect.php';

if(isset($_COOKIE['admin_id'])){
   $admin_id = $_COOKIE['admin_id'];
}else{
   $admin_id = '';
   header('location:login.php');
   exit();
}

if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
}else{
   $get_id = '';
   header('location:dashboard.php');
   exit();
}

if(isset($_POST['delete'])){

   $delete_id = $_POST['delete_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_delete = mysqli_query($conn, "SELECT * FROM `property` WHERE id = '$delete_id'");

   if(mysqli_num_rows($verify_delete) > 0){
      while($fetch_images = mysqli_fetch_assoc($verify_delete)){
         $image_01 = $fetch_images['image_01'];
         $image_02 = $fetch_images['image_02'];
         $image_03 = $fetch_images['image_03'];
         $image_04 = $fetch_images['image_04'];
         $image_05 = $fetch_images['image_05'];
         unlink("../uploaded_files/$image_01");
         if(!empty($image_02)){ unlink("../uploaded_files/$image_02"); }
         if(!empty($image_03)){ unlink("../uploaded_files/$image_03"); }
         if(!empty($image_04)){ unlink("../uploaded_files/$image_04"); }
         if(!empty($image_05)){ unlink("../uploaded_files/$image_05"); }
      }
      mysqli_query($conn, "DELETE FROM `property` WHERE id = '$delete_id'");
      $success_msg[] = 'Listing deleted!';
   }else{
      $warning_msg[] = 'Listing deleted already!';
   }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>property details</title>

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <style>
      /* Cool and Sexy CSS for Property Details Page */

:root {
    --primary-color: #ff4757;
    --secondary-color: #1e90ff;
    --dark-bg: #1b1b1b;
    --light-bg: #2c2c2c;
    --text-color: #ffffff;
    --accent-color: #ffa502;
}

body {
    background-color: var(--dark-bg);
    color: var(--text-color);
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
}

.heading {
    text-align: center;
    font-size: 2.5rem;
    font-weight: bold;
    color: var(--accent-color);
    text-transform: uppercase;
    margin: 2rem 0;
}

.view-property {
    max-width: 1100px;
    margin: auto;
    padding: 20px;
}

.details {
    background: var(--light-bg);
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 0 15px rgba(255, 71, 87, 0.5);
    animation: fadeIn 1s ease-in-out;
}

.details .swiper-container {
    width: 100%;
    height: 400px;
    border-radius: 10px;
    overflow: hidden;
}

.details img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 10px;
}

.name {
    font-size: 2rem;
    font-weight: bold;
    color: var(--secondary-color);
    margin-top: 15px;
    text-transform: capitalize;
}

.info p {
    display: flex;
    align-items: center;
    font-size: 1.1rem;
    margin: 5px 0;
    color: var(--text-color);
}

.info i {
    margin-right: 10px;
    color: var(--primary-color);
}

.title {
    font-size: 1.8rem;
    margin-top: 20px;
    font-weight: bold;
    color: var(--accent-color);
}

.flex {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.box {
    width: 48%;
    background: var(--dark-bg);
    padding: 15px;
    border-radius: 10px;
    margin: 10px 0;
    box-shadow: 0 0 10px rgba(255, 165, 2, 0.5);
}

.box p {
    font-size: 1.1rem;
    margin: 8px 0;
}

.delete-btn {
    background: var(--primary-color);
    color: #fff;
    padding: 10px 20px;
    font-size: 1.2rem;
    border: none;
    cursor: pointer;
    transition: 0.3s ease;
    border-radius: 5px;
    text-transform: uppercase;
}

.delete-btn:hover {
    background: #e84118;
    transform: scale(1.05);
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}


   </style>
</head>
<body>
   
<!-- header section starts  -->
<?php include '../Admin/admin_header.php'; ?>
<!-- header section ends -->

<section class="view-property">

   <h1 class="heading">Property Details</h1>

   <?php
      $stmt = $conn->prepare("SELECT * FROM `property` WHERE id = ? ORDER BY date DESC LIMIT 1");
      $stmt->bind_param("i", $get_id);
      $stmt->execute();
      $result = $stmt->get_result();

      if($result->num_rows > 0){
         while($fetch_property = $result->fetch_assoc()){

         $property_id = $fetch_property['id'];

         $stmt_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
         $stmt_user->bind_param("i", $fetch_property['user_id']);
         $stmt_user->execute();
         $result_user = $stmt_user->get_result();
         $fetch_user = $result_user->fetch_assoc();
   ?>
   <div class="details">
     <div class="swiper images-container">
         <div class="swiper-wrapper">
            <img src="../uploaded_files/<?= $fetch_property['image_01']; ?>" alt="" class="swiper-slide">
            <?php if(!empty($fetch_property['image_02'])){ ?>
            <img src="../uploaded_files/<?= $fetch_property['image_02']; ?>" alt="" class="swiper-slide">
            <?php } ?>
            <?php if(!empty($fetch_property['image_03'])){ ?>
            <img src="../uploaded_files/<?= $fetch_property['image_03']; ?>" alt="" class="swiper-slide">
            <?php } ?>
            <?php if(!empty($fetch_property['image_04'])){ ?>
            <img src="../uploaded_files/<?= $fetch_property['image_04']; ?>" alt="" class="swiper-slide">
            <?php } ?>
            <?php if(!empty($fetch_property['image_05'])){ ?>
            <img src="../uploaded_files/<?= $fetch_property['image_05']; ?>" alt="" class="swiper-slide">
            <?php } ?>
         </div>
         <div class="swiper-pagination"></div>
     </div>
      <h3 class="name"><?= $fetch_property['property_name']; ?></h3>
      <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_property['address']; ?></span></p>
      <div class="info">
         <p><i class="fas fa-indian-rupee-sign"></i><span><?= $fetch_property['price']; ?></span></p>
         <p><i class="fas fa-user"></i><span><?= $fetch_user['name']; ?></span></p>
         <p><i class="fas fa-phone"></i><a href="tel:<?= $fetch_user['number']; ?>"><?= $fetch_user['number']; ?></a></p>
         <p><i class="fas fa-building"></i><span><?= $fetch_property['type']; ?></span></p>
         <p><i class="fas fa-house"></i><span><?= $fetch_property['offer']; ?></span></p>
         <p><i class="fas fa-calendar"></i><span><?= $fetch_property['date']; ?></span></p>
      </div>
      <h3 class="title">Details</h3>
      <div class="flex">
         <div class="box">
            <p><i>Rooms :</i><span><?= $fetch_property['bhk']; ?> BHK</span></p>
            <p><i>Deposit Amount : </i><span><span class="fas fa-indian-rupee-sign" style="margin-right: .5rem;"></span><?= $fetch_property['deposite']; ?></span></p>
            <p><i>Status :</i><span><?= $fetch_property['status']; ?></span></p>
            <p><i>Bedroom :</i><span><?= $fetch_property['bedroom']; ?></span></p>
            <p><i>Bathroom :</i><span><?= $fetch_property['bathroom']; ?></span></p>
            <p><i>Balcony :</i><span><?= $fetch_property['balcony']; ?></span></p>
         </div>
         <div class="box">
            <p><i>Carpet Area :</i><span><?= $fetch_property['carpet']; ?>sqft</span></p>
            <p><i>Age :</i><span><?= $fetch_property['age']; ?> years</span></p>
            <p><i>Total Floors :</i><span><?= $fetch_property['total_floors']; ?></span></p>
            <p><i>Room Floor :</i><span><?= $fetch_property['room_floor']; ?></span></p>
            <p><i>Furnished :</i><span><?= $fetch_property['furnished']; ?></span></p>
            <p><i>Loan :</i><span><?= $fetch_property['loan']; ?></span></p>
         </div>
      </div>
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
      <h3 class="title">Description</h3>
      <p class="description"><?= $fetch_property['description']; ?></p>
      <form action="" method="post" class="flex-btn">
         <input type="hidden" name="delete_id" value="<?= $property_id; ?>">
         <input type="submit" value="Delete Property" name="delete" class="delete-btn" onclick="return confirm('Delete this listing?');">
      </form>
   </div>
   <?php
      }
   } else {
      echo '<p class="empty">Property not found! <a href="listings.php" style="margin-top:1.5rem;" class="option-btn">Go to Listings</a></p>';
   }
   ?>

</section>


















<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>


<script>

var swiper = new Swiper(".images-container", {
   effect: "coverflow",
   grabCursor: true,
   centeredSlides: true,
   slidesPerView: "auto",
   loop:true,
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