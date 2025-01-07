<?php
include '../components/connection.php';
include '../image_manager.php';
include "../components/alert.php";
include '../validitycheck.php';


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
        $success_msg[] = "Profile image updated successfully.";
    else 
        $error_msg[] = "Failed to upload image.";

    if ($update_profile->execute()) 
        $success_msg[] = "Profile updated successfully.";
}

if (isset($_POST['update_password'])) 
{
    $old_password = filter_var($_POST['old_password'], FILTER_SANITIZE_STRING);
    $new_password = filter_var($_POST['new_password'], FILTER_SANITIZE_STRING);
    $confirm_password = filter_var($_POST['confirm_password'], FILTER_SANITIZE_STRING);

    // Check if the new password matches the confirm password
    if ($new_password === $confirm_password) 
    {
        // Verify old password matches
        if (password_verify($old_password, $admin_data['password']))
        {
            // Check if the new password is strong
                $password_validation = isStrongPassword($new_password);
                if ($password_validation === true)
                {
                    $hashed_new_password = password_hash($new_password, PASSWORD_BCRYPT);
                    $update_password = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
                    $update_password->bind_param("si", $hashed_new_password, $admin_id);

                if ($update_password->execute()) 
                    $success_msg[] = "Password updated successfully.";
                else 
                    $error_msg[] = "Failed to update password. Please try again.";
            } 
            else 
                $error_msg[] = $password_validation;
        } 
        else 
            $error_msg[] = "Old password is incorrect.";
    } 
    else 
        $error_msg[] = "New password and confirm password do not match.";
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
                        <a onclick="togglePasswordMode()" class="btn">Change Password</a>
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

                    <div class="password-mode <?php echo isset($password_mode) && $password_mode ? '' : 'hidden'; ?>">
                        <form action="" method="post" enctype="multipart/form-data" class="form">
                            <div class="input-group">
                                <label>Old Password:</label>
                                <input type="password" name="old_password" required>
                            </div>
                            <div class="input-group">
                                <label>New Password:</label>
                                <input type="password" name="new_password" required>
                            </div>
                            <div class="input-group">
                                <label>Confirm Password:</label>
                                <input type="password" name="confirm_password" required>
                            </div>
                            <button type="submit" name="update_password" class="btn">Change Password</button>
                            <a type="button" onclick="togglePasswordMode()" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>

                </div>
            </div>
        </section>

        <?php //foreach ($message as $msg): ?>
           <!-- <div class="message"><?php //echo $msg; ?></div>-->
        <?php //endforeach; ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js" type="text/javascript"></script>
</body>
</html>
