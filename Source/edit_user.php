<?php
    include 'db_connection.php';
    $dbConn =getConnection();
    ini_set("session.save_path", "/home/w21046657/Session_Data");
    session_start();
    
    //Passing user's id to the user profile page 
    //$user_id = $_SESSION['id'];

    // if user id not found in session bring user back to login form
    //if(!isset($user_id)){
        // header('Location: login_form.php');
    //}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <!-- CSS link -->
    <link rel="stylesheet" href="css/user_profile.css">

    <title>User Profile</title>

    <!-- Bootstrap CDN -->
    <!-- font awesome  cdn link.-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
   
<body>
    <!-- Header section starts  -->
    <header class="header">
        <section class="flex">
            <a href="dashboard.php" class="logo">MATHISI</a>  

            <!-- *Creating my search bar -->
            <form class="search-bar" action="" method="post">
                <input type="text" placeholder="Search for courses..." required maxlength="100" name="search_bar">
                <button class="fas fa-search" name="search_bar"  type="submit">
                </button>
            </form>
            <!-- *Insert symbols for the navbar   -->
            <div class="symbols">
                <div class="fas fa-list-ul" id="menu-button"></div>
                <div class="far fa-address-card" id="user-button"></div>
                <div class="fas fa-search" id="search-button"></div>
            </div>

            <!-- *This sections is for users profile to log in and register -->
            <div class="user-profile">
                <img src="/images/user1.png" alt="">               
                <a href="user_profile.html" class="profile-button">View profile</a> 
                    <div class="user-button">
                        <!-- <a href="login_form.php" class="sign-button">Login</a> -->
                        <a href="logout.php" class="sign-button">Log out</a>
                    </div>
            </div>
        </section>
    </header>

    <div class="dashboard-options">

        <div class="user-profile1">
            <img src="/images/laptop.webp" alt="">
             <h2>Welcome</h2>
            <?php 
            $username = filter_has_var(INPUT_POST, 'username') ? $_POST['username'] : null;
            $user_type = filter_has_var(INPUT_POST, 'user_type') ? $_POST['user_type'] : null;
            $_SESSION['username'] = $username; // Username from login form
            $_SESSION['user_type'] = $user_type; // User type from database or login form
            ?>
        </div>

        <nav class="options">
            <!-- <a href="dashboard.php"><i class="fas fa-house-user"></i><span>home</span></a> -->
            <a href="courses.php"><i class="fas fa-graduation-cap"></i><span>Courses</span></a>
            <a href="contact_us.php"><i class="fas fa-concierge-bell"></i><span>Contact us</span></a>
            <a href="about_us.php"><i class="fas fa-info"></i><span>About us</span></a>
            <a href="forum.php"><i class="far fa-comments"></i><span>Forum</span></a>
            <a href="admin_login.php"><i class="fa fa-lock"></i><span>Admin</span></a>
        </nav>
    </div>  

    <!-- UPDATING DATABASE WITH THE USER PROFILE CHANGES HE DID HERE-->
    <?php
    $user_id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: User ID not found.');

    try {
        // Prepare the SQL statement
        $query = "SELECT * FROM user WHERE id = :id";
        $stmt = $dbConn->prepare($query);
        
        // Bind the ID parameter
        $stmt->bindParam(':id', $user_id);
        
        // Execute the statement
        $stmt->execute();
        
        // Fetch the user data
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Extract the user data
        $username = $row['username'];
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $email = $row['email'];
        $user_type = $row['user_type'];
        // Assuming the password won't be pre-filled for security reasons
        
    } catch(PDOException $e) {
        die('ERROR: ' . $e->getMessage());
    }

    if(isset($_POST["update-profile"])) {

        $username = $_POST["username"];
        $username = filter_var($username, FILTER_SANITIZE_STRING);

        $first_name = $_POST["first_name"];
        $first_name = filter_var($first_name, FILTER_SANITIZE_STRING);

        $last_name = $_POST["last_name"];
        $last_name = filter_var($last_name, FILTER_SANITIZE_STRING);

        $email = $_POST["email"];
        $email = filter_var($email, FILTER_SANITIZE_STRING);

        // PREPARING THE STATEMENT TO INSERT THE RETRIEVED DATA INTO THE DATABASE 

        $update_profile = $dbConn->prepare("UPDATE user SET username = ?, first_name = ?, last_name = ?, email = ? WHERE id = ?",);
        $update_profile->execute([$username, $first_name, $last_name, $email, $user_id]);   
        echo '<div class="error-message">Profile details have been changes successfully .</div>';
        
        // IF USER WANTS TO CHANGE PASSWORDS, GETTING THE OLD AND NEW PASSWORD AND UPDATING THE DATABASE

        $old_password = $_POST["old_password"];

        $previous_password = password_hash($_POST['previous_password'], PASSWORD_DEFAULT);
        $previous_password =  filter_var($previous_password, FILTER_SANITIZE_STRING);

        $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $new_password =  filter_var($new_password, FILTER_SANITIZE_STRING);

        $again_password = password_hash($_POST['again_password'], PASSWORD_DEFAULT);
        $again_password = filter_var($again_password, FILTER_SANITIZE_STRING);

        if(!empty($_POST["previous_password"]) && !empty($_POST["new_password"]) && !empty($_POST["again_password"])) {
            // Fetch the current password hash from the database
            $stmt = $dbConn->prepare("SELECT password FROM user WHERE id = ?");
            $stmt->execute([$user_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if($result && password_verify($_POST["previous_password"], $result["password"])) {
                if($_POST["new_password"] == $_POST["again_password"]) {
                    // Hash the new password
                    $new_password_hash = password_hash($_POST["new_password"], PASSWORD_DEFAULT);
                    $update_password_stmt = $dbConn->prepare("UPDATE user SET password = ? WHERE id = ?");
                    $update_password_stmt->execute([$new_password_hash, $user_id]);
                    echo '<div class="error-message">Password change  successfully.</div>';
                } else {
                    echo '<div class="error-message">New passwords do not match.</div>';
                }
            } else {
                echo '<div class="error-message">The old password is incorrect.</div>';
            }
        }

    } 
    ?>
    
    <h1 class="title"> Update your Profile Details</h1>


    <!-- UPDATE SECTION START HERE  -->
    <selection class="update_profile">
    
        <!-- <?php
            $querySQL = "SELECT * FROM user WHERE id = ?";
            //prepare the statement using PDO
            $stmt = $dbConn->prepare($querySQL);

            //execute the query using PDO and passing the username which we retrieved from the form
            $stmt->execute([$user_id]);
            //$user = $stmt->fetchObject();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        ?> -->

        <!-- The ENCTYPE attribute of <form> tag specifies the method of encoding for the form data -->
        <form action="" method="post" enctype="multipart/form-data">

            <div class="flex">

                <div class="inputs">

                    <span>Username :</span>
                    <!-- <input type="text" name="username" required class="box" placeholder="enter your username" value="<?= htmlspecialchars($user['username'] ?? ''); ?>"> -->

                    <input type="text" class="input-box" name="username" required class="box" placeholder="Enter your username"  value="<?= $user['username'];?>"> 
                    
                    <span>First Name :</span>
                    <input type="text" class="input-box" name="first_name" required class="box" placeholder="Enter your first name"  value="<?= $user['first_name'];?>">

                    <span>Last Name :</span>
                    <input type="text" class="input-box" name="last_name" required class="box" placeholder="Enter your last name"  value="<?= $user['last_name'];?>">

                    <span>Email :</span>
                    <input type="email" class="input-box" name="email" required class="box" placeholder="Enter your email"  value="<?= $user['email'];?>">
                </div>
                
                <div class="inputs">

                    <input type="hidden" class="input-box" name="old_password" value="<?= $user['password']; ?>">
                
                    <span>Old password :</span>
                    <input type="password" class="input-box" name="previous_password" placeholder="Enter your previous password">

                    <span>New password :</span>
                    <input type="password" class="input-box" name="new_password" placeholder="Enter your new password">

                    <span>Enter new password again :</span>
                    <input type="password" class="input-box" name="again_password" placeholder="Enter your new password again">
                </div>
            </div>

            <div class="update-button">
                <input  class="button" type="submit" name="update-profile" value="Update Profile">
            </div>

        </form>
    </selection>

    <style>

        .dashboard-options .user-profile1 h2{
            color: var(--white);
        }
        
        .dashboard-options{
            background-color: #555;
        }
        
        .dashboard-options .options a span{
            color: var(--white);
        }
        
        .dashboard-options .options a:hover{
            background-color: var(--light-background);
        }
        
        .header .flex .search-bar input{
            font-size: 20px;
        }
        .header .flex .search-bar{
            padding: 10px 25px;
        }

</style>


    <footer class="footer">
        &copy; E-Learning Platform for Programming Languages by <span> Konstantinos Pitsiakkos ID: w21046657</span> Northumbria University
    </footer>

    <!-- link to Javascript file -->
    <script src="javascript.js"></script>
    
</body>
</html>