<?php
include '../components/connection.php';
include '../mail/email.php';

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

// Logout functionality
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: ../login.php");
    exit();
}
?>
<header class="header">
    <div class="flex">
        <a href="dashboard.php" class="logo"><img src="../assets/image/logo.jpg" alt="Logo"></a>
        <nav class="navbar">
            <a href="dashboard.php">Dashboard</a>
            <a href="add_products.php">Add Product</a>
            <a href="view_product.php?id=-1">View Product</a>
            <a href="user_account.php?user=all">Account</a>
            <a href = "register.php">Add New Admin</a>
        </nav>
        <div class="icons">
            <i class="bx bxs-user" id="user-btn"></i>
            <i class="bx bx-list-plus" id="menu-btn" style="font-size: 2rem;"></i>
        </div>
        <div class="user-box" id="user-box">
            <p>Username : <span><?= isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest'; ?></span></p>
            <p>Email : <span><?= isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'Not logged in'; ?></span></p>
            <form action="" method="post">
                <button type="submit" name="logout" class="logout-btn">Log out</button>
            </form>
        </div>
    </div>
</header>
<link rel="stylesheet" href="../admin/admin_style.css">
<!--<script src="../admin/script.js"></script> -->
<script src="../admin/script.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
    const userBtn = document.getElementById('user-btn');
    const menuBtn = document.getElementById('menu-btn');
    const userBox = document.getElementById('user-box');
    const navbar = document.querySelector('.navbar');

    // Toggle user-box visibility
    userBtn.addEventListener('click', () => {
        userBox.classList.toggle('active');
        navbar.classList.remove('active'); // Ensure the navbar is not visible
    });

    // Toggle navbar visibility
    menuBtn.addEventListener('click', () => {
        navbar.classList.toggle('active');
        userBox.classList.remove('active'); // Ensure the user-box is not visible
    });

    // Hide both when clicking outside
    document.addEventListener('click', (e) => {
        if (!userBtn.contains(e.target) && !userBox.contains(e.target)) {
            userBox.classList.remove('active');
        }
        if (!menuBtn.contains(e.target) && !navbar.contains(e.target)) {
            navbar.classList.remove('active');
        }
    });
});
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
