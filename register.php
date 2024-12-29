<?php 

// Include database connection
include 'connect.php';

// Start the session (this must be at the very top, before any output)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Handling Sign-Up
if (isset($_POST['signUp'])) {
    $id = create_unique_id(); // Unique user ID generation
    $firstName = $_POST['fName']; // First name
    $Pnumber = $_POST['Pnumber']; // Phone number
    $email = $_POST['email']; // Email address
    $password = $_POST['password']; // Password
    $password = md5($password); // Encrypt password using MD5

    // Check if the email already exists
    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        echo "Email Address Already Exists!";
    } else {
        // Insert the new user into the database
        $insertQuery = "INSERT INTO users (id, name, number, email, password) 
                        VALUES ('$id', '$firstName', '$Pnumber', '$email', '$password')";
        if ($conn->query($insertQuery) === TRUE) {
            // Set user_id in session after successful signup
            $_SESSION['user_id'] = $id; 
            header("location: index.php"); // Redirect to index page
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

// Handling Sign-In
if (isset($_POST['signIn'])) {
    $email = $_POST['email']; // Email address
    $password = $_POST['password']; // Password
    $password = md5($password); // Encrypt password using MD5

    // Check if the email and password match a user in the database
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the user data
        $row = $result->fetch_assoc();

        // Set user_id and email in session after login
        $_SESSION['user_id'] = $row['id']; // Save user_id in session
        $_SESSION['email'] = $row['email']; // Save email in session

        header("Location: homepage.php"); // Redirect to homepage
        exit();
    } else {
        echo "Not Found, Incorrect Email or Password";
    }
}
?>
