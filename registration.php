<?php
include 'components/connection.php';

session_start();

if (isset($_SESSION['user_id'])) 
    $user_id = $_SESSION['user_id'];
else 
    $user_id = '';

if (isset($_POST['submit'])) 
{
    // Sanitize and assign user inputs
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
    $cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_STRING);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
        $error_msg[] = 'Please enter a valid email address';
    

    // Check if email already exists
    $select_user = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $select_user->bind_param("s", $email); // Binding parameters in MySQLi
    $select_user->execute();
    $result = $select_user->get_result(); // Get the result from the executed query

    if ($result->num_rows > 0) 
        $error_msg[] = 'Email already exists';
    
    else 
    {
        // Check if passwords match
        if ($pass != $cpass) 
            $error_msg[] = 'Password doesnt match';
        
        else 
        {
            // Hash the password for security
<<<<<<< HEAD
           $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);

            // Create the user_type variable
            $user_type = "Customer"; 

            // Insert new user into the database
            $insert_user = $conn->prepare("INSERT INTO `users` (name, email, password, user_type) VALUES (?, ?, ?, ?)");
            $insert_user->bind_param("ssss", $name, $email, $hashed_pass, $user_type); // Binding parameters in MySQLi
=======
           // $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);

            
            // Insert new user into the database
            $insert_user = $conn->prepare("INSERT INTO `users` (name, email, password, user_type) VALUES (?, ?, ?, ?)");
            $insert_user->bind_param("ssss", $name, $email, $pass /*$hashed_pass*/, "Customer"); // Binding parameters in MySQLi
>>>>>>> 3ab7a8422473027efed904f1b42b1ac99df644b5
            $insert_user->execute();

            // Redirect after successful registration
            $succcess_msg[] = 'Registration successful! Please login.';
            header('location: login.php');
        }
    }
}
?>



<style type = "text/css">
    <?php include 'style.css';?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Tea - Register</title>
</head>
<body>
    <div class = "main-container">
        <section class = "form-container">
            <div class = "title">
                <img src = "assets/image/download.png">
                <h1>Register Now</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis quo voluptatum repellat 
                </p>
            </div>
            <form action = "" method = "post">
                <div class = "input-field">
                    <p>Your Name</p>
                    <input type = "text" name = "name" placeholder = "Enter your name" maxlength = "50" required>
                </div>
                <div class = "input-field">
                    <p>Email</p>
                    <input type = "text" name = "email" placeholder = "Enter your email" maxlength = "50" oninput = "this.value = this.value.replace(/\s/g,'')" required >
                </div>
                <div class = "input-field">
                    <p>Password</p>
                    <input type = "password" name = "pass" placeholder = "Enter the password" maxlength = "50" oninput = "this.value = this.value.replace(/\s/g,'')" required >
                </div>
                <div class = "input-field">
                    <p>Confirm Name</p>
                    <input type = "password" name = "cpass" placeholder = "Enter password again" maxlength = "50" required>
                </div>
                <input type = "submit" name = "submit" value = "registration" class = "btn">
                <p>Already have an account? <u><a href = "login.php">Login Now</a></u></p>
            </form>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalerts.min.js"></script>
    <script src = "script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>