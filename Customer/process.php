<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/SignUp</title>
    <!--Boxicons CDN-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!--Custom CSS-->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="popup" class="popup hidden">
        <div class="popup-content">
            <p id="popup-message"></p>
            <button onclick="hidePopup()">OK</button>
        </div>
    </div>
    <?php
    session_start();

    function setSession($email, $pass)
    {
        if (!isset($_SESSION[$email])) 
            $_SESSION[$email] = $pass; // Fixed the semicolon
        
    }

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if (isset($_REQUEST['submit']) && $_REQUEST['submit'] === "signIn") 
            CustomerSignIn();
        elseif (isset($_REQUEST['submit']) && $_REQUEST['submit'] === "signUp") 
            CustomerSignUp();
        
    }

    function CustomerSignIn()
    {
        $email = $_REQUEST["email"];
        $pass = $_REQUEST["pass"];

        if (empty($email) || empty($pass)) {
            echo "<script>showPopup('Please fill out all fields!');</script>";
            return;
        }

        // Authentication logic here
        // Example: Invalid credentials
        echo "<script>showPopup('Invalid email or password!');</script>";
    }

    function CustomerSignUp()
    {
        $name = $_REQUEST["name"];
        $email = $_REQUEST["email"];
        $pass = $_REQUEST["pass"];
        $cPass = $_REQUEST["cPass"];

        if (empty($name) || empty($email) || empty($pass) || empty($cPass)) {
            echo "<script>showPopup('Please fill out all fields!');</script>";
            return;
        }

        if ($pass !== $cPass) {
            echo "<script>showPopup('Passwords do not match!');</script>";
            return;
        }

        // Registration successful
        echo "<script>showPopup('Registration successful!');</script>";
    }
    ?>
    <script src="script.js"></script>
</body>
</html>
