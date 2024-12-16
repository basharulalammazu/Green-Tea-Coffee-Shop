<?php
/*
session_start(); 
include './components/connection.php';

if (isset($_POST['register'])) 
{

    $id = unique_id();

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    $pass = sha1($_POST['password']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $cpass = sha1($_POST['cpassword']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../image/' . $image;

    $select_admin = $conn->prepare("SELECT * FROM `Admin` WHERE Email =?");
    $select_admin->execute([$email]);

    if ($select_admin->rowCount() > 0) 
        $warning_msg[]= 'User email already exists';
    else 
    {
        if ($pass != $cpass) 
            $warning_msg[] = 'Confirm password not matched';
        else 
        {
            $insert_admin = $conn->prepare("INSERT INTO `admin` (ID, Name, Email, Password, Profile) VALUES (?,?,?,?,?)");
            $insert_admin->execute([$id, $name, $email, $pass, $image]);
            move_uploaded_file($image_tmp_name, $image_folder);
            $success_msg[] = 'New admin registered';
        }
    }
}
*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="admin_styles.css?v=<?php echo time(); ?>">
    <title>Green Coffee Admin - Register Page</title>
</head>
<body>
    <div class = "main-container">
        <section class = "main">
            <div class = "form-container" id = "admin_login">
                <form action = "#" method = "post" enctype = "multipart/form-data">
                    <h3>Register Now</h3>
                    <div class = "input-field">
                        <label>Name: </label>
                        <input type = "text" name = "name" placeholder="Enter your name" required>
                    </div>
                    <div class="input-field">
                        <label>Email: </label>
                        <input type="email" name="email"  placeholder="Enter your email" required>
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
                    <p>Already have an account?<a href="../login.php">Login now</a></p>
                </form>
            </div>
        </section>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js" type="text/javascript"></script>
    <?php include '../components/alert.php';?>
</body>
</html>