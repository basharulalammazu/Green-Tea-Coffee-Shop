<?php
include 'components/connection.php';

session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
}

// Insert message into the database
if (isset($_POST['submit-btn'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $number = $conn->real_escape_string($_POST['number']);
    $message = $conn->real_escape_string($_POST['message']);

    if (!empty($name) && !empty($email) && !empty($message)) {
        $insert_message = $conn->prepare("INSERT INTO `message` (`user_id`, `name`, `email`, `phone_number`, `message`) VALUES (?, ?, ?, ?, ?)");
        $insert_message->bind_param("sssss", $user_id, $name, $email, $number, $message);

        if ($insert_message->execute()) {
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Message Sent!',
                        text: 'Thank you for your message. We will get back to you shortly.',
                        showConfirmButton: true
                    });
                  </script>";
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed to Send Message',
                        text: 'An error occurred while sending your message. Please try again later.',
                        showConfirmButton: true
                    });
                  </script>";
        }
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'warning',
                    title: 'All Fields are Required',
                    text: 'Please fill in all the required fields before submitting the form.',
                    showConfirmButton: true
                });
              </script>";
    }
}
?>

<style type="text/css">
    <?php include 'style.css'; ?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Green Coffee - Contact Page</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Contact Us</h1>
        </div>
        <div class="title2">
            <a href="home.php">home</a><span> / Contact Us</span>
        </div>
    </div>
    <section class="services">
        <div class="box-container">
            <div class="box">
                <img src="assets/icon/icon2.png">
                <div class="detail">
                    <h3>Great Savings</h3>
                    <p>Save Big by Every Order</p>
                </div>
            </div>
            <div class="box">
                <img src="assets/icon/icon1.png">
                <div class="detail">
                    <h3>24*7 Support</h3>
                    <p>One-On-One Support</p>
                </div>
            </div>
            <div class="box">
                <img src="assets/icon/icon0.png">
                <div class="detail">
                    <h3>Gift Voucher</h3>
                    <p>Voucher on every festivals</p>
                </div>
            </div>
            <div class="box">
                <img src="assets/icon/icon.png">
                <div class="detail">
                    <h3>Worldwide Delivery</h3>
                    <p>Dropship Worldwide</p>
                </div>
            </div>
        </div>
    </section>
    <div class="form-container">
        <form method="post">
            <div class="title">
                <img src="assets/image/download.png" class="logo">
                <h1>Leave a message</h1>
            </div>
            <div class="input-field">
                <p>Your Name</p>
                <input type="text" name="name" required>
            </div>
            <div class="input-field">
                <p>Email</p>
                <input type="email" name="email" required>
            </div>
            <div class="input-field">
                <p>Phone Number</p>
                <input type="text" name="number">
            </div>
            <div class="input-field">
                <p>Message</p>
                <textarea name="message" required></textarea>
            </div>
            <button type="submit" name="submit-btn" class="btn">Send a message</button>
        </form>
    </div>
    <div class="address">
        <div class="title">
            <img src="assets/image/download.png" class="logo">
            <h1>Contact Details</h1>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. </p>
        </div>
        <div class="box-container">
            <div class="box">
                <i class="bx bxs-map-pin"></i>
                <div>
                    <h4>Address</h4>
                    <p>408/1 (Old KA 66/1), Kuratoli, Khilkhet, Dhaka 1229, Bangladesh</p>
                </div>
            </div>
            <div class="box">
                <i class="bx bxs-phone-call"></i>
                <div>
                    <h4>Phone Number</h4>
                    <p> +88 02 841 4046-9</p>
                </div>
            </div>
            <div class="box">
                <i class="bx bxs-envelope"></i>
                <div>
                    <h4>Email</h4>
                    <p>info@aiub.edu</p>
                </div>
            </div>
        </div>
    </div>

    <?php include 'components/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>
