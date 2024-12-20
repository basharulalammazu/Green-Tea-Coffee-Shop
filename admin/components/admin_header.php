<?php
<<<<<<< HEAD
    include '../components/connection.php';

    $admin_id = $_SESSION['user_id'];

    if (!isset($admin_id)) 
    {
        header("Location: ../login.php");

        exit();
    }
        


    // Define the directory and base file name
    $imageDir = "../image/admin/";
    $imageBase = $fetch_profile['id']; // ID of the admin

    // Supported file extensions
    $supportedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    // Find the correct file
    $imagePath = null;
    foreach ($supportedExtensions as $extension) 
    {
        $filePath = $imageDir . $imageBase . '.' . $extension;
        if (file_exists($filePath)) 
        {
            $imagePath = $filePath;
            break;
        }
=======
include '../components/connection.php';

$admin_id = $_SESSION['user_id'];

if (!isset($admin_id)) {
    header("Location: ../login.php");
    exit();
}

// Fetch the admin profile data
$select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$select_profile->bind_param("i", $admin_id); 
$select_profile->execute();
$result = $select_profile->get_result();

if ($result->num_rows > 0) 
    $fetch_profile = $result->fetch_assoc(); // Fetch the admin's data
else 
    $fetch_profile = null; // Set to null if no profile data exists


// Define the directory and base file name
$imageDir = "../image/admin/";
$imageBase = $fetch_profile['id'] ?? 'default'; // Use 'default' if $fetch_profile is null

// Supported file extensions
$supportedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

// Find the correct file
$imagePath = null;
foreach ($supportedExtensions as $extension) 
{
    $filePath = $imageDir . $imageBase . '.' . $extension;
    if (file_exists($filePath)) 
    {
        $imagePath = $filePath;
        break;
    }
>>>>>>> 3ab7a8422473027efed904f1b42b1ac99df644b5
}

// If no valid file exists, use a default image
if (!$imagePath) 
<<<<<<< HEAD
    $imagePath = $imageDir . "default.png"; // Replace with your placeholder image
?>
<header class="header">
    <div class="flex">
        <a href="dashboard.php" class="logo"><img src="./assets/image/logo.jpg" alt="Logo"></a>
        <nav class="navbar">
            <a href="dashboard.php">Dashboard</a>
            <a href="add_product.php">Add Product</a>
=======
    $imagePath = "../image/default_user.jpg"; 
?>
<header class="header">
    <div class="flex">
        <a href="dashboard.php" class="logo"><img src="../assets/image/logo.jpg" alt="Logo"></a>
        <nav class="navbar">
            <a href="dashboard.php">Dashboard</a>
            <a href="add_products.php">Add Product</a>
>>>>>>> 3ab7a8422473027efed904f1b42b1ac99df644b5
            <a href="view_product.php">View Product</a>
            <a href="user_account.php">Account</a>
        </nav>
        <div class="icons">
            <i class="bx bxs-user" id="user-btn"></i>
            <i class="bx bx-list-plus" id="menu-btn"></i>
        </div>
        <div class="profile-detail">
            <?php
<<<<<<< HEAD
                $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                $select_profile->bind_param("i", $admin_id); 

                $select_profile->execute();

                $result = $select_profile->get_result();

                if ($result->num_rows > 0) 
                {
                    $fetch_profile = $result->fetch_assoc();
            ?>
                <div class="profile">
                    <img src="<?= $imagePath ?>" alt="Profile Image">
=======
            if ($fetch_profile) 
            { 
            ?>
                <div class="profile">
                    <img src="<?= htmlspecialchars($imagePath); ?>" alt="Profile Image">
>>>>>>> 3ab7a8422473027efed904f1b42b1ac99df644b5
                    <p><?= htmlspecialchars($fetch_profile['name']); ?></p>
                </div>
                <div class="flex-btn">
                    <a href="profile.php" class="btn">Profile</a><br>
                    <a href="../login.php" onclick="return confirm('Logout?');" class="btn">Logout</a>
                </div>
            <?php 
<<<<<<< HEAD
                } 
            ?>
        </div>
    </div>
</header>
=======
            } 
            else  
                echo "<p>Profile not found. Please log in again.</p>";
            ?>
        </div>
    </div>
</header>
>>>>>>> 3ab7a8422473027efed904f1b42b1ac99df644b5
