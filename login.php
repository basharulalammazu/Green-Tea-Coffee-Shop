<?php
include 'components/connection.php';
session_start();

// Initialize variables
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$message = [];

if (isset($_POST['submit'])) {
    // Retrieve and sanitize input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);

    // Prepare statement to check user in the database
    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_user->bind_param("s", $email); 
    $select_user->execute();

    
    $result = $select_user->get_result(); 
    $row = $result->fetch_assoc();

    $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);

    if ($pass == $row['password'])
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
            $error_msg[] = 'Invalid user type. Please contact support ';
        
    }
    
    
    /*
    // Encrypt the password and compare with the database

    $result = $select_user->get_result(); 
    if ($result && $result->num_rows > 0) 
    {
        $row = $result->fetch_assoc();

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
                $error_msg[] = 'Invalid user type. Please contact support.';
        } 
        else 
            $error_msg[] = 'Incorrect username or password 70 {Pass: ' .$pass. '}  {Pass: ' .password_hash($pass, PASSWORD_BCRYPT). '} {DB PASS: ' . $row['password'];
        
    } 
    else 
        // No user found with that email
        $error_msg[] = 'Incorrect username or password 74';
        */
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
                </div>
                <input type = "submit" name = "submit" value = "Login" class="btn">
                <p>Forgot password? <u><a href="forgot_password.php">Reset Now</a></u></p>
                <p>Don't have an account? <u><a href="registration.php">Register Now</a></u></p>
                
                <!-- Display messages -->
                <?php 
                    if (!empty($error_msg)) {
                        foreach ($error_msg as $msg)
                            echo "<div class='error'>$msg</div>";
                    }
                    if (!empty($success_msg)) {
                        foreach ($success_msg as $msg) 
                            echo "<div class='success'>$msg</div>";
                    }
                ?>
            </form>
        </section>
    </div>
    <?php include 'components/alert.php'; ?>
</body>
</html>
