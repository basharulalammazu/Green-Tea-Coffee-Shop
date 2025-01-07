<?php
    function isStrongPassword($password) 
    {
        $errors = [];
    
        // Check minimum length
        if (strlen($password) < 8) 
            $errors[] = "Password must be at least 8 characters long.";
        
    
        // Check for at least one uppercase letter
        if (!preg_match('/[A-Z]/', $password)) 
            $errors[] = "Password must include at least one uppercase letter.";
        
    
        // Check for at least one lowercase letter
        if (!preg_match('/[a-z]/', $password)) 
            $errors[] = "Password must include at least one lowercase letter.";
        
    
        // Check for at least one digit
        if (!preg_match('/[0-9]/', $password)) 
            $errors[] = "Password must include at least one number.";
        
    
        // Check for at least one special character
        if (!preg_match('/[\W_]/', $password)) // \W matches any non-word character, including symbols
            $errors[] = "Password must include at least one special character (e.g., @, #, $, etc.).";
        
    
        // If there are no errors, the password is strong
        if (empty($errors)) 
            return true;
        
    
        // Return the list of errors if the password is not strong
        return $errors;
    }
    
?>