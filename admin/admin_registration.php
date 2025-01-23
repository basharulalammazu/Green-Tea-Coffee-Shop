<?php
include '../components/connection.php';
include '../validitycheck.php';

session_start();
if ($_SESSION['user_type'] !== 'Admin') 
    header('Location: ../login.php');

if (isset($_SESSION['user_id'])) 
    $user_id = $_SESSION['user_id'];
else 
    $user_id = '';

if (isset($_POST['submit'])) 
{
    // Sanitize and assign user inputs
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phoneNumber = filter_var($_POST['phone_number'], FILTER_SANITIZE_STRING);
    $pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
    $cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_STRING);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
        $error_msg[] = 'Please enter a valid email address';

    // Check if email already exists
    $select_user = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $select_user->bind_param("s", $email); // Binding parameters in MySQLi
    $select_user->execute();
    $result = $select_user->get_result();

    if ($result->num_rows > 0) 
        $error_msg[] = 'Email already exists';
    else 
    {
        // Check if passwords match
        if ($pass != $cpass) 
            $error_msg[] = 'Password doesn\'t match';
        else 
        {
            $strongPass = isStrongPassword($pass); // Check if the password is strong

            if ($strongPass === true)
            {
                // Hash the password for security
                $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);

                $query = "INSERT INTO users (name, phone_number, email, password, user_type) VALUES (?, ?, ?, ?, 'Admin')";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ssss", $name, $phoneNumber, $email, $hashed_pass);

                if($stmt->execute())
                {
                    $success_msg[] = 'Admin registration successful! Please login.';
                    header('location: ../login.php');
                }
                else
                    $error_msg[] = 'Error: ' . $conn->error;
            }
            else 
            {
                if (is_array($strongPass))
                {
                    foreach ($strongPass as $msg) 
                        $error_msg[] = $msg;
                }
                else 
                    $error_msg[] = $strongPass;
            }
        }
    }
}
?>

<style type="text/css">
    <?php include 'admin_style.css';?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Tea - Admin Register</title>
</head>
<body>
    <div class="main-container">
        <section class="form-container">
            <div class="title">
                <img src="../assets/image/download.png">
                <h1>Admin Registration</h1>
                <p style="text-align: center; font-size: 16px; font-family: Arial, sans-serif;">
                    Register a new user as Admin. 
                        <span style="color: red; font-weight: bold;">PS: ONLY REGISTER VALID EMAIL</span>
                </p>
            </div>
            <form action="" method="post">
                <div class="input-field">
                    <p>Admin Name</p>
                    <input type="text" name="name" placeholder="Enter admin name" maxlength="50" required value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">
                </div>
                <div class="input-field">
                    <p>Phone Number</p>
                    <input type="text" name="phone_number" placeholder="Enter your phone number" maxlength="14" required value="<?php echo isset($phoneNumber) ? htmlspecialchars($phoneNumber) : ''; ?>">
                </div>
                <div class="input-field">
                    <p>Admin Email</p>
                    <input type="text" name="email" placeholder="Enter your email" maxlength="50" oninput="this.value = this.value.replace(/\s/g,'')" required value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                </div>
                <div class="input-field">
                    <p>Password</p>
                    <input type="password" name="pass" placeholder="Enter the password" maxlength="50" oninput="this.value = this.value.replace(/\s/g,'')" required>
                </div>
                <div class="input-field">
                    <p>Confirm Password</p>
                    <input type="password" name="cpass" placeholder="Enter password again" maxlength="50" required>
                </div>
                <input type="submit" name="submit" value="Register as Admin" class="btn">
                <p>Already have an account? <u><a href="../login.php">Login Now</a></u></p>
            </form>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalerts.min.js"></script>
    <script src="script.js"></script>
    <?php include '../components/alert.php'; ?>
</body>
</html>
