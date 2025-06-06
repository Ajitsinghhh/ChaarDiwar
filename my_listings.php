<?php
session_start();
include 'connect.php'; // Ensure 'connect.php' uses MySQLi

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:login.php');
    exit;
}

if (isset($_POST['delete'])) {

    $delete_id = $_POST['property_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    // Verify if the property exists
    $verify_delete = $conn->prepare("SELECT * FROM `property` WHERE id = ?");
    $verify_delete->bind_param("s", $delete_id);
    $verify_delete->execute();
    $result_verify = $verify_delete->get_result();

    if ($result_verify->num_rows > 0) {
        // Fetch images associated with the property
        $select_images = $conn->prepare("SELECT * FROM `property` WHERE id = ?");
        $select_images->bind_param("s", $delete_id);
        $select_images->execute();
        $result_images = $select_images->get_result();

        while ($fetch_images = $result_images->fetch_assoc()) {
            $image_01 = $fetch_images['image_01'];
            $image_02 = $fetch_images['image_02'];
            $image_03 = $fetch_images['image_03'];
            $image_04 = $fetch_images['image_04'];
            $image_05 = $fetch_images['image_05'];

            unlink('uploaded_files/' . $image_01);
            if (!empty($image_02)) {
                unlink('uploaded_files/' . $image_02);
            }
            if (!empty($image_03)) {
                unlink('uploaded_files/' . $image_03);
            }
            if (!empty($image_04)) {
                unlink('uploaded_files/' . $image_04);
            }
            if (!empty($image_05)) {
                unlink('uploaded_files/' . $image_05);
            }
        }

        // Delete associated entries in 'saved' table
        $delete_saved = $conn->prepare("DELETE FROM `saved` WHERE property_id = ?");
        $delete_saved->bind_param("s", $delete_id);
        $delete_saved->execute();

        // Delete associated entries in 'requests' table
        $delete_requests = $conn->prepare("DELETE FROM `requests` WHERE property_id = ?");
        $delete_requests->bind_param("s", $delete_id);
        $delete_requests->execute();

        // Delete the property
        $delete_listing = $conn->prepare("DELETE FROM `property` WHERE id = ?");
        $delete_listing->bind_param("s", $delete_id);
        $delete_listing->execute();

        $success_msg[] = 'Listing deleted successfully!';
        echo "<script>alert('Listing deleted successfully!');</script>";

    } else {
        $warning_msg[] = 'Listing already deleted!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>my listings</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <style>
      body {
         font-family: 'Roboto', sans-serif;
         margin: 0;
         padding: 0;
         background-color: #f4f4f4;
         color: #333;
      }

      .heading {
         text-align: center;
         font-size: 2.5rem;
         margin: 2rem 0;
         color: #333;
      }

      .box-container {
         display: flex;
         flex-wrap: wrap;
         justify-content: center;
         gap: 2rem;
         padding: 2rem;
      }

      .box {
         background-color: #fff;
         border-radius: 10px;
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
         overflow: hidden;
         width: 350px;
         transition: transform 0.3s;
      }

      .box:hover {
         transform: translateY(-10px);
      }

      .thumb {
         position: relative;
         width: 100%;
         height: 250px;
         overflow: hidden;
      }

      .thumb img {
         width: 100%;
         height: 100%;
         object-fit: cover;
      }

      .thumb p {
         position: absolute;
         top: 10px;
         left: 10px;
         background-color: rgba(0, 0, 0, 0.7);
         color: #fff;
         padding: 5px 10px;
         border-radius: 5px;
         font-size: 0.9rem;
         display: flex;
         align-items: center;
      }

      .thumb p i {
         margin-right: 5px;
      }

      .price {
         font-size: 1.5rem;
         color: #e74c3c;
         margin: 1rem;
         display: flex;
         align-items: center;
      }

      .price i {
         margin-right: 5px;
      }

      .name {
         font-size: 1.2rem;
         margin: 0 1rem;
         color: #333;
      }

      .location {
         font-size: 1rem;
         margin: 0.5rem 1rem;
         color: #777;
         display: flex;
         align-items: center;
      }

      .location i {
         margin-right: 5px;
      }

      .flex-btn {
         display: flex;
         justify-content: space-between;
         margin: 1rem;
      }

      .btn {
         background-color: #3498db;
         color: #fff;
         padding: 0.5rem 1rem;
         border: none;
         border-radius: 5px;
         cursor: pointer;
         text-decoration: none;
         text-align: center;
         transition: background-color 0.3s;
      }

      .btn:hover {
         background-color:rgb(50, 210, 197);
      }

      .view-btn {
         display: block;
         width: calc(100% - 2rem);
         margin: 1rem;
         text-align: center;
         padding: 0.75rem 0;
         background-color: #3498db;
         color: #fff;
         padding: 0.5rem 1rem;
         border: none;
         border-radius: 5px;
         cursor: pointer;
         text-decoration: none;
         text-align: center;
         transition: background-color 0.3s;
      }

      .empty {
         text-align: center;
         font-size: 1.2rem;
         color: #777;
      }

      .empty a {
         color: #3498db;
         text-decoration: none;
         font-weight: 500;
      }

      .empty a:hover {
         text-decoration: underline;
      }

    
   </style>
 
</head>
<body>
   
<?php include 'header_nav.php'; ?>

<section class="my-listings">

   <h1 class="heading">my listings</h1>

   <div class="box-container">

   <?php
      $total_images = 0;

      // Prepare and execute the query
      $query = "SELECT * FROM `property` WHERE user_id = ? ORDER BY date DESC";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("s", $user_id); // Bind the parameter
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
         while ($fetch_property = $result->fetch_assoc()) {

            $property_id = $fetch_property['id'];

            $image_count_02 = !empty($fetch_property['image_02']) ? 1 : 0;
            $image_count_03 = !empty($fetch_property['image_03']) ? 1 : 0;
            $image_count_04 = !empty($fetch_property['image_04']) ? 1 : 0;
            $image_count_05 = !empty($fetch_property['image_05']) ? 1 : 0;

            $total_images = (1 + $image_count_02 + $image_count_03 + $image_count_04 + $image_count_05);
   ?>
   <form accept="" method="POST" class="box">
      <input type="hidden" name="property_id" value="<?= $property_id; ?>">
      <div class="thumb">
         <p><i class="far fa-image"></i><span><?= $total_images; ?></span></p> 
         <img src="uploaded_files/<?= $fetch_property['image_01']; ?>" alt="">
      </div>
      <div class="price"><i class="fas fa-indian-rupee-sign"></i><span><?= $fetch_property['price']; ?></span></div>
      <h3 class="name"><?= $fetch_property['property_name']; ?></h3>
      <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_property['address']; ?></span></p>
      <div class="flex-btn">
         <a href="update_property.php?get_id=<?= $property_id; ?>" class="btn">update</a>
         <input type="submit" name="delete" value="delete" class="btn" onclick="return confirm('delete this listing?');">
      </div>
      <a href="view_property.php?get_id=<?= $property_id; ?>" class="view-btn">view property</a>
   </form>
   <?php
         }
      } else {
         echo '<p class="empty">no properties added yet! <a href="post_property.php" style="margin-top:1.5rem;" class="btn">add new</a></p>';
      }

      $stmt->close(); // Close the statement
   ?>

   </div>

</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
</body>
</html>
