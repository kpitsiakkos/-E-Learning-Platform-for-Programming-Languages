<?php   


        
        $error = false;
        $username = filter_has_var(INPUT_POST, 'username') ? $_POST['username'] : null;
        $username = trim($username);

         $password = filter_has_var(INPUT_POST, 'password') ? $_POST['password'] : null;
         $password = trim($password);

        $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;
        //$password = md5($_POST['password']);
        // $spassword = md5($_POST['spassword']);

        $first_name = filter_has_var(INPUT_POST, 'first_name') ? $_POST['first_name'] : null;
        $first_name = trim($first_name);

        $last_name = filter_has_var(INPUT_POST, 'last_name') ? $_POST['last_name'] : null;
        $last_name = trim($last_name);

        $email = filter_has_var(INPUT_POST, 'email') ? $_POST['email'] : null;
        $email = trim($email);

        $user_type = filter_has_var(INPUT_POST, 'user_type') ? $_POST['user_type'] : null;

        // $educational_level = filter_has_var(INPUT_POST, 'educational_level') ? $_POST['educational_level'] : null;

        

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
        // $educational_levels = array('GCSE', 'A-level', 'Undergraduate', 'Master', 'PHD');
        // if (empty($educational_level)) {
        //     echo "<p>You have not selected an educational level</p>\n";
        //     $errors = true;
        // }
        // else if (!in_array($educational_level, $educational_levels)) {
        //     echo "<p>Please select an educational level</p>\n";
        //     $errors = true;
        // }
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
                header("Location:admin.php"); 
            } catch (Exception $e) {
                echo "Records not found: " . $e->getMessage();
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
            <h1>Add User Here</h1>

            <input type="text" name="first_name" required placeholder="Enter your first name">
            <input type="text" name="last_name" required placeholder="Enter your last name">
            <input type="email" name="email" required placeholder="Enter your email">
            <input type="username" name="username" required placeholder="Enter your username">
            <input type="password" name="password" required placeholder="Enter your password">
            <!-- <input type="password" name="spassword" required placeholder="Enter your password again"> -->
            <select name="user_type">
                <option value="user">user</option>
                <option value="admin">Admin</option>
            </select>
            <input type="submit" name="submit" value="Add User" class="register-button">
        </form>

    </div>
    
</body>
</html>


<!-- 
    <div class="container">
        <div class="row">
            <div class="col-md-10 mt-4">


                <div class="card">
                    <div class="card_header">
                        <h3>User Details
                            <a href="admin.php" class="btn btn-danger float-end">Back</a>
                        </h3>
                    </div>

                    <div class="card-body">

                        <form action="add_user_code.php" method="POST">
                            <div class="details">
                                <label>Username</label>
                                <input type="text" name="username" id="username" class="form-control"/>
                            </div>
                            <div class="details">
                                <label>password</label>
                                <input type="text" name="password" id="password" class="form-control"/>
                            </div>
                            <div class="details">
                                <label>First Name</label>
                                <input type="text" name="first_name" id="first_name" class="form-control"/>
                            </div>
                            <div class="details">
                                <label>Last Name</label>
                                <input type="text" name="last_name" id="last_name" class="form-control"/>
                            </div>
                            <div class="details">
                                <label>Email</label>
                                <input type="text" name="email" id="email" class="form-control"/>
                            </div>
                            <div class="details">
                                <label for="user_type">User Type</label>
                                <select name="user_type" id="user_type" class="form-control">
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            
                            <div class="details">
                                <button class="btn btn-primary" type="submit" name="save_user_button">Save User</button>
                            </div>

                        </form>

                    </div>
                </div>


            </div>
        </div>
    </div>        -->

