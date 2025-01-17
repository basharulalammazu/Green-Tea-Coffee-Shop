<?php
include '../components/connection.php';
include '../image_manager.php';
session_start();

$admin_id = $_SESSION['user_id'];

if (!isset($admin_id)) {
    header("location:../login.php");
    exit;
}

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
} else {
    header("location:../admin/view_product.php");
    exit;
}

if (isset($_POST['delete'])) {
    $product_id = $_POST['product_id'];
    delete_image($product_id, 'product');

    $delete_product_query = $conn->prepare("DELETE FROM `products` WHERE id = ?");
    $delete_product_query->bind_param("i", $product_id);
    $delete_product_query->execute();

    header("location:../admin/view_product.php");
    exit;
}

if (isset($_POST['edit'])) {
    header("location:../admin/edit_product.php?product_id=" . $_POST['product_id']);
    exit;
}

if (isset($_POST['back'])) {
    header("location:../admin/view_product.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="admin_style.css?v=<?php echo time(); ?>">
    <title>Green Coffee - View Product</title>
</head>
<body>
    <?php include '../admin/components/admin_header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Read Product</h1>
        </div>
        <div class="title2">
            <a href="../admin/dashboard.php">Dashboard</a><span> / Read Product</span>
        </div>
        <section class="read-post">
            <h1 class="heading">Read Product</h1>
            <?php
                $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                $select_product->bind_param("i", $product_id);
                $select_product->execute();
                $result = $select_product->get_result();

                if ($result->num_rows > 0) {
                    while ($fetch_product = $result->fetch_assoc()) {
                        $productId = $fetch_product['id'];
                        $imagePath = get_image_path($productId, 'product');
            ?>
                        <form action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">

                            <!-- Status and Price (Aligned on the same line) -->
                            <div class="status-and-price">
                                <div class="status" style="color: <?= ($fetch_product['status'] === 'active') ? 'green' : 'red'; ?>">
                                    <?= $fetch_product['status']; ?>
                                </div>
                                <div class="price">
                                    $<?= $fetch_product['price']; ?> /-
                                </div>
                            </div>

                            <!-- Image -->
                            <?php if (!empty($imagePath) && file_exists($imagePath)) { ?>
                                <img src="<?= $imagePath ?>" class="image" alt="Product Image">
                            <?php } else { ?>
                                <img src="../image/default_product.png" class="image" alt="Default Image">
                            <?php } ?>

                            <!-- Title -->
                            <div class="title"><?= $fetch_product['name']; ?></div>

                            <!-- Product Details -->
                            <div class="content"><?= $fetch_product['product_details']; ?></div>

                            <!-- Buttons -->
                            <div class="flex-btn">
                                <button type="submit" name="edit" class="btn">Edit</button>
                                <button type="submit" name="delete" class="btn" onclick="return confirm('Delete this product?');">Delete</button>
                                <button type="submit" name="back" class="btn">Go Back</button>
                            </div>
                        </form>
            <?php
                    }
                } else {
                    echo '<div class="empty">
                             <p>No product found. <br><a href="../admin/add_product.php" class="btn">Add Product</a></p>
                          </div>';
                }
            ?>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
