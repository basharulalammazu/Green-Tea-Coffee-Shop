<?php
//include 'components/connection.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

//register user
if (isset($_POST['submit'])) {
    
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = $_POST['pass'];
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   

    $select_user = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $select_user->execute([$email, $pass]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if ($select_user->rowCount() > 0) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['user_email'] = $row['email'];
        header('location: home.php');
    } else {
        $message[] = 'Incorrect username or password';
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
    <title>Green Tea - Login</title>
</head>
<body>
    <div class = "form-container">
        <section class = "form-container">
            <div class = "title">
                <img src = "assets/image/download.png">
                <h1>Login Now</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis quo voluptatum repellat 
                </p>
            </div>
            <form action = "#" method = "post">
                <div class = "input-field">
                    <p>Email</p>
                    <input type = "text" name = "email" placeholder = "Enter your email" maxlength = "50" oninput = "this.value = this.value.replace(/\s/g,'')" required >
                </div>
                <div class = "input-field">
                    <p>Password</p>
                    <input type = "password" name = "pass" placeholder = "Enter the password" maxlength = "50" oninput = "this.value = this.value.replace(/\s/g,'')" required >
                </div>
                <input type = "submit" name = "submit" value = "Login" class = "btn">
                <p>Don't have an account? <u><a href = "registration.php">Register Now</a></u></p>
            </form>
        </section>
    </div>
</body>
</html>