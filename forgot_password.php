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
    $check_email = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND user_type = 'Customer'");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $result = $check_email->get_result();

    if ($result && $result->num_rows > 0) 
    {
        // Generate a 6-digit OTP
        $otp = rand(100000, 999999);
        
        // Save OTP in session for verification
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;

        // Simulate sending OTP (In real application, use mail or SMS API)
        //$message[] = "OTP sent to your email: $otp (Mocked for demo).";
        if (sendOTP($email, $otp)) 
        {
            $otp_sent = true;
            $success_msg[] = "OTP sent to your email: $email. Check your email and verify the OTP.";
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

if (isset($_POST['change_password'])) {
    // Retrieve and sanitize inputs
    $new_password = filter_var($_POST['new_password'], FILTER_SANITIZE_STRING);
    $confirm_password = filter_var($_POST['confirm_password'], FILTER_SANITIZE_STRING);

    if ($new_password === $confirm_password) 
    {
        $md5 = md5($new_password); 
        // Update the password in the database
        $update_password = $conn->prepare("UPDATE `users` SET password = ? WHERE email = ?");
        $update_password->bind_param("ss", $md5, $_SESSION['email']);
        $update_password->execute();

        // Clear session variables and redirect
        unset($_SESSION['otp'], $_SESSION['otp_verified'], $_SESSION['email']);
        $success_msg[] = "Password updated successfully. <a href='login.php'>Login now</a>";
    } 
    else 
        $warning_msg[] = "Passwords do not match. Please try again.";
    
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

            <!-- Display Messages -->
            <?php foreach ($message as $msg): ?>
                <div class="message"><?= $msg; ?></div>
            <?php endforeach; ?>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalerts.min.js"></script>
    <script src = "script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>
