<?php
include '../components/connection.php';
include '../validitycheck.php';
session_start();
if ($_SESSION['user_type'] !== 'Admin') 
    header('Location: ../login.php');

    if (isset($_POST['update_password'])) 
    {
        $old_password = filter_var($_POST['old_password'], FILTER_SANITIZE_STRING);
        $new_password = filter_var($_POST['new_password'], FILTER_SANITIZE_STRING);
        $confirm_password = filter_var($_POST['confirm_password'], FILTER_SANITIZE_STRING);
    
        // Check if the new password matches the confirm password
        if ($new_password === $confirm_password) 
        {
            $sql = "SELECT password FROM users WHERE id = '$_SESSION[user_id]'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    
            if (password_verify($old_password, $row['password']))  // Verify old password matches
            {
                $password_validation = isStrongPassword($new_password);  // Check if the new password is strong
                if ($password_validation === true) 
                {
                    $hashed_new_password = password_hash($new_password, PASSWORD_BCRYPT);
                    $sql_update = "UPDATE users SET password = '$hashed_new_password' WHERE id = '$_SESSION[user_id]'";
                    if (mysqli_query($conn, $sql_update)) 
                    {
                        $succcess_msg[] = "Password updated successfully.";
                        header("Location: profile.php");
                    } 
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
<body>
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
                        <button type="button" onclick="window.location.href='profile.php'" class="btn">Cancel</button>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalerts.min.js"></script>
    <script src = "script.js"></script>
    <?php include '../components/alert.php'; ?>

</body>
</html>