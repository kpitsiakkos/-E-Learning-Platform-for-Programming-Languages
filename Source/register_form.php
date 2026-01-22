<?php   

        
        $error = false;
        $username = filter_has_var(INPUT_POST, 'username') ? $_POST['username'] : null;
        $username = trim($username);

        $password = filter_has_var(INPUT_POST, 'password') ? $_POST['password'] : null;
        $password = trim($password);

        $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

        $first_name = filter_has_var(INPUT_POST, 'first_name') ? $_POST['first_name'] : null;
        $first_name = trim($first_name);

        $last_name = filter_has_var(INPUT_POST, 'last_name') ? $_POST['last_name'] : null;
        $last_name = trim($last_name);

        $email = filter_has_var(INPUT_POST, 'email') ? $_POST['email'] : null;
        $email = trim($email);

        $user_type = filter_has_var(INPUT_POST, 'user_type') ? $_POST['user_type'] : null;


        if(isset($_POST["submit"])) {

        // Check for required variables
        if (empty($username)) {
            echo "<p>You have not entered a user name</p>\n";
            $errors = true;
        }
        // Check product length
        else if(strlen($username) > 50) {
            echo "<p>The username must be no more than 50 characters</p>\n";
            $errors = true;
        }
        
        if (empty($first_name)) {
            echo "<p>You have not entered a first name</p>\n";
            $errors = true;
        }
        // Check product length
        else if(strlen($first_name) > 50) {
            echo "<p>The first name must be no more than 50 characters</p>\n";
            $errors = true;
        }

        if (empty($last_name)) {
            echo "<p>You have not entered a last name</p>\n";
            $errors = true;
        }
        // Check product length
        else if(strlen($last_name) > 50) {
            echo "<p>The last name must be no more than 50 characters</p>\n";
            $errors = true;
        }

        if (empty($email)) {
            echo "<p>You have not entered an email</p>\n";
            $errors = true;
        }

        $user_types = array('user', 'admin');
        if (empty($user_type)) {
            echo "<p>You have not selected a user type</p>\n";
            $errors = true;
        }
        else if (!in_array($user_type, $user_types)) {
            echo "<p>The user type user or admin</p>\n";
            $errors = true;
        }

        if ($error) {
            echo "<p>Please try <a href='register_form.php'>again</a></p>\n";
        }
        else {
            try {
                require_once("db_connection.php");
                $dbConn = getConnection();
                $insertSQL = "INSERT INTO user (username, password, first_name, last_name, email, user_type) 
                              VALUES(:username, :password, :first_name, :last_name, :email, :user_type)";
                $stmt = $dbConn->prepare($insertSQL);
                $stmt->execute(array(':username' => $username, ':password' => $password, ':first_name' => $first_name, ':last_name' => $last_name, ':email' => $email, ':user_type' => $user_type));
                header("Location:login_form.php"); 
            } catch (Exception $e) {
                echo "Records not found: " . $e->getMessage();
            }
        }
      
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta  http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Form</title>

    <!-- Link to Register css -->
    <link rel="stylesheet" href="css/register_style.css">
</head>

<body>


    <!-- Register form class start here -->

    <div class="register-form">
        <form action="" method="post">
            <h1>Register Here</h1>

            <input type="text" name="first_name" required placeholder="Enter your first name">
            <input type="text" name="last_name" required placeholder="Enter your last name">
            <input type="email" name="email" required placeholder="Enter your email">
            <input type="username" name="username" required placeholder="Enter your username">
            <input type="password" name="password" required placeholder="Enter your password">
            <select name="user_type">
                <option value="user">user</option>
                <option value="admin">Admin</option>
            </select>
            <input type="submit" name="submit" value="Register" class="register-button">
                <p>if you already have an account please sign in here <a href="login_form.php">Sign in</a></p>
        </form>

    </div>
    
</body>
</html>