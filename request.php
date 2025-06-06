<?php  

// Start the session
session_start();

// Connect to the database using MySQLi
include 'connect.php';
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if user_id is set in session
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('Location: login.php');
   exit;
}

if(isset($_POST['delete'])){

   $delete_id = $_POST['request_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   // Verify if the request exists
   $verify_delete = mysqli_query($conn, "SELECT * FROM `requests` WHERE id = '$delete_id'");

   if(mysqli_num_rows($verify_delete) > 0){
      // Delete the request
      mysqli_query($conn, "DELETE FROM `requests` WHERE id = '$delete_id'");
      $success_msg[] = 'Request deleted successfully!';
   } else {
      $warning_msg[] = 'Request already deleted!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Requests</title>

   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- Custom CSS File Link -->
    <style>
      /* Requests Section Styling */
/* Requests Section Styling */
/* Requests Section Styling */
.requests {
   padding: 2rem;
   background: #f3f6f9;
}

.requests .heading {
   text-align: center;
   font-size: 2.5rem;
   color: #1e1e2d;
   margin-bottom: 2rem;
   font-weight: bold;
   text-transform: uppercase;
}

.requests .box-container {
   display: grid;
   grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
   gap: 1.5rem;
   justify-content: center;
}

.requests .box {
   width: 100%;
   max-width: 350px;
   height: 330px; /* Fixed height */
   background: #ffffff;
   border-radius: 12px;
   box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
   padding: 1.5rem;
   transition: transform 0.3s ease, box-shadow 0.3s ease;
   border: 1px solid #e0e0e0;
   display: flex;
   flex-direction: column;
   justify-content: space-between;
}

.requests .box:hover {
   transform: translateY(-10px);
   box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
}

.requests .box p {
   font-size: 1rem;
   color: #4a4a6a;
   margin: 0.5rem 0;
   line-height: 1.6;
}

.requests .box p span {
   font-weight: bold;
   color: #0d6efd;
}

.requests .box a {
   font-weight: bold;
   color: #0d6efd;
   text-decoration: none;
}

.requests .box a:hover {
   text-decoration: underline;
}

.requests .btn {
   display: inline-block;
   margin: 0.5rem 0.25rem 0;
   padding: 0.7rem 1.6rem;
   font-size: 1rem;
   color: #ffffff;
   background: #0d6efd;
   border: none;
   border-radius: 8px;
   cursor: pointer;
   text-align: center;
   transition: background 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
}

.requests .btn:hover {
   background: #0056b3;
   box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
   transform: scale(1.05);
}

.requests .btn:active {
   transform: scale(1);
}

.requests .btn.delete-btn {
   background: #dc3545;
}

.requests .btn.delete-btn:hover {
   background: #b02a37;
}

.requests .empty {
   text-align: center;
   font-size: 1.3rem;
   color: #6c757d;
   margin-top: 2rem;
}

/* Responsive Design */
@media (max-width: 768px) {
   .requests .heading {
      font-size: 2rem;
   }

   .requests .box {
      max-width: 100%;
      height: auto; /* Let height adjust on smaller screens */
   }

   .requests .btn {
      font-size: 0.9rem;
      padding: 0.6rem 1.2rem;
   }
}

</style>
</head>
<body>
   
 
<section class="requests">

   <h1 class="heading">All Requests</h1>

   <div class="box-container">

   <?php
      // Fetch requests for the logged-in user
      $select_requests = mysqli_query($conn, "SELECT * FROM `requests` WHERE receiver = '$user_id'");
      if(mysqli_num_rows($select_requests) > 0){
         while($fetch_request = mysqli_fetch_assoc($select_requests)){

            // Fetch sender details
            $sender_id = $fetch_request['sender'];
            $select_sender = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$sender_id'");
            $fetch_sender = mysqli_fetch_assoc($select_sender);

            // Fetch property details
            $property_id = $fetch_request['property_id'];
            $select_property = mysqli_query($conn, "SELECT * FROM `property` WHERE id = '$property_id'");
            $fetch_property = mysqli_fetch_assoc($select_property);
   ?>
   <div class="box">
      <p>Name: <span><?= htmlspecialchars($fetch_sender['name']); ?></span></p>
      <p>Number: <a href="tel:<?= htmlspecialchars($fetch_sender['number']); ?>"><?= htmlspecialchars($fetch_sender['number']); ?></a></p>
      <p>Email: <a href="mailto:<?= htmlspecialchars($fetch_sender['email']); ?>"><?= htmlspecialchars($fetch_sender['email']); ?></a></p>
      <p>Enquiry for: <span><?= htmlspecialchars($fetch_property['property_name']); ?></span></p>
      <form action="" method="POST">
         <input type="hidden" name="request_id" value="<?= htmlspecialchars($fetch_request['id']); ?>">
         <input type="submit" value="Delete Request" class="btn" onclick="return confirm('Remove this request?');" name="delete">
         <a href="view_property.php?get_id=<?= htmlspecialchars($fetch_property['id']); ?>" class="btn">View Property</a>
      </form>
   </div>
   <?php
         }
      } else {
         echo '<p class="empty">You have no requests!</p>';
      }
   ?>

   </div>

</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>


<!-- Custom JS File Link -->
<script src="js/script.js"></script>


</body>
</html>
