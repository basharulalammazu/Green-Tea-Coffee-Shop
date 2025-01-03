<?php
include 'components/connection.php';
include 'mail/email.php';
session_start();

// Initialize variables
$message = [];
$otp_sent = false;

if (isset($_POST['send_otp'])) {
    // Retrieve and sanitize the email input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Check if the email exists for a customer in the database
    $sql = "SELECT * FROM `users` WHERE email = '$email' AND user_type = 'Customer'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) 
    {
        // Generate a 6-digit OTP
        $otp = rand(100000, 999999);
        
        // Save OTP and email in session for verification
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;

        // Simulate sending OTP (In real application, use mail or SMS API)
        //$message[] = "OTP sent to your email: $otp (Mocked for demo).";
        if (sendOTP($email, $otp)) 
        {
            $otp_sent = true;
            $succcess_msg[] = "OTP sent to your email: $email. Check your email and verify the OTP.";
        }
        else 
            $warning_msg[] = "Failed to send OTP. Please try again.";
        
    } 
    else 
        $warning_msg[] = "No account associated with this email. Please check your email address.";
    
}

if (isset($_POST['verify_otp'])) 
{
    // Retrieve and sanitize OTP input
    $entered_otp = filter_var($_POST['otp'], FILTER_SANITIZE_NUMBER_INT);

    // Verify the OTP
    if ($entered_otp == $_SESSION['otp']) 
    {
        $warning_msg[] = "OTP verified. You can now reset your password.";
        $_SESSION['otp_verified'] = true;
    }
    else 
        $warning_msg[] = "Invalid OTP. Please try again.";
    
}

if (isset($_POST['change_password'])) 
{
    // Retrieve and sanitize inputs
    $new_password = filter_var($_POST['new_password'], FILTER_SANITIZE_STRING);
    $confirm_password = filter_var($_POST['confirm_password'], FILTER_SANITIZE_STRING);

    if ($new_password != $confirm_password) 
    {
        $warning_msg[] = "Passwords do not match. Please try again.";
        return;
    } 
            // Prepare statement to check user in the database
            $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
            $select_user->bind_param("s", $_SESSION['email']); 
            $select_user->execute();
    
            
            $result = $select_user->get_result(); 
            $row = $result->fetch_assoc();
    
            // Check if user exists
            // Encrypt the password and compare with the database
            if (password_verify($$new_password, $row['password']))
            {
                $warning_msg[] = "New password cannot be the same as the old password. Please try again.";
                exit();
            }
    
            $hashed_pass = password_hash($new_password, PASSWORD_BCRYPT);
    
            // Update the password in the database
            $update_password = $conn->prepare("UPDATE `users` SET password = ? WHERE email = ?");
            $update_password->bind_param("ss", $hashed_pass, $_SESSION['email']);
            $update_password->execute();
    
            // Clear session variables and redirect
            unset($_SESSION['otp'], $_SESSION['otp_verified'], $_SESSION['email']);
            $succcess_msg[] = "Password updated successfully.</a>";
            header('Location: login.php');
    
}
?>

<!-- HTML Code -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style type="text/css">
        <?php include 'style.css'; ?>
    </style>
</head>
<body>
    <div class="form-container">
        <section class="form-container">
            <div class="title">
                <h1>Forgot Password</h1>
                <p>Follow the steps to reset your password.</p>
            </div>

            <?php 
            if (!isset($_SESSION['otp_verified'])): 
            ?>
                <form action="" method="post">
                    <?php if (!$otp_sent): ?>
                        <!-- Step 1: Enter Email -->
                        <div class="input-field">
                            <p>Email</p>
                            <input type="email" name="email" placeholder="Enter your email" maxlength="50" required>
                        </div>
                        <input type="submit" name="send_otp" value="Send OTP" class="btn">
                    <?php else: ?>
                        <!-- Step 2: Verify OTP -->
                        <div class="input-field">
                            <p>Enter OTP</p>
                            <input type="number" name="otp" placeholder="Enter the OTP" maxlength="6" required>
                        </div>
                        <input type="submit" name="verify_otp" value="Verify OTP" class="btn">
                    <?php endif; ?>
                </form>
            <?php else: ?>
                <!-- Step 3: Reset Password -->
                <form action="" method="post">
                    <div class="input-field">
                        <p>New Password</p>
                        <input type="password" name="new_password" placeholder="Enter new password" maxlength="50" required>
                    </div>
                    <div class="input-field">
                        <p>Confirm Password</p>
                        <input type="password" name="confirm_password" placeholder="Confirm new password" maxlength="50" required>
                    </div>
                    <input type="submit" name="change_password" value="Change Password" class="btn">
                </form>
            <?php endif; ?>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalerts.min.js"></script>
    <script src = "script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>