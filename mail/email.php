<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    include 'phpmailer/src/PHPMailer.php';
    include 'phpmailer/src/Exception.php';
    include 'phpmailer/src/SMTP.php';


    function sendEmail($userEmail, $otp, $type = "password_reset") 
    {
        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        try 
        {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'basharulalamm@gmail.com'; // Your email address
            $mail->Password = 'fvsh tirm iakk jkrk';   // Your email app password
            $mail->SMTPSecure = 'ssl'; // Encryption: 'ssl' 
            $mail->Port = 465; // SMTP port (465 for SSL)

            // Email headers
            $mail->setFrom('basharulalamm@gmail.com', 'Green Tea Coffee Shop'); // Sender's email and name
            $mail->addAddress($userEmail); // Recipient's email
            $mail->isHTML(true); // Enable HTML content

            if ($type === "password_reset")
            {
            // Email subject and body
            $mail->Subject = 'Your OTP for Password Reset - Green Tea Coffee Shop';

            // Email body
            $mail->Body = "
                <div style='font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 30px; border-radius: 10px; max-width: 600px; margin: auto; box-shadow: 0 4px 8px rgba(0,0,0,0.1);'>
                    <div style='text-align: center;'>
                        <h1 style='color: #4CAF50; margin-bottom: 10px;'>Green Tea Coffee Shop</h1>
                        <p style='color: #888; font-size: 14px; margin-top: 0;'>Your Trusted Partner in Coffee</p>
                    </div>
                    <hr style='border: none; border-top: 1px solid #ddd; margin: 20px 0;'>
                    <div style='text-align: left;'>
                        <p style='font-size: 16px; color: #555;'>Hello,</p>
                        <p style='font-size: 16px; color: #555;'>
                            We received a request to reset your password. Use the OTP below to proceed with the password reset process.
                        </p>
                        <div style='text-align: center; margin: 30px 0;'>
                            <span style='display: inline-block; font-size: 24px; font-weight: bold; color: #333; background-color: #E8F5E9; padding: 15px 25px; border-radius: 8px; border: 1px solid #4CAF50;'>
                                $otp
                            </span>
                        </div>
                        <p style='font-size: 16px; color: #555;'>
                            If you did not request this, please ignore this email. Your account remains secure.
                        </p>
                        <p style='font-size: 16px; color: #555;'>Warm regards,</p>
                        <p style='font-size: 16px; font-weight: bold; color: #4CAF50;'>Green Tea Coffee Shop Team</p>
                    </div>
                    <hr style='border: none; border-top: 1px solid #ddd; margin: 20px 0;'>
                    <div style='text-align: center; font-size: 12px; color: #999;'>
                        <p style='margin: 0;'>© " . date('Y') . " Green Tea Coffee Shop. All rights reserved.</p>
                        <p style='margin: 0;'>This email was sent to you as part of a password reset request.</p>
                    </div>
                </div>
        ";
            }
           
            
            
            // Send email
            $mail->send();

            unset($mail);

            return true;
        } 
        catch (Exception $e) 
        {
            echo "Customer email not sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }



    function sendConfirmationEmailWithCredentials($adminEmail, $adminPassword)
    {
        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        try 
        {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'basharulalamm@gmail.com'; // Your email address
            $mail->Password = 'fvsh tirm iakk jkrk';   // Your email app password
            $mail->SMTPSecure = 'ssl'; // Encryption: 'ssl' 
            $mail->Port = 465; // SMTP port (465 for SSL)

            // Email headers
            $mail->setFrom('basharulalamm@gmail.com', 'Green Tea Coffee Shop'); // Sender's email and name
            $mail->addAddress($userEmail); // Recipient's email
            $mail->isHTML(true); // Enable HTML content

            // Email subject and body
            $mail->Subject = 'Your Account Credentials - Green Tea Coffee Shop';

            // Email body

            $mail->Subject = 'Welcome to Green Tea Coffee Shop - Admin Login Credentials';
            $mail->isHTML(true); // Enable HTML content
    
                // Email body
            $mail->Body = "
                    <div style='font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 30px; border-radius: 10px; max-width: 600px; margin: auto; box-shadow: 0 4px 8px rgba(0,0,0,0.1);'>
                        <div style='text-align: center;'>
                            <h1 style='color: #4CAF50; margin-bottom: 10px;'>Green Tea Coffee Shop</h1>
                            <p style='color: #888; font-size: 14px; margin-top: 0;'>Your Trusted Partner in Coffee</p>
                        </div>
                        <hr style='border: none; border-top: 1px solid #ddd; margin: 20px 0;'>
                        <div style='text-align: left;'>
                            <p style='font-size: 16px; color: #555;'>Hello,</p>
                            <p style='font-size: 16px; color: #555;'>
                                Welcome to Green Tea Coffee Shop as an administrator. Below are your login credentials:
                            </p>
                            <p style='font-size: 16px; color: #555;'><strong>Email:</strong> $adminEmail</p>
                            <p style='font-size: 16px; color: #555;'><strong>Password:</strong> $adminPassword</p>
                            <p style='font-size: 16px; color: #555;'>You can log in using the following link:</p>
                            <p style='text-align: center;'>
                                <a href='http://localhost/Project/Green-Tea-Coffee-Shop' style='font-size: 16px; font-weight: bold; color: #fff; background-color: #4CAF50; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Login Now</a>
                            </p>
                            <p style='font-size: 16px; color: #555;'>Warm regards,</p>
                            <p style='font-size: 16px; font-weight: bold; color: #4CAF50;'>Green Tea Coffee Shop Team</p>
                        </div>
                        <hr style='border: none; border-top: 1px solid #ddd; margin: 20px 0;'>
                        <div style='text-align: center; font-size: 12px; color: #999;'>
                            <p style='margin: 0;'>© " . date('Y') . " Green Tea Coffee Shop. All rights reserved.</p>
                            <p style='margin: 0;'>This email was sent to you as part of your admin registration.</p>
                        </div>
                    </div>
            ";
        }

        catch (Exception $e) 
        {
            echo "Admin email not sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }
?>
