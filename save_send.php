<?php
include 'connect.php';

if (isset($_POST['save'])) {
   if ($user_id != '') {

      $save_id = create_unique_id();
      $property_id = $_POST['property_id'];
      $property_id = filter_var($property_id, FILTER_SANITIZE_STRING);

      // Verify if the listing is already saved
      $verify_saved = $conn->query("SELECT * FROM `saved` WHERE property_id = '$property_id' AND user_id = '$user_id'");

      if ($verify_saved->num_rows > 0) {
         // Remove from saved
         $remove_saved = $conn->query("DELETE FROM `saved` WHERE property_id = '$property_id' AND user_id = '$user_id'");
      echo "<script>alert('Removed from saved!');</script>";
      $_SESSION['success_msg'] = 'Removed from saved!';

      } else {
         // Save the listing
         $insert_saved = $conn->query("INSERT INTO `saved` (id, property_id, user_id) VALUES ('$save_id', '$property_id', '$user_id')");
         if ($insert_saved) {
         echo "<script>alert('Listing saved!');</script>";
         $_SESSION['success_msg'] = 'Listing saved!';

         } else {
         echo "<script>alert('Error saving listing: " . $conn->error . "');</script>";
         $_SESSION['warning_msg'] = 'Error saving listing: ' . $conn->error;

         }
      }
      header('Location: view_property.php?get_id=' . $property_id); // Redirect back to the property view
      exit;

   } else {
      $_SESSION['warning_msg'] = 'Please login first!';
      header('Location: login.php'); // Redirect to login if not logged in
      exit;
   }
}

if (isset($_POST['send'])) {
   if ($user_id != '') {
      $request_id = create_unique_id();
      $property_id = $_POST['property_id'];
      $property_id = filter_var($property_id, FILTER_SANITIZE_STRING);

      // Fetch the receiver ID
      $select_receiver = $conn->query("SELECT user_id FROM `property` WHERE id = '$property_id' LIMIT 1");
      $fetch_receiver = $select_receiver->fetch_assoc();
      $receiver = $fetch_receiver['user_id'];

      // Verify if the request is already sent
      $verify_request = $conn->query("SELECT * FROM `requests` WHERE property_id = '$property_id' AND sender = '$user_id' AND receiver = '$receiver'");

      if ($verify_request->num_rows > 0) {
         echo "<script>alert('Request sent already!');</script>";
         $_SESSION['warning_msg'] = 'Request sent already!';

      } else {
         // Send the request
         $send_request = $conn->query("INSERT INTO `requests` (id, property_id, sender, receiver) VALUES ('$request_id', '$property_id', '$user_id', '$receiver')");
         if ($send_request) {
         echo "<script>alert('Request sent successfully!');</script>";
         $_SESSION['success_msg'] = 'Request sent successfully!';

         } else {
         echo "<script>alert('Error sending request: " . $conn->error . "');</script>";
         $_SESSION['warning_msg'] = 'Error sending request: ' . $conn->error;

         }
      }
      header('Location: view_property.php?get_id=' . $property_id); // Redirect back to the property view
      exit;

   } else {
      $_SESSION['warning_msg'] = 'Please login first!';
      header('Location: login.php'); // Redirect to login if not logged in
      exit;
   }
}
?>
