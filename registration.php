<?php
//include 'components/connection.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = "";
}

//register user
if (isset($_POST['submit'])) {
    $id = uniqid();
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = $_POST['pass'];
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = $_POST['pass'];
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
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
            <form action = "#" method = "post">
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
</body>
</html>