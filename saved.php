<?php  

session_start();
include 'connect.php';

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
}

include 'save_send.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>saved</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
<style>
    /* General Styles */
    body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f8f9fa;
    color: #333;
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
    color: #222;
    font-weight: bold;
    margin-bottom: 2rem;
    text-transform: capitalize;
    position: relative;
}

.listings .heading::after {
    content: '';
    width: 80px;
    height: 3px;
    background: #4caf50;
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
    background: #ffffff;
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
    background-color: #f9f9f9;
    border-bottom: 1px solid #eaeaea;
}

.listings .admin h3 {
    background: #4caf50;
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
    color: #222;
    margin: 0;
}

.listings .admin div span {
    font-size: 0.85rem;
    color: #888;
}

/* Property Details */
.listings .box .price {
    font-size: 1.5rem;
    font-weight: bold;
    color: #4caf50;
    padding: 1rem 1rem 0.5rem;
}

.listings .box .name {
    font-size: 1.2rem;
    font-weight: 600;
    margin: 0.5rem 1rem;
    color: #333;
}

.listings .box .location {
    font-size: 0.9rem;
    color: #555;
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
    color: #555;
}

/* Buttons */
.listings .flex-btn {
    display: flex;
    justify-content: space-between;
    padding: 1rem;
}

.listings .btn {
    background: #4caf50;
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
    background: #388e3c;
    transform: scale(1.05);
}

.listings .save {
    background: none;
    border: none;
    color: #ff6b6b;
    font-size: 1rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.listings .save:hover {
    color: #d32f2f;
}

/* View All Button */
.inline-btn {
    background: #007bff;
    color: #ffffff;
    padding: 0.8rem 1.5rem;
    border-radius: 8px;
    text-transform: uppercase;
    text-decoration: none;
    transition: background 0.3s, transform 0.3s;
}

.inline-btn:hover {
    background: #0056b3;
    transform: scale(1.05);
}

/* Empty Message */
.empty {
    text-align: center;
    font-size: 1.1rem;
    color: #666;
    margin-top: 1.5rem;
}

.empty .btn {
    margin-top: 1rem;
    background: #4caf50;
    color: white;
    padding: 0.8rem 1.5rem;
    border-radius: 8px;
    text-decoration: none;
    transition: background 0.3s;
}

.empty .btn:hover {
    background: #388e3c;
}

</style>
</head>
<body>
   
<?php include 'header_nav.php'; ?>

<section class="listings">

   <h1 class="heading">saved listings</h1>

   <div class="box-container">
      <?php
         $total_images = 0;
         $select_saved_property = $conn->query("SELECT * FROM `saved` WHERE user_id = '$user_id'");
         if ($select_saved_property->num_rows > 0) {
            while ($fetch_saved = $select_saved_property->fetch_assoc()) {
               $property_id = $fetch_saved['property_id'];
               $select_properties = $conn->query("SELECT * FROM `property` WHERE id = '$property_id' ORDER BY date DESC");
               if ($select_properties->num_rows > 0) {
                  while ($fetch_property = $select_properties->fetch_assoc()) {

                     $user_id = $fetch_property['user_id'];
                     $select_user = $conn->query("SELECT * FROM `users` WHERE id = '$user_id'");
                     $fetch_user = $select_user->fetch_assoc();

                     $image_coutn_02 = !empty($fetch_property['image_02']) ? 1 : 0;
                     $image_coutn_03 = !empty($fetch_property['image_03']) ? 1 : 0;
                     $image_coutn_04 = !empty($fetch_property['image_04']) ? 1 : 0;
                     $image_coutn_05 = !empty($fetch_property['image_05']) ? 1 : 0;

                     $total_images = (1 + $image_coutn_02 + $image_coutn_03 + $image_coutn_04 + $image_coutn_05);

                     $check_saved = $conn->query("SELECT * FROM `saved` WHERE property_id = '$property_id' AND user_id = '$user_id'");

      ?>
      <form action="" method="POST">
         <div class="box">
            <input type="hidden" name="property_id" value="<?= $fetch_property['id']; ?>">
            <?php
               if ($check_saved->num_rows > 0) {
            ?>
            <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>remove from saved</span></button>
            <?php
               } else { 
            ?>
            <button type="submit" name="save" class="save"><i class="far fa-heart"></i><span>save</span></button>
            <?php
               }
            ?>
            <div class="thumb">
               <p class="total-images"><i class="far fa-image"></i><span><?= $total_images; ?></span></p> 
               <img src="uploaded_files/<?= $fetch_property['image_01']; ?>" alt="">
            </div>
            <div class="admin">
               <h3><?= substr($fetch_user['name'], 0, 1); ?></h3>
               <div>
                  <p><?= $fetch_user['name']; ?></p>
                  <span><?= $fetch_property['date']; ?></span>
               </div>
            </div>
         </div>
         <div class="box">
            <div class="price"><i class="fas fa-indian-rupee-sign"></i><span><?= $fetch_property['price']; ?></span></div>
            <h3 class="name"><?= $fetch_property['property_name']; ?></h3>
            <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_property['address']; ?></span></p>
            <div class="flex">
               <p><i class="fas fa-house"></i><span><?= $fetch_property['type']; ?></span></p>
               <p><i class="fas fa-tag"></i><span><?= $fetch_property['offer']; ?></span></p>
               <p><i class="fas fa-bed"></i><span><?= $fetch_property['bhk']; ?> BHK</span></p>
               <p><i class="fas fa-trowel"></i><span><?= $fetch_property['status']; ?></span></p>
               <p><i class="fas fa-couch"></i><span><?= $fetch_property['furnished']; ?></span></p>
               <p><i class="fas fa-maximize"></i><span><?= $fetch_property['carpet']; ?>sqft</span></p>
            </div>
            <div class="flex-btn">
               <a href="view_property.php?get_id=<?= $fetch_property['id']; ?>" class="btn">view property</a>
               <input type="submit" value="send enquiry" name="send" class="btn">
            </div>
         </div>
      </form>
      <?php
                  }
               } else {
                  echo '<p class="empty">no properties added yet! <a href="post_property.php" style="margin-top:1.5rem;" class="btn">add new</a></p>';
               }
            }
         } else {
            echo '<p class="empty">no properties saved yet! <a href="listings.php" style="margin-top:1.5rem;" class="btn">discover more</a></p>';
         }
      ?>
      
   </div>

</section>



<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>


</body>
</html>