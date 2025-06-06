<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Google Font */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background: #f4f4f4;
    color: #333;
}

/* Header */
.header {
    width: 100%;
    background: #1f1f1f;
    padding: 15px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

/* Close Button */
#close-btn {
    font-size: 20px;
    color: #fff;
    cursor: pointer;
    display: none;
}

/* Logo */
.logo {
    font-size: 22px;
    font-weight: 600;
    color: #00eaff;
    text-decoration: none;
}

/* Navbar */
.navbar {
    display: flex;
    gap: 20px;
}

.navbar a {
    display: flex;
    align-items: center;
    font-size: 16px;
    color: #ddd;
    text-decoration: none;
    padding: 10px 12px;
    transition: 0.3s ease-in-out;
}

.navbar a i {
    margin-right: 8px;
    font-size: 18px;
}

.navbar a:hover {
    background: #00eaff;
    color: #1f1f1f;
    border-radius: 6px;
}

/* Buttons */
.btn, .option-btn, .delete-btn {
    padding: 10px 15px;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    color: #fff;
    border-radius: 6px;
    transition: 0.3s;
}

.btn {
    background: #ff0077;
}

.option-btn {
    background: #444;
}

.delete-btn {
    background: #ff4444;
}

.btn:hover, .option-btn:hover, .delete-btn:hover {
    opacity: 0.8;
}

/* Flex Button Container */
.flex-btn {
    display: flex;
    gap: 10px;
}

/* Menu Button (Mobile) */
#menu-btn {
    font-size: 22px;
    color: #fff;
    cursor: pointer;
    display: none;
}

/* Responsive Design */
@media (max-width: 768px) {
    .navbar {
        position: absolute;
        top: 60px;
        left: 0;
        width: 100%;
        background: #222;
        flex-direction: column;
        text-align: center;
        display: none;
        padding: 10px 0;
    }

    .navbar a {
        display: block;
        padding: 10px;
    }

    #menu-btn {
        display: block;
    }

    #menu-btn:hover + .navbar {
        display: flex;
    }
}



    </style>



</head>
<body>
<header class="header">

<div id="close-btn"><i class="fas fa-times"></i></div>

<a href="dashboard.php" class="logo">AdminPanel.</a>

<nav class="navbar">
   <a href="dashboard.php"><i class="fas fa-home"></i><span>home</span></a>
   <a href="listings.php"><i class="fas fa-building"></i><span>listings</span></a>
   <a href="users.php"><i class="fas fa-user"></i><span>users</span></a>
   <a href="admins.php"><i class="fas fa-user-gear"></i><span>admins</span></a>
   <a href="messages.php"><i class="fas fa-message"></i><span>messages</span></a>
</nav>

<a href="update.php" class="btn">update account</a>
<div class="flex-btn">
   <a href="login.php" class="option-btn">login</a>
   <a href="register.php" class="option-btn">register</a>
</div>
<a href="admin_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn"><i class="fas fa-right-from-bracket"></i><span>logout</span></a>

</header>

<div id="menu-btn" class="fas fa-bars"></div>
</body>
</html>

