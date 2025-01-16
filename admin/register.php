<?php
include '../components/connection.php'; // Corrected path for connection file
// require_once '../mail/email.php'; // Corrected path for email file
include '../image_manager.php';
include '../validitycheck.php';


session_start(); 

$warning_msg = []; // Initialize warning message array
$succcess_msg = []; // Initialize success message array

if (isset($_POST['register'])) 
{
    // Sanitize inputs
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $phone_number = $_POST['phone_number'];
    $phone_number = filter_var($phone_number, FILTER_SANITIZE_STRING);

    // Define characters for the password
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+';
    $pass = '';
    $maxIndex = strlen($characters) - 1;

    // Randomly select characters for the password
    for ($i = 0; $i < 12; $i++) 
        $pass .= $characters[random_int(0, $maxIndex)];

    // Check if user already exists
    $select_admin = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_admin->bind_param("s", $email); // Bind the email parameter
    $select_admin->execute();

    $result = $select_admin->get_result(); // Fetch the result set

    if ($result && $result->num_rows > 0) 
        $warning_msg[] = 'User email already exists';
    else 
        {
            $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);
            try 
            {
                // Insert new user
                $query = "INSERT INTO `users` (name, email, phone_number, password, user_type) VALUES ('$name', '$email', '$phone_number', '$hashed_pass', 'Admin')";
                if (mysqli_query($conn, $query))
                {
                    $last_id = mysqli_insert_id($conn);

                    if (upload_image($_FILES['image'], $last_id, 'admin')) 
                    {
                        $succcess_msg[] = "New admin registered successfully. Admin ID: " . $last_id;

                        $name="";
                        $email="";
                        $phone_number="";

                    /*    if (sendConfirmationEmailWithCredentials($email, $pass)) // Send email to admin with credentials
                            $success_msg[] = "Email sent to $email with login credentials.";
                        else 
                            $warning_msg[] = "Failed to send email."; */
                    }
                    else 
                        $warning_msg[] = "Failed to upload the image.";
            
                }
                else 
                    $warning_msg[] = "Failed to register new admin."; 
            } 
            catch (Exception $ex) 
            {
                $warning_msg[] = "Error: " . $ex->getMessage();
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="admin_style.css?v=<?php echo time(); ?>">
    <title>Green Coffee Admin - Register Page</title>
</head>
<body>
    <?php include 'components/admin_header.php'; ?>
    <div class="main-container">
        <section class="form-container" id="admin_login">
            <div class="title">
                <img src="../assets/image/download.png">
                <h1>Admin Registration</h1>
                <p style="text-align: center; font-size: 16px; font-family: Arial, sans-serif;">
                    Register a new user as Admin. 
                        <span style="color: red; font-weight: bold;">PS: ONLY REGISTER VALID EMAIL</span>
                </p>
            </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <h3>Register Now</h3>
                    <div class="input-field">
                        <label>Name: </label>
                        <input type="text" name="name" placeholder="Enter your name" value="<?php echo isset($name) ? ($name) : ''; ?>" required>
                    </div>
                    <div class="input-field">
                        <label>Email: </label>
                        <input type="email" name="email" placeholder="Enter your email" value="<?php echo isset($email) ? ($email) : ''; ?>" required>
                    </div>
                    <div class="input-field">
                        <label>Phone Number: </label>
                        <input type="number" name="phone_number" placeholder="Enter your phone number" value="<?php echo isset($phone_number) ? ($phone_number) : ''; ?>" required>
                    </div>
                    <div class="input-field">
                        <label>Select Profile</label>
                        <input type="file" name="image" accept="image/*" required>
                    </div>
                    <button type="submit" name="register" class="btn">Register now</button>
                    <button type="button" name="back" class="btn" onclick="window.location.href='dashboard.php';">Back</button>
                </form> 
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js" type="text/javascript"></script>

    <!-- Alert Messages -->
    <?php include '../components/alert.php'; ?>
</body>
</html>
