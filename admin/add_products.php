<?php
include '../components/connection.php';
session_start();
if ($_SESSION['user_type'] !== 'Admin') 
        header('Location: ../login.php');
    
$admin_id = $_SESSION['user_id'];

if (!isset($admin_id)) 
    header("Location: ../login.php");

$name = $product_category = $size = $price = $content = '';
$redirect_to_dashboard = false; // Initialize the flag

// Add product to database
if (isset($_POST['publish']) || isset($_POST['draft'])) 
{
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $product_category = $_POST['product_category'];
    $product_category = filter_var($product_category, FILTER_SANITIZE_STRING);

    $size = $_POST['size'];
    $size = filter_var($size, FILTER_SANITIZE_STRING);

    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);

    $content = $_POST['content'];
    $content = filter_var($content, FILTER_SANITIZE_STRING);

    // Status based on the button clicked
    $status = isset($_POST['publish']) ? 'active' : 'deactive';

    // Image handling
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../image/product/';

    // Validate the image
    if (!empty($image)) 
    {
        $extension = pathinfo($image, PATHINFO_EXTENSION);
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array(strtolower($extension), $allowed_extensions)) 
            $warning_msg[] = 'Invalid image format. Allowed formats: jpg, jpeg, png, gif.';
        else if ($image_size > 200000)
            $warning_msg[] = 'Image size is too large. Maximum allowed size is 200KB.';
        else 
        {
            // Insert product data into the database without the image first
            $insert_product = $conn->prepare("INSERT INTO `products` (name, product_category , size, price, product_details, status) VALUES (?, ?, ?, ?, ?, ?)");
            $insert_product->execute([$name, $product_category, $size, $price, $content, $status]);

            if ($insert_product) 
            {
                // Get the last inserted ID
                $product_id = $conn->insert_id;

                // Rename the image to id.extension
                $new_image_name = $product_id . '.' . $extension;
                $new_image_path = $image_folder . $new_image_name;

                // Move the uploaded image to the destination folder
                if (move_uploaded_file($image_tmp_name, $new_image_path)) 
                {
                    $succcess_msg[] = 'Product added successfully.';
                    $redirect_to_dashboard = true; // Set the flag for redirection
                } 
                else 
                    $warning_msg[] = 'Failed to upload the image.';
            }
        }
    } 
    else 
        $warning_msg[] = 'Please upload an image.';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="admin_style.css?v=<?php echo time(); ?>">
    <title>Green Coffee - Add Products page</title>
</head>
<body>
    <?php include '../admin/components/admin_header.php';?>
    <div class="main">
        <div class="title2">
            <a href="dashboard.php">Dashboard </a><span>/ Add Products</span>
        </div>
        <section class="form-container">
            <h1 style="text-align: center; margin-top: -25px;">Add products</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="input-field">
                    <label>Product Name: </label>
                    <input type="text" name="name" required placeholder="Add product name" value="<?php echo ($name); ?>">
                </div>
                <div class="input-field">
                    <label>Product Category: </label>
                    <select name="product_category" required>
                        <option disabled <?php echo empty($product_category) ? 'selected' : ''; ?>>Select Product Category</option>
                        <option value="Coffee" <?php echo ($product_category === 'Coffee') ? 'selected' : ''; ?>>Coffee</option>
                        <option value="Tea" <?php echo ($product_category === 'Tea') ? 'selected' : ''; ?>>Tea</option>
                        <option value="Drinks" <?php echo ($product_category === 'Drinks') ? 'selected' : ''; ?>>Drinks</option>
                        <option value="Matcha" <?php echo ($product_category === 'Matcha') ? 'selected' : ''; ?>>Matcha</option>
                        <option value="Others" <?php echo ($product_category === 'Others') ? 'selected' : ''; ?>>Others</option>
                    </select>
                </div>
                <div class="input-field">
                    <label>Product Size: </label>
                    <input type="text" name="size" required placeholder="Add product size" value="<?php echo ($size); ?>">
                </div>
                <div class="input-field">
                    <label>Product Price: </label>
                    <input type="number" name="price" required placeholder="Add product price" value="<?php echo ($price); ?>">
                </div>
                <div class="input-field">
                    <label>Product Details: </label>
                    <textarea name="content" placeholder="Write product description" required><?php echo ($content); ?></textarea>
                </div>
                <div class="input-field">
                    <label>Product Image: </label>
                    <input type="file" name="image" accept="image/" required>
                </div>
                <div class="flex-btn">
                    <button type="submit" name="publish" class="btn">Publish Product</button>
                    <button type="submit" name="draft" class="btn">Save as Draft</button>
                </div>
            </form>
        </section>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js" type="text/javascript"></script>
    <?php include '../components/alert.php'; ?>
</body>
</html>
