<?php
include '../components/connection.php';
session_start();
if ($_SESSION['user_type'] !== 'Admin') 
    header('Location: ../login.php');

$admin_id = $_SESSION['user_id'];

if (!isset($admin_id)) 
    header("location:../admin/login.php");

// deleted message
if (isset($_POST['delete'])) 
{
    $delete_id = $_POST['delete_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    // Verify if the message exists
    $verify_delete_query = "SELECT * FROM `message` WHERE id = '$delete_id'";
    $verify_delete_result = mysqli_query($conn, $verify_delete_query);

    if (mysqli_num_rows($verify_delete_result) > 0) 
    {
        // Delete the message
        $delete_message_query = "DELETE FROM `message` WHERE id = '$delete_id'";
        if (mysqli_query($conn, $delete_message_query)) 
            $success_msg[] = 'Message deleted';
         else 
            $warning_msg[] = 'Failed to delete the message';
        
    } 
    else 
        $warning_msg[] = 'Message already deleted';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="admin_style.css?v=<?php echo time(); ?>">
    <title>Green Tea Coffee Shop - Unread Message's Page</title>
</head>

<body>
    <?php include '../admin/components/admin_header.php'; ?>
    <div class="main">
        <dib class="banner">
            <h1>Unread Message's</h1>
        </dib>
        <div class="title2">
            <a href="../admin/dashboard.php">Dashboard</a><span> / Unread Message's</span>
        </div>
        <section class="account">
            <h1 class="heading">Unread Messages</h1>
            <div class="box-container">
                <?php
                    // Execute the SQL query
                    $result = mysqli_query($conn, "SELECT * FROM `message` ORDER BY id DESC");

                    if (mysqli_num_rows($result) > 0) 
                    {
                        while ($fetch_message = mysqli_fetch_assoc($result)) 
                        {
                            ?>
                            <div class="box">
                                <h3 class="name"><?= ($fetch_message['name']); ?></h3>
                                <h4><?= ($fetch_message['subject']); ?></h4>
                                <p><?= ($fetch_message['message']); ?></p>
                                <form action="" method="post" class="flex-btn">
                                    <input type="hidden" name="delete_id" value="<?= $fetch_message['id']; ?>">
                                    <a type="submit" name="delete" class="btn" onclick="return confirm('Delete this message?');">Delete Message</a>
                                </form>
                            </div>
                            <?php
                        }
                    } 
                    else 
                    {
                        echo '<div class="empty">
                                <p>No messages available</p>
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