<?php
include '../components/connection.php';


$admin_id = $_SESSION['user_id'] ?? null;

if (!$admin_id) {
    header("Location: ../login.php");
    exit();
}

// Fetch the admin profile data
$select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$select_profile->bind_param("i", $admin_id);
$select_profile->execute();
$result = $select_profile->get_result();

$fetch_profile = $result->num_rows > 0 ? $result->fetch_assoc() : null;

// Define the directory and base file name
$imageDir = "../image/admin/";
$imageBase = $fetch_profile['id'] ?? 'default';

// Supported file extensions
$supportedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

// Find the correct file
$imagePath = null;
foreach ($supportedExtensions as $extension) {
    $filePath = $imageDir . $imageBase . '.' . $extension;
    if (file_exists($filePath)) {
        $imagePath = $filePath;
        break;
    }
}

// If no valid file exists, use a default image
if (!$imagePath) {
    $imagePath = "../image/default_user.jpg";
}
?>
<header class="header">
    <div class="flex">
        <a href="dashboard.php" class="logo"><img src="../assets/image/logo.jpg" alt="Logo"></a>
        <nav class="navbar">
            <a href="dashboard.php">Dashboard</a>
            <a href="add_products.php">Add Product</a>
            <a href="view_product.php">View Product</a>
            <a href="user_account.php">Account</a>
        </nav>
        <div class="icons">
            <i class="bx bxs-user" id="user-btn"></i>
            <i class="bx bx-list-plus" id="menu-btn"></i>
        </div>
        <div class="profile-detail">
            <?php if ($fetch_profile): ?>
                <div class="profile">
                    <img src="<?= ($imagePath); ?>" alt="Profile Image">
                    <p><?= ($fetch_profile['name']); ?></p>
                </div>
                <div class="flex-btn">
                    <a href="../admin/profile.php" class="btn">Profile</a><br>
                    <a href="../login.php" onclick="return confirm('Logout?');" class="btn">Logout</a>
                </div>
            <?php else: ?>
                <p>Profile not found. Please log in again.</p>
            <?php endif; ?>
        </div>
    </div>
</header>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="script.js" type="text/javascript"></script>
