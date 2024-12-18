<?php
    include '../components/connection.php';
    if (!isset($_SESSION['admin_id'])) 
    {
        header("Location: login.php");
        exit();
    }
    $admin_id = $_SESSION['admin_id'];
?>
<header class="header">
    <div class="flex">
        <a href="dashboard.php" class="logo"><img src="./assets/image/logo.jpg" alt="Logo"></a>
        <nav class="navbar">
            <a href="dashboard.php">Dashboard</a>
            <a href="add_product.php">Add Product</a>
            <a href="view_product.php">View Product</a>
            <a href="user_account.php">Account</a>
        </nav>
        <div class="icons">
            <i class="bx bxs-user" id="user-btn"></i>
            <i class="bx bx-list-plus" id="menu-btn"></i>
        </div>
        <div class="profile-detail">
            <?php
                $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE iID=? ");
                $select_profile->execute([$admin_id]);

                if ($select_profile->num_rows> 0) 
                {
                    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
                <div class="profile">
                    <img src="../image/<?= ($fetch_profile['Profile']) ?>" alt="Profile Image" class="logo-img">
                    <p><?= $fetch_profile['name']; ?></p>
                </div>
                <div class="flex-btn">
                    <a href="profile.php" class="btn">Profile</a><br>
                    <a href="../components/admin_logout.php" onclick="return confirm('Logout?');" class="btn">Logout</a>
                </div>
            <?php 
                } 
            ?>
        </div>
    </div>
</header>