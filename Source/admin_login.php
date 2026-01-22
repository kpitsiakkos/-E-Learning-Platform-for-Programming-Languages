<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta  http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Log-in</title>

    <!-- Link to Register css -->
    <link rel="stylesheet" href="css/register_style.css">
</head>

<body>
    <!-- Login form class start here -->

    <div class="register-form">
        <form action="admin_login_process.php" method="post">
            <h1>Login Here</h1>
            <input type="username" name="username" placeholder="Enter your username">
            <input type="password" name="password" placeholder="Enter your password">
            <input type="submit" name="submit" value="Log in" class="register-button">
                <p>if you don't have an account register here -> <a href="register_form.php">Register</a></p>
        </form>

    </div>
    
</body>
</html>