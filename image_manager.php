<?php
    function directory($type) 
    {
        return "../image/{$type}/";
    }

    // Define the allowed image extensions
    function upload_image($file, $id, $user_type) 
    {   

            // Image handling
            $image = $_FILES['image']['name'];
            $image = filter_var($image, FILTER_SANITIZE_STRING);
            $image_size = $_FILES['image']['size'];
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_folder = '../image/'.$user_type.'/';

        // Allowed file extensions
        $extension = pathinfo($image, PATHINFO_EXTENSION);
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        // Check if the file was uploaded without errors
        if ($file['error'] !== 0) 
            return "Error: There was a problem uploading the file.";

            if (!in_array(strtolower($extension), $allowed_extensions)) 
            $warning_msg[] = 'Invalid image format. Allowed formats: jpg, jpeg, png, gif.';
             else if ($image_size > 200000)
                     $warning_msg[] = 'Image size is too large. Maximum allowed size is 200KB.';
        

         // Rename the image to id.extension
         $new_image_name = $id . '.' . $extension;
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
                 $product_directory = "../image/".$user_type."/";
                 $new_image_name = $id . '.' . $image_extension;
                 $new_image_path = $product_directory . $new_image_name;

                 // Ensure the product directory exists
                 if (!is_dir($product_directory)) 
                     mkdir($product_directory, 0777, true); // Create the directory if it doesn't exist
                 

                 // Move the uploaded file
                 if (move_uploaded_file($image_tmp_name, $new_image_path)) 
                     return true;                          
                 else
                     $warning_msg[] = 'Failed to upload.';
                 
             } else 
                 $warning_msg[] = 'Invalid image format. Only JPG, JPEG, PNG, and GIF are allowed.';
             
         } 
         else 
             $warning_msg[] = 'No image uploaded.';

    
    /*    // Get the file extension
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
        // Check if the file has a valid extension
        if (!in_array($fileExtension, $allowedExtensions)) 
            return "Error: Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";

        // Get the directory path
        $directory = directory($user_type);
        
        // Create the target file path
        $targetFile = $directory($user_type) . $id . '.' . $fileExtension;
    
        // Check if the file already exists
        if (file_exists($targetFile)) 
            return "Error: A file with this name already exists.";
        
    
        // Check file size (limit to 5MB)
        if ($file['size'] > 5 * 1024 * 1024)  // 5MB
            return "Error: File size exceeds the maximum limit of 5MB.";
        
    
        // Try to move the uploaded file to the target directory
        if (move_uploaded_file($file['tmp_name'], $targetFile)) 
            return $targetFile; // Return the uploaded file path
        else 
            return "Error: Failed to move the uploaded file.";
     
    */

    }


    function get_image_path($id, $user_type) 
    {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $basePath = directory($user_type);  // For 'admin' or 'product'
    
        foreach ($allowedExtensions as $extension) 
        {
            $imagePath = $basePath . $id . '.' . $extension;
            if (file_exists($imagePath)) 
                return $imagePath;            
        }
        
        if ($user_type == 'product') 
            return "../image/default_product.png";
        else if ($user_type == 'admin') 
            return "../image/default_user.jpg";
    }


    function update_image($user_type, $id, $file)
    {
        // Define allowed file extensions
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        // Ensure the directory ends with a slash
        $directory = directory($user_type);

        // Check if the file was uploaded without errors
        if (isset($file['error']) && $file['error'] === UPLOAD_ERR_OK) {
            $file_name = $file['name'];
            $file_tmp = $file['tmp_name'];

            // Get the file extension
            $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            // Validate file extension
            if (!in_array($file_extension, $allowed_extensions)) {
                return false; // Invalid file format
            }

            // Generate the new file path
            $new_image_path = $directory . $id . '.' . $file_extension;

            // Check if an old image exists
            foreach ($allowed_extensions as $ext) 
            {
                $old_image_path = $directory . $id . '.' . $ext;
                if (file_exists($old_image_path)) {
                    unlink($old_image_path); // Delete the old image
                    break;
                }
            }

            // Move the uploaded file to the server
            if (move_uploaded_file($file_tmp, $new_image_path)) {
                return $new_image_path; // Return the new image path on success
            }
        }

        return false; // Return false if the update failed
    }


    function delete_image($id, $user_type)
    {
        // Define allowed file extensions
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        // Get the directory path
         $directory = directory($user_type);

        // Ensure the directory ends with a slash

        // Check if an image exists
        foreach ($allowed_extensions as $ext) 
        {
            $image_path = $directory($user_type) . $id . '.' . $ext;
            if (file_exists($image_path)) 
            {
                unlink($image_path); 
                return true; 
            }
        }

        return false; // Return false if the image was not found
    }

    /*
        $productImagePath = get_image_path($product_id, 'product');
        echo '<img src="' . $productImagePath . '" alt="Product Image">';

        $adminImagePath = get_image_path($admin_id, 'admin');
        echo '<img src="' . $adminImagePath . '" alt="Admin Image">';


        // Picture upload
        if (isset($_FILES['image'])) {
            $uploadResult = upload_image($_FILES['image'], $product_id, 'product');
            if (strpos($uploadResult, 'Error') === false) {
                echo "Image uploaded successfully: " . $uploadResult;
            } else {
                echo $uploadResult; // Display error message
            }
        }


        if (isset($_FILES['image'])) {
            $uploadResult = upload_image($_FILES['image'], $admin_id, 'admin');
            if (strpos($uploadResult, 'Error') === false) {
                echo "Image uploaded successfully: " . $uploadResult;
            } else {
                echo $uploadResult; // Display error message
            }
        }

    */




?>