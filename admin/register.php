<?php
session_start(); 
include '../components/connection.php'; // Corrected path for connection file

$warning_msg = []; // Initialize warning message array
$success_msg = []; // Initialize success message array

if (isset($_POST['register'])) 
{
    // Sanitize inputs
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

   // $pass = sha1($_POST['password']);
   $pass = $_POST['password'];
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    // $cpass = sha1($_POST['cpassword']);
    $cpass = $_POST['cpassword'];
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);


    // Check if user already exists
    $select_admin = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_admin->bind_param("s", $email); // Bind the email parameter
    $select_admin->execute();

    $result = $select_admin->get_result(); // Fetch the result set

    if ($result && $result->num_rows > 0) 
        $warning_msg[] = 'User email already exists';
    else 
    {
        if ($pass != $cpass) 
            $warning_msg[] = 'Confirm password not matched';
        else 
        {
            $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);
            try 
            {
                // Insert new user
                $insert_admin = $conn->prepare("INSERT INTO `users` (name, email, password, user_type) VALUES (?, ?, ?, ?)");
<<<<<<< HEAD
                $user_type = "Admin";
                $insert_admin->bind_param("ssss", $name, $email, $hashed_pass, $user_type);
=======
                $insert_admin->bind_param("ssss", $name, $email, $pass /*$hashed_pass*/, "Admin");
>>>>>>> 3ab7a8422473027efed904f1b42b1ac99df644b5
                $insert_admin->execute();

                // Get the last inserted ID
                $last_id = $conn->insert_id;

                // Handle image upload

                $image_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION); // Get the file extension
                $new_image_name = $last_id . '.' . $image_extension; // Rename image to last_id with the same extension
                $image_tmp_name = $_FILES['image']['tmp_name'];
                $image_folder = '../image/admin/' . $new_image_name;

                if (move_uploaded_file($image_tmp_name, $image_folder)) 
                    $success_msg[] = "Image uploaded successfully as $new_image_name.";
                else 
                    $warning_msg[] = "Failed to upload the image.";
            

<<<<<<< HEAD
            $success_msg[] = "New admin registered successfully. Admin ID: " . $last_id;
=======
                $success_msg[] = "New admin registered successfully. Admin ID: " . $last_id;
>>>>>>> 3ab7a8422473027efed904f1b42b1ac99df644b5

            } 
            catch (Exception $ex) 
            {
                $warning_msg[] = "Error: " . $ex->getMessage();
            }
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
    <div class="main_container">
        <section class="main">
            <div class="form-container" id="admin_login">
                <form action="#" method="post" enctype="multipart/form-data">
                    <h3>Register Now</h3>
                    <div class="input-field">
                        <label>Name: </label>
                        <input type="text" name="name" placeholder="Enter your name" required>
                    </div>
                    <div class="input-field">
                        <label>Email: </label>
                        <input type="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="input-field">
                        <label>Password: </label>
                        <input type="password" name="password" placeholder="Enter your password" required>
                    </div>
                    <div class="input-field">
                        <label>Confirm Password: </label>
                        <input type="password" name="cpassword" placeholder="Enter your confirm password" required>
                    </div>
                    <div class="input-field">
                        <label>Select Profile</label>
                        <input type="file" name="image" accept="image/*">
                    </div>
                    <button type="submit" name="register" class="btn">Register now</button>
                    <p>Already have an account? <a href="../login.php">Login now</a></p>
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
