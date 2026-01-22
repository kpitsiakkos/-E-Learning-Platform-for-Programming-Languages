<?php
ini_set("session.save_path", "/home/w21046657/Session_Data");
session_start();
require_once('db_connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="loginProcessStyle.css">

    <title>Login Handler</title>
</head>
<body>
    <h1>Login Form Handler</h1>
<main>

<?php

//retrieve username and password from form
$username = filter_has_var(INPUT_POST, 'username') ? $_POST['username'] : null;
$username = trim($username);
$password = filter_has_var(INPUT_POST, 'password') ? $_POST['password'] : null;
$password = trim($password);

if  (empty($username) || empty($password)) {
    echo "<p>You need to provide a username and a password. Please try 
        <a href='login_form.php'>again</a>.</p>\n";
}
else {
    try{
        //Clear any Session setting that might left from a previous Session.

        unset($_SESSION['username']);
        unset($_SESSION['logged-in']);

        require_once("db_connection.php");
        $dbConn =getConnection();

        $querySQL = "SELECT password, user_type, id FROM user WHERE username = :username";
        //prepare the statement using PDO
        $stmt = $dbConn->prepare($querySQL);

        //execute the query using PDO and passing the username which we retrieved from the form
        $stmt->execute(array(':username' => $username));
        $user = $stmt->fetchObject();

        //if there is a record returned.
        if ($user) {
            //check the user input for the password against password from the database
            if(password_verify($password, $user->password)){
                //if user_type = admin then got to <a href='admin_dashboard.php'>
                echo "<p>Logon Success!</p>\n";
                header("Refresh:5; url=dashboard.php");
                echo "You'll be redirected in 5 seconds. if not, click <a href='dashboard.php'>here</a>.\n";
                echo "<a href='dashboard.php'>Confirm</a>\n";
               
                /* Set a session variable called logged-in and 
                give it the value true to indicate a successful logon*/
                $_SESSION['logged-in'] = true;
                /* Set a session variable called username and 
                add the user's username as its value */
                $_SESSION['username'] = $username;
                $_SESSION['id'] = $id;
             
                    
                if ($user->user_type == 'admin') {
                    //$_SESSION['admin_id'] = $user->id;
                    $_SESSION['id'] = $user->id;
                    header("Location: admin_dashboard.php");
                    //exit(); 
                } elseif ($user->user_type == 'user') {
                    $_SESSION['id'] = $user->id; 
                    header("Location: dashboard.php");
                    //exit(); 
                } else {
                    $message[] = 'No user found'; 
                }
                
                
                /*header("refresh:5url=restricted.php");
                echo "You'll be redirected in 5 seconds. if not, click <a href='restricted.php'>here</a>.\n";*/
            } else {
                echo "<p>Username or password were incorrect. Please try
                <a href='login_form.php>again</a>.</p>\n";
            }
        }else {
            echo "<p>Username or password were incorrect. Please try
                <a href='login_form.php>again</a>.</p>\n";
        }
    } catch (Exception $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }

}
?>


</main>


<footer>
    <p>&copy; <?php echo date("Y"); ?> - This website</p>
</footer>

</body>
</html>