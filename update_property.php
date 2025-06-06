<?php
session_start();

// Include MySQLi connection file
include 'connect.php'; // Ensure this file contains MySQLi connection logic

// Check if user is logged in using session
if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:login.php');
   exit();
}

// Check if property ID is provided in the URL
if (isset($_GET['get_id'])) {
   $get_id = $_GET['get_id'];
} else {
   $get_id = '';
   header('location:homepage.php');
   exit();
}
// Handle form submission for updating property
if (isset($_POST['update'])) {
   $update_id = $_POST['property_id'];
   $update_id = filter_var($update_id, FILTER_SANITIZE_STRING);

   // Sanitize form inputs
   $property_name = filter_var($_POST['property_name'], FILTER_SANITIZE_STRING);
   $price = filter_var($_POST['price'], FILTER_SANITIZE_STRING);
   $deposite = filter_var($_POST['deposite'], FILTER_SANITIZE_STRING);
   $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
   $offer = filter_var($_POST['offer'], FILTER_SANITIZE_STRING);
   $type = filter_var($_POST['type'], FILTER_SANITIZE_STRING);
   $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
   $furnished = filter_var($_POST['furnished'], FILTER_SANITIZE_STRING);
   $bhk = filter_var($_POST['bhk'], FILTER_SANITIZE_STRING);
   $bedroom = filter_var($_POST['bedroom'], FILTER_SANITIZE_STRING);
   $bathroom = filter_var($_POST['bathroom'], FILTER_SANITIZE_STRING);
   $carpet = filter_var($_POST['carpet'], FILTER_SANITIZE_STRING);
   $age = filter_var($_POST['age'], FILTER_SANITIZE_STRING);
   $total_floors = filter_var($_POST['total_floors'], FILTER_SANITIZE_STRING);
   $room_floor = filter_var($_POST['room_floor'], FILTER_SANITIZE_STRING);
   $loan = filter_var($_POST['loan'], FILTER_SANITIZE_STRING);
   $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);

   // Handle checkboxes
   $lift = isset($_POST['lift']) ? 'yes' : 'no';
   $security_guard = isset($_POST['security_guard']) ? 'yes' : 'no';
   $play_ground = isset($_POST['play_ground']) ? 'yes' : 'no';
   $garden = isset($_POST['garden']) ? 'yes' : 'no';
   $water_supply = isset($_POST['water_supply']) ? 'yes' : 'no';
   $power_backup = isset($_POST['power_backup']) ? 'yes' : 'no';
   $parking_area = isset($_POST['parking_area']) ? 'yes' : 'no';
   $gym = isset($_POST['gym']) ? 'yes' : 'no';
   $shopping_mall = isset($_POST['shopping_mall']) ? 'yes' : 'no';
   $hospital = isset($_POST['hospital']) ? 'yes' : 'no';
   $school = isset($_POST['school']) ? 'yes' : 'no';
   $market_area = isset($_POST['market_area']) ? 'yes' : 'no';

   // Update property details in the database
   $update_query = "UPDATE `property` SET 
   property_name = ?, 
   address = ?, 
   price = ?, 
   type = ?, 
   offer = ?, 
   status = ?, 
   furnished = ?, 
   bhk = ?, 
   deposite = ?, 
   bedroom = ?, 
   bathroom = ?, 
   carpet = ?, 
   age = ?, 
   total_floors = ?, 
   room_floor = ?, 
   loan = ?, 
   lift = ?, 
   security_guard = ?, 
   play_ground = ?, 
   garden = ?, 
   water_supply = ?, 
   power_backup = ?, 
   parking_area = ?, 
   gym = ?, 
   shopping_mall = ?, 
   hospital = ?, 
   school = ?, 
   market_area = ?, 
   description = ? 
   WHERE id = ?";

$stmt = $conn->prepare($update_query);

// Ensure the number of variables matches the number of placeholders
// Define the update query
$update_query = " UPDATE `property` SET 
        property_name = ?, 
        address = ?, 
        price = ?, 
        type = ?, 
        offer = ?, 
        status = ?, 
        furnished = ?, 
        bhk = ?, 
        deposite = ?, 
        bedroom = ?, 
        bathroom = ?, 
        carpet = ?, 
        age = ?, 
        total_floors = ?, 
        room_floor = ?, 
        loan = ?, 
        lift = ?, 
        security_guard = ?, 
        play_ground = ?, 
        garden = ?, 
        water_supply = ?, 
        power_backup = ?, 
        parking_area = ?, 
        gym = ?, 
        shopping_mall = ?, 
        hospital = ?, 
        school = ?, 
        market_area = ?, 
        description = ? 
        WHERE id = ? ";

// Prepare the statement
$stmt = $conn->prepare($update_query);

// Use an array to hold all the values
$update_values = [
    $property_name,
    $address,
    $price,
    $type,
    $offer,
    $status,
    $furnished,
    $bhk,
    $deposite,
    $bedroom,
    $bathroom,
    $carpet,
    $age,
    $total_floors,
    $room_floor,
    $loan,
    $lift,
    $security_guard,
    $play_ground,
    $garden,
    $water_supply,
    $power_backup,
    $parking_area,
    $gym,
    $shopping_mall,
    $hospital,
    $school,
    $market_area,
    $description,
    $update_id // ID for the WHERE clause
];

// Dynamically generate the binding types
$bind_types = str_repeat('s', count($update_values) - 1) . 'i'; // 's' for strings, 'i' for the last integer (ID)

// Bind the parameters dynamically
$stmt->bind_param($bind_types, ...$update_values);

// Execute the statement
if ($stmt->execute()) {
    echo "Record updated successfully.";
    echo "<script>alert('Property updated successfully!');</script>";

    echo "<script>alert('Property updated successfully!');</script>";

} else {
    echo "Error updating record: " . $stmt->error;
}
}
// Handle image deletion requests
if (isset($_POST['delete_image_02'])) {
   $old_image_02 = $_POST['old_image_02'];
   $update_image_query = "UPDATE `property` SET image_02 = '' WHERE id = ?";
   $stmt = $conn->prepare($update_image_query);
   $stmt->bind_param('i', $get_id);
   $stmt->execute();
   if (!empty($old_image_02)) {
      unlink('uploaded_files/' . $old_image_02);
      $success_msg[] = 'Image 02 deleted!';
      echo "<script>alert('Image 02 deleted!');</script>";

   }
}

if (isset($_POST['delete_image_03'])) {
   $old_image_03 = $_POST['old_image_03'];
   $update_image_query = "UPDATE `property` SET image_03 = '' WHERE id = ?";
   $stmt = $conn->prepare($update_image_query);
   $stmt->bind_param('i', $get_id);
   $stmt->execute();
   if (!empty($old_image_03)) {
      unlink('uploaded_files/' . $old_image_03);
      $success_msg[] = 'Image 03 deleted!';
      echo "<script>alert('Image 03 deleted!');</script>";

   }
}

if (isset($_POST['delete_image_04'])) {
   $old_image_04 = $_POST['old_image_04'];
   $update_image_query = "UPDATE `property` SET image_04 = '' WHERE id = ?";
   $stmt = $conn->prepare($update_image_query);
   $stmt->bind_param('i', $get_id);
   $stmt->execute();
   if (!empty($old_image_04)) {
      unlink('uploaded_files/' . $old_image_04);
      $success_msg[] = 'Image 04 deleted!';
      echo "<script>alert('Image 04 deleted!');</script>";

   }
}

if (isset($_POST['delete_image_05'])) {
   $old_image_05 = $_POST['old_image_05'];
   $update_image_query = "UPDATE `property` SET image_05 = '' WHERE id = ?";
   $stmt = $conn->prepare($update_image_query);
   $stmt->bind_param('i', $get_id);
   $stmt->execute();
   if (!empty($old_image_05)) {
      unlink('uploaded_files/' . $old_image_05);
      $success_msg[] = 'Image 05 deleted!';
      echo "<script>alert('Image 05 deleted!');</script>";

   }
}

// Fetch property details for editing
$select_properties = $conn->prepare("SELECT * FROM `property` WHERE id = ?");
$select_properties->bind_param('i', $get_id);
$select_properties->execute();
$result = $select_properties->get_result();

if ($result->num_rows > 0) {
   $fetch_property = $result->fetch_assoc();
   $property_id = $fetch_property['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Property</title>

   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- Custom CSS File Link -->
   <link rel="stylesheet" href="css/style.css">
      <style>
      body {
         font-family: 'Roboto', sans-serif;
         background-color: #f4f4f4;
         margin: 0;
         padding: 0;
      }

      .property-form {
         max-width: 800px;
         margin: 50px auto;
         background: #fff;
         padding: 20px;
         box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
         border-radius: 8px;
      }

      .property-form h3 {
         text-align: center;
         margin-bottom: 20px;
         font-size: 24px;
         color: #333;
      }

      .property-form .box {
         margin-bottom: 15px;
      }

      .property-form .box p {
         margin: 0 0 5px;
         font-weight: 500;
         color: #555;
      }

      .property-form .box p span {
         color: #e74c3c;
      }

      .property-form .input {
         width: 100%;
         padding: 10px;
         border: 1px solid #ddd;
         border-radius: 4px;
         font-size: 16px;
         color: #333;
      }

      .property-form .flex {
         display: flex;
         flex-wrap: wrap;
         gap: 15px;
      }

      .property-form .flex .box {
         flex: 1 1 calc(50% - 15px);
      }

      .property-form .checkbox {
         display: flex;
         flex-wrap: wrap;
         gap: 15px;
         margin-bottom: 15px;
      }

      .property-form .checkbox .box {
         flex: 1 1 calc(50% - 15px);
      }

      .property-form .checkbox .box p {
         display: flex;
         align-items: center;
         gap: 10px;
      }

      .property-form .image {
         width: 100%;
         height: auto;
         border-radius: 4px;
         margin-bottom: 10px;
      }

      .property-form .inline-btn {
         display: inline-block;
         padding: 10px 20px;
         background: #e74c3c;
         color: #fff;
         border: none;
         border-radius: 4px;
         cursor: pointer;
         text-align: center;
         font-size: 16px;
         transition: background 0.3s;
      }

      .property-form .inline-btn:hover {
         background: #c0392b;
      }

      .property-form .btn {
         display: block;
         width: 100%;
         padding: 15px;
         background: #3498db;
         color: #fff;
         border: none;
         border-radius: 4px;
         cursor: pointer;
         text-align: center;
         font-size: 18px;
         transition: background 0.3s;
      }

      .property-form .btn:hover {
         background: #2980b9;
      }

      .property-form .empty {
         text-align: center;
         font-size: 18px;
         color: #e74c3c;
      }

      .property-form .empty a {
         display: inline-block;
         margin-top: 15px;
         padding: 10px 20px;
         background: #3498db;
         color: #fff;
         border: none;
         border-radius: 4px;
         cursor: pointer;
         text-align: center;
         font-size: 16px;
         transition: background 0.3s;
      }

      .property-form .empty a:hover {
         background: #2980b9;
      }
   </style>
</head>
<body>
  


<section class="property-form">

   <form action="" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="property_id" value="<?= $property_id; ?>">
      <input type="hidden" name="old_image_01" value="<?= $fetch_property['image_01']; ?>">
      <input type="hidden" name="old_image_02" value="<?= $fetch_property['image_02']; ?>">
      <input type="hidden" name="old_image_03" value="<?= $fetch_property['image_03']; ?>">
      <input type="hidden" name="old_image_04" value="<?= $fetch_property['image_04']; ?>">
      <input type="hidden" name="old_image_05" value="<?= $fetch_property['image_05']; ?>">

      <h3>Property Details</h3>

      <div class="box">
         <p>Property Name <span>*</span></p>
         <input type="text" name="property_name" required maxlength="50" placeholder="Enter property name" value="<?= $fetch_property['property_name']; ?>" class="input">
      </div>

      <div class="flex">
         <div class="box">
            <p>Property Price <span>*</span></p>
            <input type="number" name="price" required min="0" max="9999999999" maxlength="10" value="<?= $fetch_property['price']; ?>" placeholder="Enter property price" class="input">
         </div>
         <div class="box">
            <p>Deposit Amount <span>*</span></p>
            <input type="number" name="deposite" required min="0"
            max="9999999999" maxlength="10" value="<?= $fetch_property['deposite']; ?>" placeholder="Enter deposit amount" class="input">
         </div>
         <div class="box">
            <p>Property Address <span>*</span></p>
            <input type="text" name="address" required maxlength="100" placeholder="Enter property full address" value="<?= $fetch_property['address']; ?>" class="input">
         </div>
         <div class="box">
            <p>Offer Type <span>*</span></p>
            <select name="offer" required class="input">
               <option value="<?= $fetch_property['offer']; ?>" selected><?= $fetch_property['offer']; ?></option>
               <option value="sale">Sale</option>
               <option value="resale">Resale</option>
               <option value="rent">Rent</option>
            </select>
         </div>
         <div class="box">
            <p>Property Type <span>*</span></p>
            <select name="type" required class="input">
               <option value="<?= $fetch_property['type']; ?>" selected><?= $fetch_property['type']; ?></option>
               <option value="flat">Flat</option>
               <option value="house">House</option>
               <option value="shop">Shop</option>
            </select>
         </div>
         <div class="box">
            <p>Property Status <span>*</span></p>
            <select name="status" required class="input">
               <option value="<?= $fetch_property['status']; ?>" selected><?= $fetch_property['status']; ?></option>
               <option value="ready to move">Ready to Move</option>
               <option value="under construction">Under Construction</option>
            </select>
         </div>
         <div class="box">
            <p>Furnished Status <span>*</span></p>
            <select name="furnished" required class="input">
               <option value="<?= $fetch_property['furnished']; ?>" selected><?= $fetch_property['furnished']; ?></option>
               <option value="furnished">Furnished</option>
               <option value="semi-furnished">Semi-Furnished</option>
               <option value="unfurnished">Unfurnished</option>
            </select>
         </div>
         <div class="box">
            <p>BHK <span>*</span></p>
            <select name="bhk" required class="input">
               <option value="<?= $fetch_property['bhk']; ?>" selected><?= $fetch_property['bhk']; ?> BHK</option>
               <option value="1">1 BHK</option>
               <option value="2">2 BHK</option>
               <option value="3">3 BHK</option>
               <option value="4">4 BHK</option>
               <option value="5">5 BHK</option>
            </select>
         </div>
         <div class="box">
            <p>Bedrooms <span>*</span></p>
            <select name="bedroom" required class="input">
               <option value="<?= $fetch_property['bedroom']; ?>" selected><?= $fetch_property['bedroom']; ?> Bedroom</option>
               <option value="1">1 Bedroom</option>
               <option value="2">2 Bedrooms</option>
               <option value="3">3 Bedrooms</option>
               <option value="4">4 Bedrooms</option>
               <option value="5">5 Bedrooms</option>
            </select>
         </div>
         <div class="box">
            <p>Bathrooms <span>*</span></p>
            <select name="bathroom" required class="input">
               <option value="<?= $fetch_property['bathroom']; ?>" selected><?= $fetch_property['bathroom']; ?> Bathroom</option>
               <option value="1">1 Bathroom</option>
               <option value="2">2 Bathrooms</option>
               <option value="3">3 Bathrooms</option>
               <option value="4">4 Bathrooms</option>
               <option value="5">5 Bathrooms</option>
            </select>
         </div>
         <div class="box">
            <p>Balconies <span>*</span>
            </div>
         <div class="box">
            <p>Carpet Area <span>*</span></p>
            <input type="number" name="carpet" required min="1" max="9999999999" maxlength="10" value="<?= $fetch_property['carpet']; ?>" placeholder="Enter carpet area" class="input">
         </div>
         <div class="box">
            <p>Property Age <span>*</span></p>
            <input type="number" name="age" required min="0" max="99" maxlength="2" value="<?= $fetch_property['age']; ?>" placeholder="Enter property age" class="input">
         </div>
         <div class="box">
            <p>Total Floors <span>*</span></p>
            <input type="number" name="total_floors" required min="0" max="99" maxlength="2" value="<?= $fetch_property['total_floors']; ?>" placeholder="Enter total floors" class="input">
         </div>
         <div class="box">
            <p>Room Floor <span>*</span></p>
            <input type="number" name="room_floor" required min="0" max="99" maxlength="2" value="<?= $fetch_property['room_floor']; ?>" placeholder="Enter room floor" class="input">
         </div>
         <div class="box">
            <p>Loan <span>*</span></p>
            <select name="loan" required class="input">
               <option value="<?= $fetch_property['loan']; ?>" selected><?= $fetch_property['loan']; ?></option>
               <option value="available">Available</option>
               <option value="not available">Not Available</option>
            </select>
         </div>
      </div>
      <div class="box">
         <p>Property Description <span>*</span></p>
         <textarea name="description" maxlength="1000" class="input" required cols="30" rows="10" placeholder="Write about property..."><?= $fetch_property['description']; ?></textarea>
      </div>
      <div class="checkbox">
         <div class="box">
            <p><input type="checkbox" name="lift" value="yes" <?= ($fetch_property['lift'] == 'yes') ? 'checked' : ''; ?> /> Lifts</p>
            <p><input type="checkbox" name="security_guard" value="yes" <?= ($fetch_property['security_guard'] == 'yes') ? 'checked' : ''; ?> /> Security Guard</p>
            <p><input type="checkbox" name="play_ground" value="yes" <?= ($fetch_property['play_ground'] == 'yes') ? 'checked' : ''; ?> /> Play Ground</p>
            <p><input type="checkbox" name="garden" value="yes" <?= ($fetch_property['garden'] == 'yes') ? 'checked' : ''; ?> /> Garden</p>
            <p><input type="checkbox" name="water_supply" value="yes" <?= ($fetch_property['water_supply'] == 'yes') ? 'checked' : ''; ?> /> Water Supply</p>
            <p><input type="checkbox" name="power_backup" value="yes" <?= ($fetch_property['power_backup'] == 'yes') ? 'checked' : ''; ?> /> Power Backup</p>
         </div>
         <div class="box">
            <p><input type="checkbox" name="parking_area" value="yes" <?= ($fetch_property['parking_area'] == 'yes') ? 'checked' : ''; ?> /> Parking Area</p>
            <p><input type="checkbox" name="gym" value="yes" <?= ($fetch_property['gym'] == 'yes') ? 'checked' : ''; ?> /> Gym</p>
            <p><input type="checkbox" name="shopping_mall" value="yes" <?= ($fetch_property['shopping_mall'] == 'yes') ? 'checked' : ''; ?> /> Shopping Mall</p>
            <p><input type="checkbox" name="hospital" value="yes" <?= ($fetch_property['hospital'] == 'yes') ? 'checked' : ''; ?> /> Hospital</p>
            <p><input type="checkbox" name="school" value="yes" <?= ($fetch_property['school'] == 'yes') ? 'checked' : ''; ?> /> School</p>
            <p><input type="checkbox" name="market_area" value="yes" <?= ($fetch_property['market_area'] == 'yes') ? 'checked' : ''; ?> /> Market Area</p>
         </div>
      </div>
      <div class="box">
         <img src="uploaded_files/<?= $fetch_property['image_01']; ?>" class="image" alt="">
         <p>Update Image 01</p>
         <input type="file" name="image_01" class="input" accept="image/*">
      </div>
      <div class="flex">
         <div class="box">
            <?php if (!empty($fetch_property['image_02'])) { ?>
               <img src="uploaded_files/<?= $fetch_property['image_02']; ?>" class="image" alt="">
               <input type="submit" value="Delete Image 02" name="delete_image_02" class="inline-btn" onclick="return confirm('Delete Image 02');">
            <?php } ?>
            <p>Update Image 02</p>
            <input type="file" name="image_02" class="input" accept="image/*">
         </div>
         <div class="box">
            <?php if (!empty($fetch_property['image_03'])) { ?>
               <img src="uploaded_files/<?= $fetch_property['image_03']; ?>" class="image" alt="">
               <input type="submit" value="Delete Image 03" name="delete_image_03" class="inline-btn" onclick="return confirm('Delete Image 03');">
            <?php } ?>
            <p>Update Image 03</p>
            <input type="file" name="image_03" class="input" accept="image/*">
         </div>
         <div class="box">
            <?php if (!empty($fetch_property['image_04'])) { ?>
               <img src="uploaded_files/<?= $fetch_property['image_04']; ?>" class="image" alt="">
               <input type="submit" value="Delete Image 04" name="delete_image_04" class="inline-btn" onclick="return confirm('Delete Image 04');">
            <?php } ?>
            <p>Update Image 04</p>
            <input type="file" name="image_04" class="input" accept="image/*">
         </div>
         <div class="box">
            <?php if (!empty($fetch_property['image_05'])) { ?>
               <img src="uploaded_files/<?= $fetch_property['image_05']; ?>" class="image" alt="">
               <input type="submit" value="Delete Image 05" name="delete_image_05" class="inline-btn" onclick="return confirm('Delete Image 05');">
            <?php } ?>
            <p>Update Image 05</p>
            <input type="file" name="image_05" class="input" accept="image/*">
         </div>
      </div>
      <input type="submit" value="Update Property" class="btn" name="update">
   </form>
   <?php } else { ?>
      <p class="empty">Property not found! <a href="post_property.php" style="margin-top:1.5rem;" class="btn">Add New</a></p>
   <?php } ?>
</section>


<!-- Custom JS File Link -->
<script src="js/script.js">

</script>

</body>
</html>
