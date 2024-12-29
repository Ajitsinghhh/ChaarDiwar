<?php
session_start(); // Start the session

include_once 'connect.php';


function sanitize($data) {
    return htmlspecialchars(strip_tags($data));
}

if (isset($_POST['post'])) {
    $id = create_unique_id();
    $user_id = $_SESSION['user_id']; // Assume the user ID is stored in the session

    // Sanitizing inputs
    $property_name = sanitize($_POST['property_name']);
    $price = sanitize($_POST['price']);
    $deposite = sanitize($_POST['deposite']);
    $address = sanitize($_POST['address']);
    $offer = sanitize($_POST['offer']);
    $type = sanitize($_POST['type']);
    $status = sanitize($_POST['status']);
    $furnished = sanitize($_POST['furnished']);
    $bhk = sanitize($_POST['bhk']);
    $bedroom = sanitize($_POST['bedroom']);
    $bathroom = sanitize($_POST['bathroom']);
    $balcony = sanitize($_POST['balcony']);
    $carpet = sanitize($_POST['carpet']);
    $age = sanitize($_POST['age']);
    $total_floors = sanitize($_POST['total_floors']);
    $room_floor = sanitize($_POST['room_floor']);
    $loan = sanitize($_POST['loan']);
    $description = sanitize($_POST['description']);

    // Checkbox handling
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

    // File upload handling
    // Function to sanitize filenames
function sanitizee($filename) {
   return preg_replace("/[^a-zA-Z0-9\-\_\.]/", "", basename($filename));
}

// Create upload directory if it doesn't exist
if (!file_exists('uploaded_files')) {
   mkdir('uploaded_files', 0777, true);
}

function upload_image($file_key) {
   if (!isset($_FILES[$file_key]['name']) || empty($_FILES[$file_key]['name'])) return '';

   // Check for upload errors
   if ($_FILES[$file_key]['error'] !== UPLOAD_ERR_OK) {
       throw new Exception("Error during file upload: " . $_FILES[$file_key]['error']);
   }

   $file_name = sanitizee($_FILES[$file_key]['name']);
   $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
   $new_file_name = create_unique_id() . '.' . $file_ext;
   $file_tmp_name = $_FILES[$file_key]['tmp_name'];
   $file_size = $_FILES[$file_key]['size'];
   $upload_dir = 'uploaded_files/' . $new_file_name;

   if ($file_size > 2000000) {
       throw new Exception("File size of $file_key is too large!");
   }

   // Move the uploaded file to the target directory
   if (!move_uploaded_file($file_tmp_name, $upload_dir)) {
       throw new Exception("Failed to upload $file_key!");
   }

   return $new_file_name;
}

try {
   // Upload images
   $image_01 = upload_image('image_01');
   $image_02 = upload_image('image_02');
   $image_03 = upload_image('image_03');
   $image_04 = upload_image('image_04');
   $image_05 = upload_image('image_05');

   // Insert property into the database
   $insert_property = $conn->prepare("
       INSERT INTO `property`(
           id, user_id, property_name, address, price, type, offer, 
           status, furnished, bhk, deposite, bedroom, bathroom, balcony, 
           carpet, age, total_floors, room_floor, loan, lift, security_guard, 
           play_ground, garden, water_supply, power_backup, parking_area, 
           gym, shopping_mall, hospital, school, market_area, image_01, 
           image_02, image_03, image_04, image_05, description
       ) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
   ");

   $insert_property->execute([
       $id, $user_id, $property_name, $address, $price, $type, $offer, 
       $status, $furnished, $bhk, $deposite, $bedroom, $bathroom, $balcony, 
       $carpet, $age, $total_floors, $room_floor, $loan, $lift, $security_guard, 
       $play_ground, $garden, $water_supply, $power_backup, $parking_area, 
       $gym, $shopping_mall, $hospital, $school, $market_area, $image_01, 
       $image_02, $image_03, $image_04, $image_05, $description
   ]);

   $success_msg[] = 'Property posted successfully!';
} catch (Exception $e) {
   $warning_msg[] = $e->getMessage();
}
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/post.css">
    <style>
    body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h3 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .box {
            margin-bottom: 20px;
        }
        .box p {
            margin-bottom: 5px;
            color: #555;
        }
        .input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .flex {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .flex .box {
            flex: 1 1 calc(50% - 20px);
        }
        .checkbox {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .checkbox .box {
            flex: 1 1 calc(50% - 20px);
        }
        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
        }
        .btn:hover {
            background-color: #0056b3;
        }
      </style>
                
</head>
<body>
    <?php
    include("header_nav.php");
        ?>
        <section class="property-form">

            <form action="" method="POST" enctype="multipart/form-data">
               <h3>property details</h3>
               <div class="box">
                  <p>property name <span>*</span></p>
                  <input type="text" name="property_name" required maxlength="50" placeholder="enter property name" class="input">
               </div>
               <div class="flex">
                  <div class="box">
                     <p>property price <span>*</span></p>
                     <input type="number" name="price" required min="0" max="9999999999" maxlength="10" placeholder="enter property price" class="input">
                  </div>
                  <div class="box">
                     <p>deposite amount <span>*</span></p>
                     <input type="number" name="deposite" required min="0" max="9999999999" maxlength="10" placeholder="enter deposite amount" class="input">
                  </div>
                  <div class="box">
                     <p>property address <span>*</span></p>
                     <input type="text" name="address" required maxlength="100" placeholder="enter property full address" class="input">
                  </div>
                  <div class="box">
                     <p>offer type <span>*</span></p>
                     <select name="offer" required class="input">
                        <option value="sale">sale</option>
                        <option value="resale">resale</option>
                        <option value="rent">rent</option>
                     </select>
                  </div>
                  <div class="box">
                     <p>property type <span>*</span></p>
                     <select name="type" required class="input">
                        <option value="flat">flat</option>
                        <option value="house">house</option>
                        <option value="shop">shop</option>
                     </select>
                  </div>
                  <div class="box">
                     <p>property status <span>*</span></p>
                     <select name="status" required class="input">
                        <option value="ready to move">ready to move</option>
                        <option value="under construction">under construction</option>
                     </select>
                  </div>
                  <div class="box">
                     <p>furnished status <span>*</span></p>
                     <select name="furnished" required class="input">
                        <option value="furnished">furnished</option>
                        <option value="semi-furnished">semi-furnished</option>
                        <option value="unfurnished">unfurnished</option>
                     </select>
                  </div>
                  <div class="box">
                     <p>how many BHK <span>*</span></p>
                     <select name="bhk" required class="input">
                        <option value="1">1 BHK</option>
                        <option value="2">2 BHK</option>
                        <option value="3">3 BHK</option>
                        <option value="4">4 BHK</option>
                        <option value="5">5 BHK</option>
                        <option value="6">6 BHK</option>
                        <option value="7">7 BHK</option>
                        <option value="8">8 BHK</option>
                        <option value="9">9 BHK</option>
                     </select>
                  </div>
                  <div class="box">
                     <p>how many bedrooms <span>*</span></p>
                     <select name="bedroom" required class="input">
                        <option value="0">0 bedroom</option>
                        <option value="1" selected>1 bedroom</option>
                        <option value="2">2 bedroom</option>
                        <option value="3">3 bedroom</option>
                        <option value="4">4 bedroom</option>
                        <option value="5">5 bedroom</option>
                        <option value="6">6 bedroom</option>
                        <option value="7">7 bedroom</option>
                        <option value="8">8 bedroom</option>
                        <option value="9">9 bedroom</option>
                     </select>
                  </div>
                  <div class="box">
                     <p>how many bathrooms <span>*</span></p>
                     <select name="bathroom" required class="input">
                        <option value="1">1 bathroom</option>
                        <option value="2">2 bathroom</option>
                        <option value="3">3 bathroom</option>
                        <option value="4">4 bathroom</option>
                        <option value="5">5 bathroom</option>
                        <option value="6">6 bathroom</option>
                        <option value="7">7 bathroom</option>
                        <option value="8">8 bathroom</option>
                        <option value="9">9 bathroom</option>
                     </select>
                  </div>
                  <div class="box">
                     <p>how many balconys <span>*</span></p>
                     <select name="balcony" required class="input">
                        <option value="0">0 balcony</option>
                        <option value="1">1 balcony</option>
                        <option value="2">2 balcony</option>
                        <option value="3">3 balcony</option>
                        <option value="4">4 balcony</option>
                        <option value="5">5 balcony</option>
                        <option value="6">6 balcony</option>
                        <option value="7">7 balcony</option>
                        <option value="8">8 balcony</option>
                        <option value="9">9 balcony</option>
                     </select>
                  </div>
                  <div class="box">
                     <p>carpet area <span>*</span></p>
                     <input type="number" name="carpet" required min="1" max="9999999999" maxlength="10" placeholder="how many squarefits?" class="input">
                  </div>
                  <div class="box">
                     <p>property age <span>*</span></p>
                     <input type="number" name="age" required min="0" max="99" maxlength="2" placeholder="how old is property?" class="input">
                  </div>
                  <div class="box">
                     <p>total floors <span>*</span></p>
                     <input type="number" name="total_floors" required min="0" max="99" maxlength="2" placeholder="how floors available?" class="input">
                  </div>
                  <div class="box">
                     <p>floor room <span>*</span></p>
                     <input type="number" name="room_floor" required min="0" max="99" maxlength="2" placeholder="property floor number" class="input">
                  </div>
                  <div class="box">
                     <p>loan <span>*</span></p>
                     <select name="loan" required class="input">
                        <option value="available">available</option>
                        <option value="not available">not available</option>
                     </select>
                  </div>
               </div>
               <div class="box">
                  <p>property description <span>*</span></p>
                  <textarea name="description" maxlength="1000" class="input" required cols="30" rows="10" placeholder="write about property..."></textarea>
               </div>
               <div class="checkbox">
                  <div class="box">
                     <p><input type="checkbox" name="lift" value="yes" />lifts</p>
                     <p><input type="checkbox" name="security_guard" value="yes" />security guard</p>
                     <p><input type="checkbox" name="play_ground" value="yes" />play ground</p>
                     <p><input type="checkbox" name="garden" value="yes" />garden</p>
                     <p><input type="checkbox" name="water_supply" value="yes" />water supply</p>
                     <p><input type="checkbox" name="power_backup" value="yes" />power backup</p>
                  </div>
                  <div class="box">
                     <p><input type="checkbox" name="parking_area" value="yes" />parking area</p>
                     <p><input type="checkbox" name="gym" value="yes" />gym</p>
                     <p><input type="checkbox" name="shopping_mall" value="yes" />shopping_mall</p>
                     <p><input type="checkbox" name="hospital" value="yes" />hospital</p>
                     <p><input type="checkbox" name="school" value="yes" />school</p>
                     <p><input type="checkbox" name="market_area" value="yes" />market area</p>
                  </div>
               </div>
               <div class="box">
                  <p>image 01 <span>*</span></p>
                  <input type="file" name="image_01" class="input" accept="image/*" required>
               </div>
               <div class="flex"> 
                  <div class="box">
                     <p>image 02</p>
                     <input type="file" name="image_02" class="input" accept="image/*">
                  </div>
                  <div class="box">
                     <p>image 03</p>
                     <input type="file" name="image_03" class="input" accept="image/*">
                  </div>
                  <div class="box">
                     <p>image 04</p>
                     <input type="file" name="image_04" class="input" accept="image/*">
                  </div>
                  <div class="box">
                     <p>image 05</p>
                     <input type="file" name="image_05" class="input" accept="image/*">
                  </div>   
               </div>
               <input type="submit" value="post property" class="btn" name="post">
            </form>
         
         </section>
</body>



</html>