<?php
include '../components/connection.php';
session_start();
$admin_id = $_SESSION['user_id'];

if (!isset($admin_id)) {
    header("location: ../login.php");
    exit;
}

// update product
if (isset($_POST['update'])) 
{
    $post_id = $_GET['id'];

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

    $update_product = $conn->prepare("UPDATE `products` SET name = ?, price = ?, size = ?, product_detail = ?, status = ? WHERE id=?");
    $update_product->execute([$name, $price, $size, $content, $status, $post_id]);

    $success_msg[] = 'Product updated';


    $old_image = $_POST['old_image'];
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $post_id = filter_var($_POST['product_id'], FILTER_SANITIZE_STRING);

    if (!empty($image)) 
    {
        // Extract the new image extension
        $image_extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));

        if (!in_array($image_extension, $allowed_extensions)) 
            $warning_msg[] = 'Invalid image format. Allowed formats: ' . implode(', ', $allowed_extensions);
        else if ($image_size > 200000) 
            $warning_msg[] = 'Image size is too large';
        else 
        {
            // Construct the new image file path
            $new_image_name = $post_id . '.' . $image_extension;
            $new_image_folder = '../image/product/' . $new_image_name;

            // Update the image in the database
            $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
            $update_image->bind_param("si", $new_image_name, $post_id);
            $update_image->execute();

            // Move the uploaded file to the correct directory
            move_uploaded_file($image_tmp_name, $new_image_folder);

            // Delete the old image if it exists and is different from the new one
            if ($old_image != $new_image_name && !empty($old_image)) 
            {
                foreach ($allowed_extensions as $ext) 
                {
                    $old_image_path = "../image/product/$post_id.$ext";
                    if (file_exists($old_image_path)) 
                    {
                        unlink($old_image_path);
                        break;
                    }
                }
            }

            $success_msg[] = 'Image updated';
        }
    }

    header("location:../admin/view_product.php");
}

// delete product
$p_id = $_POST['product_id'];
$p_id = filter_var($p_id, FILTER_SANITIZE_STRING);

// Define the directory and allowed image extensions
$imageDirectory = '../image/product/';
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

// Loop through possible extensions to find the image file
$imageDeleted = false;
foreach ($allowedExtensions as $extension) 
{
    $filePath = $imageDirectory . $p_id . '.' . $extension;
    if (file_exists($filePath)) 
    {
        unlink($filePath); // Delete the file
        $imageDeleted = true;
        break;
    }
}

// Delete the product from the database
$delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
$delete_product->bind_param("i", $p_id);
$delete_product->execute();

if ($delete_product->affected_rows > 0) 
    echo "Product deleted successfully.";
else 
    echo "Failed to delete product.";
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
    <?php include '../admin/components/admin_header.php'; ?>
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
            $post_id = $_GET['id'];

            $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
            $select_product->execute([$post_id]);

            if ($select_product->num_rows > 0) 
            {
                while ($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) 
                {
                    ?>
                    <div class="form-container">
                        <form action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="old_image" value="<?= $fetch_product['image']; ?>">
                            <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">
                            <div class="input-field">
                                <label>Update Status</label>
                                <select name="status">
                                    <option selected disabled value="<?= $fetch_product['status']; ?>">
                                        <?= $fetch_product['status']; ?>
                                    </option>
                                    <option value="active">Active</option>
                                    <option value="deactive">Deactive</option>
                                </select>
                            </div>
                            <div class="input-field">
                                <label>Product Name</label>
                                <input type="text" name="name" value="<?= $fetch_product['name']; ?>">
                            </div>
                            <div class="input-field">
                                <label>Product Price</label>
                                <input type="text" name="price" value="<?= $fetch_product['price']; ?>">
                            </div>
                            <div class="input-field">
                                <label>Product Description</label>
                                <textarea name="content"><?= $fetch_product['product_detail'] ?></textarea>
                            </div>
                            <div class="input-field">
                                <label>Product Image</label>
                                <input type="file" name="image" accept="image/*">
                                <img src="../image/<?= $fetch_product['image']; ?>">
                            </div>
                            <div class="flex-btn">
                                <button type="submit" name="update" class="btn">Update Product</button>
                                <a href="view_product.php" class="btn">Go Back</a>
                                <button type="submit" name="delete" class="btn">Delete Product</button>
                            </div>
                        </form>
                    </div>
                    <?php
                }
            } 
            else 
            {
                echo '<div class="empty">
                         <p>No product added yet. <br><a href="add_product.php" style="margin-top:1.5rem" class="btn">Add Product</a></p>
                      </div>';
            }
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