<style type = "text/css">
    <?php include 'style.css';?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Tea - Login</title>
</head>
<body>
    <div class = "form-container">
        <section class = "form-container">
            <div class = "title">
                <img src = "assets/image/download.png">
                <h1>Login Now</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis quo voluptatum repellat voluptatibus reprehenderit, ipsam, voluptates, rem eum soluta veniam exercitationem perferendis placeat illo quidem ducimus distinctio 
                    voluptatem odit! Quibusdam.
                </p>
            </div>
            <form action = "#" method = "post">
                <div class = "input-field">
                    <p>Email<sup>*</sup></p>
                    <input type = "text" name = "email" placeholder = "Enter your email" maxlength = "50" oninput = "this.value = this.value.replace(/\s/g,'')" required >
                </div>
                <div class = "input-field">
                    <p>Password<sup>*</sup></p>
                    <input type = "password" name = "pass" placeholder = "Enter the password" maxlength = "50" oninput = "this.value = this.value.replace(/\s/g,'')" required >
                </div>
                <input type = "submit" name = "submit" value = "registration" class = "btn">
                <p>Don't have an account? <u><a href = "registration.php">Register Now</a></u></p>
            </form>
        </section>
    </div>
</body>
</html>