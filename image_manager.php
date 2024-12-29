<?php
    function directory($type) 
    {
        return "../image/{$type}/";
    }

    // Define the allowed image extensions
    function upload_image($file, $id, $user_type) 
    {
        // Allowed file extensions
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        // Check if the file was uploaded without errors
        if ($file['error'] !== 0) 
            return "Error: There was a problem uploading the file.";
        
    
        // Get the file extension
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
        // Check if the file has a valid extension
        if (!in_array($fileExtension, $allowedExtensions)) 
            return "Error: Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
        
    
    
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


    function update_image($directory, $id, $file)
    {
        // Define allowed file extensions
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        // Ensure the directory ends with a slash
        $directory = rtrim($directory, '/') . '/';

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