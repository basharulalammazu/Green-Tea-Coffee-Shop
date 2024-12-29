<?php
    include '../components/connection.php';
    session_start();
    $admin_id = $_SESSION['user_id'];

    if (!isset($admin_id)) 
        header("location:../login.php");

    // delete product
    if(isset($_POST['delete']))
    {
        $product_id = $_POST['product_id'];
        $product_id = filter_var($product_id, FILTER_SANITIZE_STRING);

        $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
        $delete_product->execute([$product_id]);

        $success_msg[] = 'Product Deleted Successfully';
    }


    if(isset($_POST['edit']))
        header("location:edit_product.php?product_id=".$_POST['product_id']);


    if(isset($_POST['view']))
        header("location:read_product.php?product_id=".$_POST['product_id']);
?>
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="admin_style.css?v=<?php echo time(); ?>">
    <title>Green Coffee Admin - View Product Page</title>
</head>

<body>
    <?php 
        include '../admin/components/admin_header.php'; 
        include '../image_manager.php';
    ?>
    <div class="main">
        <div class="title2">
            <a href="../admin/dashboard.php">Dashboard</a><span> / All Products</span>
        </div>
        <section class="show-post">
            <h1 class="heading">All Products</h1>
            <div class="box-container">
                <?php
                // Fetch all products from the database
                $select_products = $conn->prepare("SELECT * FROM `products`");
                $select_products->execute();
                $result = $select_products->get_result();

                if ($result->num_rows > 0) 
                {
                    while ($fetch_products = $result->fetch_assoc()) 
                    {
                        $productId = $fetch_products['id'];
                        $imagePath = get_image_path($productId, 'product');
                ?>
                        <form action="" method="post" class="box" enctype="multipart/form-data">
                            <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
                            <img src="<?= $imagePath; ?>" class="image" alt="Product Image">

                            <div class="status" style="color: <?= ($fetch_products['status'] === 'active') ? 'green' : 'red'; ?>">
                                <?= $fetch_products['status']; ?>
                            </div>
                            <div class="price">$<?= $fetch_products['price']; ?>/-</div>
                            <div class="title"><?= $fetch_products['name']; ?></div>
                            <div class="flex-btn">
                                <!-- Pass product_id through the URL using a GET parameter -->
                                <button type="submit" name="edit" class="btn">Edit</button>
                                <button type="submit" name="delete" class="btn" onclick="return confirm('Delete this product?');">Delete</button>
                                <button type="submit" name="view" class="btn">View</button>
                            </div>
                        </form>
                <?php
                    }
                } 
                else 
                {
                    echo '<div class="empty">
                            <p>No product added yet <br> 
                            <a href="../admin/add_product.php" style="margin-top:1.5rem" class="btn">Add Product</a></p>
                        </div>';
                }

                // Handle delete request
                if (isset($_POST['delete'])) 
                {
                    $product_id = $_POST['product_id'];
                    ?>
                    <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
                    <?php
                    // Delete the product record
                    $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
                    $delete_product->bind_param("i", $product_id);

                    if ($delete_product->execute()) {
                        echo "<script>
                                alert('Product deleted successfully!');
                                window.location.href = window.location.href; // Refresh the page
                            </script>";
                    } 
                    else 
                        echo "<script>alert('Failed to delete the product. Please try again!');</script>";
                }
                ?>
            </div>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js" type="text/javascript"></script>
    <?php include '../components/alert.php';?>
</body>
</html>