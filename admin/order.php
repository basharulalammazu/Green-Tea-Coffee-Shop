<?php
include '../components/connection.php';
session_start();
$admin_id = $_SESSION['user_id'];

if (!isset($admin_id)) {
    header("location:../login.php");
}
// deleted order
if(isset($_POST['delete_order'])){
    $order_id = $_POST['order_id'];
    $order_id = filter_var($order_id,FILTER_SANITIZE_STRING);

    $verify_order = $conn->prepare("SELECT * FROM `orders` WHERE id=?");
    $verify_order->execute([$order_id]);

    if($verify_order->rowCount()>0){
        $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id=?");
        $delete_order->execute([$order_id]);
        $success_msg[]='order deleted';
    }
    else{
        $warning_msg[]='order already deleted';
    }
}
// update order
if(isset($_POST['update_order'])){
    $order_id = $_POST['$order_id'];
    $order_id =filter_var($order_id,FILTER_SANITIZE_STRING);

    $update_payment = $_POST['update_payment'];
    $update_payment = filter_var($update_payment,FILTER_SANITIZE_STRING);

    $update_pay = $conn->prepare("UPDATE `orders` SET payment_status=? WHERE id=?");
    $update_pay->execute([$update_payment,$order_id]);

    $success_msg[]='order updated';
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
        <dib class="banner">
            <h1>order placed</h1>
        </dib>
        <div class="title2">
            <a href="dashboard.php">Dashboard</a><span> / Order Placed</span>
        </div>
        <section class="order">
            <h1 class="heading">Order Placed</h1>
            <div class="box-container">
                <?php
                $select_orders = $conn->prepare("SELECT * FROM `orders`");
                $select_orders->execute();

                if ($select_orders->num_rows > 0) {
                    while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <div class="box">
                            <div class="status" style="color:<?php if($fetch_orders['status']=='in progress'){echo 'green';}else{ echo 'red';}?>"><?= $fetch_orders['status'];?></div>
                            <div class="detail">
                                <p>user name: <span><?= $fetch_orders['name'];?></span></p>
                                <p>user id: <span><?= $fetch_orders['id'];?></span></p>
                                <p>placed no: <span><?= $fetch_orders['date'];?></span></p>
                                <p>user number: <span><?= $fetch_orders['number'];?></span></p>
                                <p>user emai;: <span><?= $fetch_orders['email'];?></span></p>
                                <p>totle price: <span><?= $fetch_orders['price'];?></span></p>
                                <p>method: <span><?= $fetch_orders['method'];?></span></p>
                                <p>user address: <span><?= $fetch_orders['address'];?></span></p>
                            </div>
                            <form method="post">
                                <input type="hidden" name="order_id" value="<?= $fetch_orders['id'];?>">
                                <select name="update_payment" >
                                    <option disabled selected><?= $fetch_orders['payment_status'];?></option>
                                    <option value="pending">pending</option>
                                    <option value="complete">complete</option>
                                </select>
                                <div class="flex-btn">
                                    <button type="submit" name="update_order" class="btn">update payment</button>
                                    <button type="submit" name="delete_order" class="btn">delete order</button>
                                    
                                </div>
                            </form>
                        </div>
                        <?php
                    }
                } else {
                    echo ' <div class="empty">
             <p>no order takes placed yet</p>
         </div>';
                }
                ?>

            </div>
        </section>
    </div>
    <!-- sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- custom js link -->
    <script src="script.js" type="text/javascript"></script>
    <!-- alert -->
    <?php include '../components/alert.php'; ?>

</body>

</html>