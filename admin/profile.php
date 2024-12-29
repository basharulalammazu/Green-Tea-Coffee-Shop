<?php
include '../components/connection.php';
include '../image_manager.php';

session_start();

// Check if the admin is logged in
if (!isset($_SESSION['user_id'])) 
{
    header('Location: login.php');
    exit();
}

$admin_id = $_SESSION['user_id'];
$message = [];

// Fetch admin data
$fetch_admin = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$fetch_admin->bind_param("i", $admin_id);
$fetch_admin->execute();
$result = $fetch_admin->get_result();
$admin_data = $result->fetch_assoc();

// Handle form submissions
if (isset($_POST['update_profile'])) 
{
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
    $image = $_FILES['image'];

    $update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ?, phone_number = ? WHERE id = ?");
    $update_profile->bind_param("sssi", $name, $email, $phone, $admin_id);
    
    $uploadError = update_image('admin', $admin_id, $image);

    if (!$uploadError) 
        $message[] = "Profile image updated successfully.";
    else 
        $message[] = "Failed to upload image.";

    if ($update_profile->execute()) 
        $message[] = "Profile updated successfully.";
}

if (isset($_POST['update_password'])) 
{
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (password_verify($old_password, $admin_data['password'])) 
    {
        if ($new_password === $confirm_password) 
        {
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
            $update_password = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
            $update_password->bind_param("si", $new_password, $admin_id);
            $update_password->execute();
            $message[] = "Password updated successfully.";
        } 
        else 
            $message[] = "New passwords do not match.";
    } 
    else 
        $message[] = "Incorrect old password.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="admin_style.css?v=<?php echo time(); ?>">
    <title>Admin Profile</title>
    <script>
        // Toggle display mode and edit mode visibility
    </script>
</head>
<body>
    <?php 
        include 'components/admin_header.php'; 
        include '../components/alert.php';
    ?>
    <div class="main">
        <div class="banner">
            <h1>Admin Profile</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">Home</a><span> / Profile</span>
        </div>
        <section class="dashboard">
            <h1 class="heading">Profile</h1>
            <div class="box-container">
                <div class="box">
                    <!-- Display Mode (Visible initially) -->
                    <div class="display-mode">
                        <?php 
                            $profile_image = get_image_path($admin_data['id'], 'admin') // Default image
                        ?>
                        <img src="<?php echo $profile_image; ?>" alt="Profile Image" class="profile-image">
                        <p><strong>Name:</strong> <?php echo $admin_data['name']; ?></p>
                        <p><strong>Email:</strong> <?php echo $admin_data['email']; ?></p>
                        <p><strong>Phone:</strong> <?php echo $admin_data['phone_number']; ?></p>
                        <a onclick="toggleEditMode()" class="btn">Edit Profile</a>
                    </div>

                    <!-- Edit Mode (Initially hidden) -->
                    <div class="edit-mode hidden">
                        <form action="" method="post" enctype="multipart/form-data" class="form">
                            <div class="input-group">
                                <label>Name:</label>
                                <input type="text" name="name" value="<?php echo $admin_data['name']; ?>" required>
                            </div>
                            <div class="input-group">
                                <label>Email:</label>
                                <input type="email" name="email" value="<?php echo $admin_data['email']; ?>" required>
                            </div>
                            <div class="input-group">
                                <label>Phone:</label>
                                <input type="text" name="phone" value="<?php echo $admin_data['phone_number']; ?>" required>
                            </div>
                            <div class="input-group">
                                <label>Profile Image:</label>
                                <input type="file" name="image">
                            </div>
                            <button type="submit" name="update_profile" class="btn">Save Changes</button>
                            <a type="button" onclick="toggleEditMode()" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <?php foreach ($message as $msg): ?>
            <div class="message"><?php echo $msg; ?></div>
        <?php endforeach; ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js" type="text/javascript"></script>
</body>
</html>
