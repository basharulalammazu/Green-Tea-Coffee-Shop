<?php
include '../components/connection.php';
session_start();
$admin_id = $_SESSION['user_id'];

if (!isset($admin_id)) {
    header("location: ../login.php");
    exit;
}
if (!isset($_GET['product_id'])) {
    echo "<script>alert('Invalid Request: Product ID not found.'); window.location.href = 'view_product.php';</script>";
    exit;
}



// update product
if (isset($_POST['update'])) 
{
    $post_id = $_GET['product_id'];

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);

    $size = $_POST['size'];
    $size = filter_var($size, FILTER_SANITIZE_STRING);

    $content = $_POST['content'];
    $content = filter_var($content, FILTER_SANITIZE_STRING);

    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $status = filter_var($status, FILTER_SANITIZE_STRING);

    $update_product = $conn->prepare("UPDATE products SET name = ?, price = ?, size = ?, product_details = ?, status = ? WHERE id=?");
    $update_product->execute([$name, $price, $size, $content, $status, $post_id]);

    $success_msg[] = 'Product updated';

    if (!empty($image)) 
    {

            $product_id = $_POST['product_id'];
            $product_id = filter_var($product_id, FILTER_SANITIZE_STRING);
        
            $uploadResult = update_image($_FILES['image'], $product_id, 'product');
            if ($uploadResul === false) 
                $success_msg[] = "Image uploaded successfully: ";
            else 
                $warning_msg[] = $uploadResult; // Display error message
        
    }

    header("location:../admin/view_product.php");
}


// Delete the product from the database
if (isset($_POST['delete'])) 
{
    
    // delete product
    $p_id = $_GET['product_id'];
    $p_id = filter_var($p_id, FILTER_SANITIZE_STRING);

    // Define the directory and allowed image extensions
    $imageDirectory = '../image/product/';
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    // Loop through possible extensions to find the image file
    $imageDeleted = delete_image($p_id, 'product');

    $delete_product = $conn->prepare("DELETE FROM products WHERE id = ?");
    $delete_product->execute([$p_id]);

    if ($delete_product->affected_rows > 0) 
        $success_msg[] = 'Product deleted successfully.';
    else 
        $warning_msg[] = 'Failed to delete product.';
}
?>

<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="admin_style.css?v=<?php echo time(); ?>">
    <title>Green Coffee Admin - Edit Product Page</title>
</head>

<body>
    <?php 
        include '../admin/components/admin_header.php'; 
        include '../image_manager.php';
    ?>
    
    <div class="main">
        <div class="banner">
            <h1>Edit Product</h1>
        </div>
        <div class="title2">
            <a href="../admin/dashboard.php">Dashboard</a><span> / Edit Product</span>
        </div>
        <section class="edit-post">
            <h1 class="heading">Edit Product</h1>
            <?php
            // Get the product_id from the URL using GET method
            $post_id = $_GET['product_id'];

            // Prepare the SQL statement to fetch the product details
            $select_product = $conn->prepare("SELECT * FROM products WHERE id = ?");
            $select_product->bind_param("i", $post_id); // Bind the product_id as an integer

            // Execute the query
            $select_product->execute();
            $result = $select_product->get_result(); // Get the result

            // Check if the product is found
            if ($result->num_rows > 0) 
            {
                // Fetch the product details
                while ($fetch_product = $result->fetch_assoc()) 
                {
                    ?>
                    <div class="form-container">
                        <form action="" method="post" enctype="multipart/form-data">
                            <!-- Hidden fields for the old image and product id -->
                            <input type="hidden" name="old_image" value="<?= get_image_path($fetch_product['id'], 'product') ; ?>">
                            <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">

                            <!-- Status field -->
                            <div class="input-field">
                                <label>Update Status</label>
                                <select name="status">
                                    <option value="active" <?= ($fetch_product['status'] === 'active') ? 'selected' : ''; ?>>
                                        active
                                    </option>
                                    <option value="deactive" <?= ($fetch_product['status'] === 'deactive') ? 'selected' : ''; ?>>
                                        deactive
                                    </option>
                                </select>
                            </div>

                            <!-- Product Name field -->
                            <div class="input-field">
                                <label>Product Name</label>
                                <input type="text" name="name" value="<?= $fetch_product['name']; ?>">
                            </div>

                            <!-- Product size field -->
                            <div class="input-field">
                                <label>Product Price</label>
                                <input type="text" name="size" value="<?= $fetch_product['size']; ?>">
                            </div>

                            <!-- Product Price field -->
                            <div class="input-field">
                                <label>Product Price</label>
                                <input type="text" name="price" value="<?= $fetch_product['price']; ?>">
                            </div>

                            <!-- Product Description field -->
                            <div class="input-field">
                                <label>Product Description</label>
                                <textarea name="content"><?= $fetch_product['product_details']; ?></textarea>
                            </div>

                            <!-- Product Image field -->
                            <div class="input-field">
                                <label>Product Image</label>
                                <div class="image-upload-container">
                                    <img src="<?= get_image_path($fetch_product['id'], 'product'); ?>" alt="Product Image" id="product_image">
                                </div>
                                <input type="file" name="image" id="input_image" accept="image/jpeg, image/png, image/jpg" onchange="productImageUpdate(event)">
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex-btn">
                                <button type="submit" name="update" class="btn">Update Product</button>
                                <a href="view_product.php" class="btn">Go Back</a>
                                <button type="submit" name="delete" class="btn">Delete Product</button>
                            </div>
                        </form>
                    </div>
                    <?php
                }
            } else {
                // If no product is found with the provided id
                echo '<div class="empty">
                        <p>No product found. <br><a href="add_products.php" style="margin-top:1.5rem" class="btn">Add Product</a></p>
                    </div>';
            }

            // Close the prepared statement
            $select_product->close();
            ?>
        </section>
    </div>
    <!-- Sweetalert CDN link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- Custom JS link -->
    <script src="script.js" type="text/javascript"></script>
      <!-- alert -->
      <?php include '../components/alert.php';?>
</body>
</html>