<?php
// Database connection
session_start();

include 'connect.php';

// Check if user is logged in via session
if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
}
// Get the search term from the URL
$location = isset($_GET['location']) ? $_GET['location'] : '';

// Prepare the SQL query
$sql = "SELECT * FROM property WHERE address LIKE ?";
$stmt = $conn->prepare($sql);
$searchTerm = "%$location%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the results
$properties = [];
while ($row = $result->fetch_assoc()) {
    $properties[] = $row;
}

// Close the statement and connection
$stmt->close();
?>

<?php include 'header_nav.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/search.css"> <!-- Link to new CSS file -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }
        .heading {
            text-align: center;
            font-size: 2.5rem;
            margin: 2rem 0;
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
        .price {
            font-size: 1.5rem;
            color: #e74c3c;
            margin: 1rem;
        }
        .name {
            font-size: 1.2rem;
            margin: 0 1rem;
        }
        .location {
            font-size: 1rem;
            margin: 0.5rem 1rem;
            color: #777;
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
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: rgb(50, 210, 197);
        }
        .empty {
            text-align: center;
            font-size: 1.2rem;
            color: #777;
        }

        .heading {
            text-align: center;
            font-size: 2.5rem;
            margin: 2rem 0;
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
        .price {
            font-size: 1.5rem;
            color: #e74c3c;
            margin: 1rem;
        }
        .name {
            font-size: 1.2rem;
            margin: 0 1rem;
        }
        .location {
            font-size: 1rem;
            margin: 0.5rem 1rem;
            color: #777;
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
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: rgb(50, 210, 197);
        }
        .empty {
            text-align: center;
            font-size: 1.2rem;
            color: #777;
        }
    </style>
</head>
<body>
    <h1>Search Results for "<?php echo htmlspecialchars($location); ?>"</h1>
    <div class="box-container">
        <?php if (count($properties) > 0): ?>
            <?php foreach ($properties as $property): ?>
                <?php
                // Fetch user details
                $user_id_property = $property['user_id'];
                $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id_property'");
                $fetch_user = mysqli_fetch_assoc($select_user);

                // Calculate the total images
                $total_images = 1; // Count `image_01` as default
                for ($i = 2; $i <= 5; $i++) {
                    $image_field = "image_0$i";
                    if (!empty($property[$image_field])) {
                        $total_images++;
                    }
                }

                // Check if the property is saved
                $property_id = $property['id'];
                $check_saved = mysqli_query($conn, "SELECT * FROM `saved` WHERE property_id = '$property_id' AND user_id = '$user_id'");
                ?>
                <form action="" method="POST">
                    <div class="box">
                        <input type="hidden" name="property_id" value="<?= htmlspecialchars($property_id); ?>">
                        <?php if (mysqli_num_rows($check_saved) > 0): ?>
                            <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>Saved</span></button>
                        <?php else: ?>
                            <button type="submit" name="save" class="save"><i class="far fa-heart"></i><span>Save</span></button>
                        <?php endif; ?>
                        <div class="thumb">
                            <p class="total-images"><i class="far fa-image"></i><span><?= $total_images; ?></span></p>
                            <img src="uploaded_files/<?= htmlspecialchars($property['image_01']); ?>" alt="">
                        </div>
                        <div class="admin">
                            <h3><?= htmlspecialchars(substr($fetch_user['name'], 0, 1)); ?></h3>
                            <div>
                                <p><?= htmlspecialchars($fetch_user['name']); ?></p>
                                <span><?= htmlspecialchars($property['date']); ?></span>
                            </div>
                        </div>
                        <div class="price"><i class="fas fa-indian-rupee-sign"></i><span><?= htmlspecialchars($property['price']); ?></span></div>
                        <h3 class="name"><?= htmlspecialchars($property['property_name']); ?></h3>
                        <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= htmlspecialchars($property['address']); ?></span></p>
                        <div class="flex">
                            <p><i class="fas fa-house"></i><span><?= htmlspecialchars($property['type']); ?></span></p>
                            <p><i class="fas fa-tag"></i><span><?= htmlspecialchars($property['offer']); ?></span></p>
                            <p><i class="fas fa-bed"></i><span><?= htmlspecialchars($property['bhk']); ?> BHK</span></p>
                            <p><i class="fas fa-trowel"></i><span><?= htmlspecialchars($property['status']); ?></span></p>
                            <p><i class="fas fa-couch"></i><span><?= htmlspecialchars($property['furnished']); ?></span></p>
                            <p><i class="fas fa-maximize"></i><span><?= htmlspecialchars($property['carpet']); ?> sqft</span></p>
                        </div>
                        <div class="flex-btn">
                            <a href="view_property.php?get_id=<?= htmlspecialchars($property['id']); ?>" class="btn">View Property</a>
                            <input type="submit" value="Send Enquiry" name="send" class="btn">
                        </div>
                    </div>
                </form>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="empty">No properties found for the given location.</p>
        <?php endif; ?>
    </div>
</body>
</html>
