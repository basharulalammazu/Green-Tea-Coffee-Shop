<?php
include '../components/connection.php';
session_start();
$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) 
{
    header("location:../login.php");
    exit;
}

if (isset($_GET['post_id'])) 
    $get_id = $_GET['post_id'];
else 
{
    echo 'No product ID specified.';
    exit;
}

// delete product
if (isset($_POST['delete'])) 
{
    $p_id = $_POST['product_id'];
    $p_id = filter_var($p_id, FILTER_SANITIZE_STRING);

    $delete_image = $conn->prepare("SELECT FROM `products` WHERE id=?");
    $delete_image->execute([$p_id]);

    $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);
    if($fetch_delete_image['image'] !="")
        unlink('../image/product/'.$fetch_delete_image['image']);

    $delete_product = $conn->prepare("DELETE * FROM `products` WHERE id=''");
    $delete_product->execute([$p_id]);
    
    header("location:../admin/view_product.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Green Coffee Admin - Read Product Page</title>
</head>

<body>
    <?php include '../admin/components/admin_header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Read Product</h1>
        </div>
        <div class="title2">
            <a href="../admin/dashboard.php">Dashboard</a><span>/Read Product</span>
        </div>
        <section class="read-post">
            <h1 class="heading">Read Product</h1>
            <?php
                $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                $select_product->bind_param("i", $get_id); // Bind the product ID as an integer
                $select_product->execute();
                $result = $select_product->get_result(); // Fetch the result set
            
                if ($result->num_rows > 0) 
                {
                    while ($fetch_product = $result->fetch_assoc()) 
                    {
                        $productId = $fetch_product['id'];
                        $imageExtension = pathinfo($fetch_product['image'], PATHINFO_EXTENSION);
                        $imagePath = "../image/product/{$productId}.{$imageExtension}";
            ?>
                        <form action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($fetch_product['id']); ?>">
                            <div class="status" style="color:<?php if ($fetch_product['status'] == "active") { echo "green"; } else { echo "red"; } ?>">
                                <?= htmlspecialchars($fetch_product['status']); ?>
                            </div>
            <?php 
                        if (!empty($fetch_product['image'])) 
                        { 
            ?>
                            <img src="<?= $imagePath ?>" class="image" alt="Product Image">
            <?php 
                        } 
            ?>
                            <div class="title"><?= $fetch_product['name']; ?></div>
                            <div class="price">$<?= $fetch_product['price']; ?>/-</div>
                            <div class="content"><?= $fetch_product['product_detail']; ?></div>
                            <div class="flex-btn">
                                <a href="edit_product.php?id=<?= $fetch_product['id']; ?>" class="btn">Edit</a>
                                <button type="submit" name="delete" class="btn" onclick="return confirm('Delete this product?');">Delete</button>
                                <a href="view_product.php?id=<?= $get_id; ?>" class="btn">Go Back</a>
                            </div>
                        </form>
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

</body>

</html>