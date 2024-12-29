<?php
include '../components/connection.php';
session_start();
$admin_id = $_SESSION['user_id'];

if (!isset($admin_id)) {
    header("location:../login.php");
}

// deleted order
if (isset($_POST['delete_order'])) {
    $order_id = $_POST['order_id'];
    $order_id = filter_var($order_id, FILTER_SANITIZE_STRING);

    // Using MySQLi to check if the order exists
    $verify_order = mysqli_prepare($conn, "SELECT * FROM `orders` WHERE id = ?");
    mysqli_stmt_bind_param($verify_order, 's', $order_id);
    mysqli_stmt_execute($verify_order);
    $result = mysqli_stmt_get_result($verify_order);
    $payment_status = "cancel";
    if (mysqli_num_rows($result) > 0) {
        // Using MySQLi to delete the order
        $delete_order = mysqli_prepare($conn, "UPDATE `orders` SET payment_status=? WHERE id=?");
        mysqli_stmt_bind_param($delete_order, 'ss', $payment_status, $order_id);
        mysqli_stmt_execute($delete_order);
        $success_msg[] = 'Order deleted';
    } 
    else 
        $warning_msg[] = 'Order already deleted';
    
}

// update order
if (isset($_POST['update_order'])) {
    $order_id = $_POST['order_id'];
    $order_id = filter_var($order_id, FILTER_SANITIZE_STRING);

    // Check if update_payment is set
    if (isset($_POST['update_payment'])) {
        $update_payment = $_POST['update_payment'];
        $update_payment = filter_var($update_payment, FILTER_SANITIZE_STRING);

        // Using MySQLi to update the payment status
        $update_pay = mysqli_prepare($conn, "UPDATE `orders` SET payment_status=? WHERE id=?");
        mysqli_stmt_bind_param($update_pay, 'ss', $update_payment, $order_id);
        mysqli_stmt_execute($update_pay);

        $success_msg[] = 'Order updated';
    } 
    else 
        $error_msg[] = 'Payment status not selected';

    // Check if update_status is set
    if (isset($_POST['update_status'])) {
        $update_status = $_POST['update_status'];
        $update_status = filter_var($update_status, FILTER_SANITIZE_STRING);

        // Using MySQLi to update the order status
        $update_order = mysqli_prepare($conn, "UPDATE `orders` SET status=? WHERE id=?");
        mysqli_stmt_bind_param($update_order, 'ss', $update_status, $order_id);
        mysqli_stmt_execute($update_order);

        $success_msg[] = 'Order updated';
    } 
    else 
        $error_msg[] = 'Order status not selected';
    
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="admin_style.css?v=<?php echo time(); ?>">
    <title>Green Coffee - Order Placed Page</title>
</head>

<body>
    <?php include '../admin/components/admin_header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Order Placed</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">Dashboard</a><span> / Order Placed</span>
        </div>
        <section class="order">
            <h1 class="heading">Order Placed</h1>
            <div class="box-container">
                <?php
                // Using MySQLi to select orders
                $select_orders = mysqli_query($conn, "SELECT * FROM `orders`");

                if (mysqli_num_rows($select_orders) > 0) {
                    while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
                        ?>
                        <div class="box">
                            <div class="status" style="color:<?php if ($fetch_orders['status'] == 'in progress') {
                                                                    echo 'green';
                                                                } else {
                                                                    echo 'red';
                                                                } ?>"><?= $fetch_orders['status']; ?></div>
                            <div class="detail">
                                <p>User name: <span><?= $fetch_orders['name']; ?></span></p>
                                <p>User id: <span><?= $fetch_orders['id']; ?></span></p>
                                <p>Placed no: <span><?= $fetch_orders['date']; ?></span></p>
                                <p>User number: <span><?= $fetch_orders['phone_number']; ?></span></p>
                                <p>User email: <span><?= $fetch_orders['email']; ?></span></p>
                                <p>Total price: <span><?= $fetch_orders['price']; ?></span></p>
                                <p>Method: <span><?= $fetch_orders['method']; ?></span></p>
                                <p>User address: <span><?= $fetch_orders['address']; ?></span></p>
                            </div>
                            <form method="post">
                                <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                                <!-- Status Select Dropdown -->
                                <select name="update_status">
                                    <option disabled selected>Select Status</option>
                                    <option value="pending" <?= $fetch_orders['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="in progress" <?= $fetch_orders['status'] === 'in progress' ? 'selected' : ''; ?>>In Progress</option>
                                    <option value="complete" <?= $fetch_orders['status'] === 'complete' ? 'selected' : ''; ?>>Complete</option>
                                    <option value="cancel" <?= $fetch_orders['status'] === 'cancel' ? 'selected' : ''; ?>>Cancel</option>
                                </select>

                                <!-- Payment Status Select Dropdown -->
                                <select name="update_payment">
                                    <option disabled selected>Select Payment Status</option>
                                    <option value="pending" <?= $fetch_orders['payment_status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="complete" <?= $fetch_orders['payment_status'] === 'complete' ? 'selected' : ''; ?>>Complete</option>
                                </select>

                                <div class="flex-btn">
                                    <button type="submit" name="update_order" class="btn">Update Order</button>
                                    <button type="submit" name="delete_order" class="btn">Cancel Order</button>
                                </div>
                            </form>
                        </div>
                        <?php
                    }
                } else {
                    echo ' <div class="empty">
             <p>No order has been placed yet</p>
         </div>';
                }
                ?>

            </div>
        </section>
    </div>
    <!-- SweetAlert CDN link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- Custom JS link -->
    <script src="script.js" type="text/javascript"></script>
    <!-- Alert -->
    <?php include '../components/alert.php'; ?>

</body>

</html>
