<?php
include 'components/connection.php';
session_start();

// Initialize variables
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$message = [];

if (isset($_POST['login'])) {
    // Retrieve and sanitize input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);

    // Check if email exists in the database
    $sql = "SELECT * FROM `users` WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    // Check if user exists
    if ($count > 0) 
    {
        // Encrypt the password and compare with the database
        if (password_verify($pass, $row['password'])) 
        {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];

            // Redirect based on User Type
            if (trim($row['user_type']) == "Admin") 
            {
                $success_msg[] = 'Admin login successful';
                header('Location: admin/dashboard.php');
                exit();
            } 
            else if (trim($row['user_type']) == "Customer") 
            {
                $success_msg[] = 'Customer login successful';
                header('Location: home.php');
                exit();
            } 
            else 
                $error_msg[] = 'Invalid user type. Please contact support';
        } 
        else 
            // No matching password found
            $error_msg[] = 'Invalid email or password. Please try again';
    }
    else 
        // No user found with that email
        $error_msg[] = 'No user found with that email. Please register';
        
}
?>

<!-- HTML Code -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Tea - Login</title>
    <style type="text/css">
        <?php include 'style.css'; ?>
    </style>
</head>
<body>
    <div class="form-container">
        <section class="form-container">
            <div class="title">
                <img src="assets/image/download.png" alt="Logo">
                <h1>Login Now</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis quo voluptatum repellat.</p>
            </div>
            <form action = "" method = "post">
                <div class="input-field">
                    <p>Email</p>
                    <input type = "text" name = "email" placeholder = "Enter your email" maxlength = "50" required>
                </div>
                <div class="input-field">
                    <p>Password</p>
                    <input type = "password" name = "pass" placeholder ="Enter the password" maxlength = "50" required>
                    <a href="forgot_password.php" style="font-size: 0.715em;">Forgot Password?</a>
                </div>
                <input type = "submit" name = "login" value = "Login" class="btn">
                
                <p>Don't have an account? <u><a href="registration.php">Register Now</a></u></p>
                
            </form>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalerts.min.js"></script>
    <script src = "script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>
