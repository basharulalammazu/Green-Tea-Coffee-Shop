<?php
include 'components/connection.php';
session_start();

// Check if the customer is logged in
if (!isset($_SESSION['user_id'])) 
{
    $warning_mes = 'Please login to view your profile';
    header('Location: login.php');
    exit();
}

$customer_id = $_SESSION['user_id'];
$message = [];

// Fetch customer data
$fetch_customer = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$fetch_customer->bind_param("i", $customer_id);
$fetch_customer->execute();
$result = $fetch_customer->get_result();
$customer_data = $result->fetch_assoc();

// Fetch orders
$fetch_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? ORDER BY date DESC");
$fetch_orders->bind_param("i", $customer_id);
$fetch_orders->execute();
$orders = $fetch_orders->get_result();

// Handle profile updates
if (isset($_POST['update_profile'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);

    $update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ?, phone_number = ? WHERE id = ?");
    $update_profile->bind_param("sssi", $name, $email, $phone, $customer_id);
    if ($update_profile->execute()) 
        $success_msg[] = "Profile updated successfully.";
    else 
        $error_msg[] = "Failed to update profile.";
    
}

// Handle password update
if (isset($_POST['update_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (password_verify($old_password, $customer_data['password'])) {
        if ($new_password === $confirm_password) {
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
            $update_password = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
            $update_password->bind_param("si", $hashed_password, $customer_id);
            $update_password->execute();
            $success_msg[] = "Password updated successfully.";
        } 
        else 
            $warning_msg[] = "New passwords do not match.";
        
    } 
    else 
        $warning_msg[] = "Incorrect old password.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Customer Profile</title>
    <script>
      
    </script>
    <script src="script.js"></script>

</head>
<body>
    <?php  include './components/header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Customer Profile</h1>
        </div>
        <section class="profile">
            <div class="profile-container">
                <div class="profile-card">
                    <!-- Display Mode -->
                    <div class="display-mode">
                        <p><strong>Name:</strong> <?php echo $customer_data['name']; ?></p>
                        <p><strong>Email:</strong> <?php echo $customer_data['email']; ?></p>
                        <p><strong>Phone:</strong> <?php echo $customer_data['phone_number']; ?></p>
                        <button onclick="toggleEditMode()" class="btn edit-btn">Edit Profile</button>

                        <h2 class="profile-heading " align = "center">Order History</h2>
                <?php if ($orders->num_rows > 0): ?>
                    <table class="order-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Product ID</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $orders->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['product_id']; ?></td>
                                    <td><?php echo $row['quantity']; ?></td>
                                    <td><?php echo $row['price']; ?></td>
                                    <td><?php echo $row['date']; ?></td>
                                    <td>
                                        <?php 
                                            if (empty($row['status']) || is_null($row['status'])) 
                                                echo "-";  
                                            else 
                                                echo $row['status'];
                                        ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="empty">You haven't ordered anything yet.</p>
                <?php endif; ?>

                    </div>
                </div>

            <!-- Edit Mode -->
            <div class="edit-mode hidden">
                <form action="" method="post" class="form">
                    <div class="input-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo $customer_data['name']; ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo $customer_data['email']; ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="phone">Phone:</label>
                        <input type="text" id="phone" name="phone" value="<?php echo $customer_data['phone_number']; ?>" required>
                    </div>
                    <div class="form-actions">
                        <button type="submit" name="update_profile" class="btn save-btn">Save Changes</button>
                        <button type="button" onclick="toggleEditMode()" class="btn cancel-btn">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php foreach ($message as $msg): ?>
        <div class="message"> <?php echo $msg; ?> </div>
    <?php endforeach; ?>
</section>

    </div>
</body>
</html>
