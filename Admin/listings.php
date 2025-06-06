<?php

include '../connect.php';

if (isset($_COOKIE['admin_id'])) {
    $admin_id = $_COOKIE['admin_id'];
} else {
    $admin_id = '';
    header('location:login.php');
    exit();
}

if (isset($_POST['delete'])) {
    $delete_id = $_POST['delete_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    $verify_delete = mysqli_prepare($conn, "SELECT * FROM `property` WHERE id = ?");
    mysqli_stmt_bind_param($verify_delete, "i", $delete_id);
    mysqli_stmt_execute($verify_delete);
    $result = mysqli_stmt_get_result($verify_delete);

    if (mysqli_num_rows($result) > 0) {
        $select_images = mysqli_prepare($conn, "SELECT * FROM `property` WHERE id = ?");
        mysqli_stmt_bind_param($select_images, "i", $delete_id);
        mysqli_stmt_execute($select_images);
        $result_images = mysqli_stmt_get_result($select_images);

        while ($fetch_images = mysqli_fetch_assoc($result_images)) {
            $image_01 = $fetch_images['image_01'];
            $image_02 = $fetch_images['image_02'];
            $image_03 = $fetch_images['image_03'];
            $image_04 = $fetch_images['image_04'];
            $image_05 = $fetch_images['image_05'];

            unlink('../uploaded_files/' . $image_01);
            if (!empty($image_02)) unlink('../uploaded_files/' . $image_02);
            if (!empty($image_03)) unlink('../uploaded_files/' . $image_03);
            if (!empty($image_04)) unlink('../uploaded_files/' . $image_04);
            if (!empty($image_05)) unlink('../uploaded_files/' . $image_05);
        }

        $delete_listings = mysqli_prepare($conn, "DELETE FROM `property` WHERE id = ?");
        mysqli_stmt_bind_param($delete_listings, "i", $delete_id);
        mysqli_stmt_execute($delete_listings);

        $success_msg[] = 'Listing deleted!';
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
    <title>Listings</title>

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- Custom CSS -->
    <style>

        /* Admin Dashboard and Listings CSS */

:root {
    --primary-color: #4CAF50;
    --secondary-color: #333;
    --background-color: #f4f4f4;
    --text-color: #222;
    --white: #fff;
    --shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    --border-radius: 10px;
    --danger-color: #e74c3c;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background-color: var(--background-color);
    color: var(--text-color);
}

.heading {
    text-align: center;
    font-size: 2rem;
    margin: 20px 0;
    color: var(--secondary-color);
    text-transform: uppercase;
}

.dashboard, .listings {
    max-width: 1100px;
    margin: 20px auto;
    padding: 20px;
    background: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
}

.box-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    padding: 20px;
}

.box {
    background: var(--white);
    padding: 20px;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    text-align: center;
    transition: transform 0.3s ease-in-out;
}

.box:hover {
    transform: translateY(-5px);
}

.box h3 {
    font-size: 1.5rem;
    color: var(--primary-color);
}

.box p {
    font-size: 1.2rem;
    margin: 10px 0;
    color: var(--secondary-color);
}

.btn, .delete-btn {
    display: inline-block;
    text-decoration: none;
    padding: 10px 15px;
    font-size: 1rem;
    color: var(--white);
    border-radius: 5px;
    transition: background 0.3s;
}

.btn {
    background: var(--primary-color);
}

.btn:hover {
    background: #388e3c;
}

.delete-btn {
    background: var(--danger-color);
}

.delete-btn:hover {
    background: #c0392b;
}

.search-form {
    display: flex;
    justify-content: center;
    margin: 20px 0;
}

.search-form input {
    padding: 10px;
    width: 60%;
    border: 1px solid var(--secondary-color);
    border-radius: var(--border-radius);
    font-size: 1rem;
}

.search-form button {
    padding: 10px;
    background: var(--primary-color);
    color: var(--white);
    border: none;
    cursor: pointer;
    font-size: 1rem;
    border-radius: var(--border-radius);
    margin-left: 5px;
}

.thumb {
    position: relative;
}

.thumb p {
    position: absolute;
    top: 10px;
    left: 10px;
    background: rgba(0, 0, 0, 0.7);
    color: var(--white);
    padding: 5px 10px;
    border-radius: var(--border-radius);
    font-size: 0.9rem;
}

.thumb img {
    width: 100%;
    border-radius: var(--border-radius);
}

@media (max-width: 768px) {
    .box-container {
        grid-template-columns: 1fr;
    }

    .search-form input {
        width: 80%;
    }
}

    </style>
</head>
<body>

<!-- Header -->
<?php include '../Admin/admin_header.php'; ?>

<section class="listings">

    <h1 class="heading">All Listings</h1>

    <form action="" method="POST" class="search-form">
        <input type="text" name="search_box" placeholder="Search listings..." maxlength="100" required>
        <button type="submit" class="fas fa-search" name="search_btn"></button>
    </form>

    <div class="box-container">

        <?php
        if (isset($_POST['search_box']) || isset($_POST['search_btn'])) {
            $search_box = $_POST['search_box'];
            $search_box = filter_var($search_box, FILTER_SANITIZE_STRING);
            $query = "SELECT * FROM `property` WHERE property_name LIKE ? OR address LIKE ? ORDER BY date DESC";
            $select_listings = mysqli_prepare($conn, $query);
            $search_term = "%{$search_box}%";
            mysqli_stmt_bind_param($select_listings, "ss", $search_term, $search_term);
            mysqli_stmt_execute($select_listings);
            $result = mysqli_stmt_get_result($select_listings);
        } else {
            $query = "SELECT * FROM `property` ORDER BY date DESC";
            $result = mysqli_query($conn, $query);
        }

        if (mysqli_num_rows($result) > 0) {
            while ($fetch_listing = mysqli_fetch_assoc($result)) {
                $listing_id = $fetch_listing['id'];

                $select_user = mysqli_prepare($conn, "SELECT * FROM `users` WHERE id = ?");
                mysqli_stmt_bind_param($select_user, "i", $fetch_listing['user_id']);
                mysqli_stmt_execute($select_user);
                $result_user = mysqli_stmt_get_result($select_user);
                $fetch_user = mysqli_fetch_assoc($result_user);

                $total_images = 1;
                for ($i = 2; $i <= 5; $i++) {
                    if (!empty($fetch_listing['image_0' . $i])) {
                        $total_images++;
                    }
                }
        ?>

        <div class="box">
            <div class="thumb">
                <p><i class="far fa-image"></i><span><?= $total_images; ?></span></p>
                <img src="../uploaded_files/<?= $fetch_listing['image_01']; ?>" alt="">
            </div>
            <p class="price"><i class="fas fa-indian-rupee-sign"></i><?= $fetch_listing['price']; ?></p>
            <h3 class="name"><?= htmlspecialchars($fetch_listing['property_name']); ?></h3>
            <p class="location"><i class="fas fa-map-marker-alt"></i><?= htmlspecialchars($fetch_listing['address']); ?></p>
            <form action="" method="POST">
                <input type="hidden" name="delete_id" value="<?= $listing_id; ?>">
                <a href="view_property.php?get_id=<?= $listing_id; ?>" class="btn">View Property</a>
                <input type="submit" value="Delete Listing" onclick="return confirm('Delete this listing?');" name="delete" class="delete-btn">
            </form>
        </div>

        <?php
            }
        } elseif (isset($_POST['search_box']) || isset($_POST['search_btn'])) {
            echo '<p class="empty">No results found!</p>';
        } else {
            echo '<p class="empty">No property posted yet!</p>';
        }
        ?>

    </div>

</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- Custom JS -->
<script src="../assets/js/admin_script.js"></script>

<?php include '../Admin/message.php'; ?>

</body>
</html>
