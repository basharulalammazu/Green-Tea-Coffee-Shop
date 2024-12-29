<?php
include '../components/connection.php';
session_start();
$admin_id = $_SESSION['user_id'];

if (!isset($admin_id)) 
    header("Location: ../login.php");


// Add product to database
if (isset($_POST['publish']) || isset($_POST['draft'])) 
{
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

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
            $insert_product = $conn->prepare("INSERT INTO `products` (name, size, price, product_details, status) VALUES (?, ?, ?, ?, ?)");
            $insert_product->execute([$name, $size, $price, $content, $status]);

            if ($insert_product) 
            {
                // Get the last inserted ID
                $product_id = mysqli_insert_id($conn);

                // Rename the image to id.extension
                $new_image_name = $product_id . '.' . $extension;
                $new_image_path = $image_folder . $new_image_name;

                // Move the uploaded image to the destination folder
                if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
                    $image_name = $_FILES['image']['name'];
                    $image_tmp_name = $_FILES['image']['tmp_name'];

                    // Get the file extension
                    $image_extension = pathinfo($image_name, PATHINFO_EXTENSION);
                    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

                    // Validate file extension
                    if (in_array(strtolower($image_extension), $allowed_extensions)) {
                        // Define the product directory
                        $product_directory = "../image/product/";
                        $new_image_name = $product_id . '.' . $image_extension;
                        $new_image_path = $product_directory . $new_image_name;

                        // Ensure the product directory exists
                        if (!is_dir($product_directory)) 
                            mkdir($product_directory, 0777, true); // Create the directory if it doesn't exist
                        

                        // Move the uploaded file
                        if (move_uploaded_file($image_tmp_name, $new_image_path)) 
                            $success_msg[] = 'Product added successfully.';                           
                        else
                            $warning_msg[] = 'Failed to upload the image.';
                        
                    } else 
                        $warning_msg[] = 'Invalid image format. Only JPG, JPEG, PNG, and GIF are allowed.';
                    
                } 
                else 
                    $warning_msg[] = 'No image uploaded.';
                

                
                
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
                <label>product name: </label>
                <input type="text" name="name" required placeholder="add product name">
            </div>
            <div class="input-field">
                <label>product Size: </label>
                <input type="text" name="size" required placeholder="add product size">
            </div>
            <div class="input-field">
                <label>product price: </label>
                <input type="number" name="price" required placeholder="add product price">
            </div>
            <div class="input-field">
                <label>product details: </label>
                <textarea name="content" placeholder="write product description" required></textarea>
            </div>
            <div class="input-field">
                <label>product image: </label>
                <input type="file" name="image" accept="image/" required>
            </div>
            <div class="flex-btn">
                <button type="submit" name="publish" class="btn" style = "justify-content: center">publish product</button>
                <button type="submit" name="draft" class="btn" style = "justify-content: center">save as draft</button>
            </div>
           </form>
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js" type="text/javascript"></script>
      <?php include '../components/alert.php';?>
</body>
</html>
