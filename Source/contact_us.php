<?php
    ini_set("session.save_path", "/home/w21046657/Session_Data");
    session_start();

    $user_id = $_SESSION['id'];  // get the user id from the session


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <!-- CSS link -->
    <link rel="stylesheet" href="dashboard_style.css">

    <title>Dashboard</title>

    <!-- Bootstrap CDN -->
    <!-- font awesome  cdn link.-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

 
</head>
   

<body>

    <!-- Header section starts  -->
    <header class="header">
        <section class="flex">
            <a href="homepage.html" class="logo">MATHISI</a>  

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
                <a href="user_profile.php" class="profile-button">View profile</a> 
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
            <!-- <a href="user_profile.html" class="profile-button">View profile</a>  -->
        </div>

        <nav class="options">
            <!-- <a href="dashboard.php"><i class="fas fa-house-user"></i><span>home</span></a>  -->
            <a href="courses.php"><i class="fas fa-graduation-cap"></i><span>Courses</span></a>
            <a href="contact_us.php"><i class="fas fa-concierge-bell"></i><span>Contact us</span></a>
            <a href="about_us.php"><i class="fas fa-info"></i><span>About us</span></a>
            <a href="forum.php"><i class="far fa-comments"></i><span>Forum</span></a>
            <a href="admin_login.php"><i class="fa fa-lock"></i><span>Admin</span></a>
        </nav>
    </div>  

    <!-- CONTACT US SECTION START HERE -->


    <div class="contact_us">
    <h6 class="notification"></h6>
    <form method="post" name="email_info" id="email_info" action="">

        <div class="input">
            <span>Full Name:</span>
            <input type="text" name="fullname" id="fullname" placeholder="Enter your Full Name" required>
        </div>

        <div class="input">
            <span>Email Address:</span>
            <input type="email" name="email" id="email" placeholder="Enter your Email Address" required>
        </div>

        <div class="input">
            <span>Subject:</span>
            <input type="text" name="subject" id="subject" placeholder="Enter the subject" required>
        </div>

        <div class="input">
            <span>Message:</span>
            <textarea name="message" id="message" required></textarea>
        </div>

        <div class="input">
            <input type="submit" value="Submit" name="submit">
        </div>
    </form>
</div>

    <?php
    include 'db_connection.php';
    $dbConn = getConnection();


    if(isset($_POST["submit"])) {
        $fullname = $_POST["fullname"];
        $email = $_POST["email"];
        $message = $_POST["message"];
        $subject = $_POST["subject"];
    
        // Prepare SQL query
        $query = $dbConn->prepare("INSERT INTO contact (name, email, message, subject) VALUES (?,?,?,?)");
    
        // Execute query with error handling
        try {
            $query->execute([$fullname, $email, $message, $subject]);
            echo '<div class="error-message">Message sent successfully!</div>';
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    }
?>

    
    <style>
        .error-message {
            color: var(--red); 
            background-color: #FFD2D2;
            border: 1px solid var(--red); 
            border-radius: 5px;
            padding: 10px; 
            margin: 10px 0;
            text-align: center;
            font-size: 16px; 
        }
        .contact_us {
            width: 65%;
            margin: 20px auto;
            padding: 20px;
            background-color: var(--white);
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .contact_us .input {
            margin-bottom: 30px;
        }

        .contact_us .input span {
            display: block;
            margin-bottom: 5px;
            color: var(--main-color);
            font-size: 20px;
        }

        .contact_us input[type="text"],
        .contact_us input[type="email"],
        .contact_us textarea {
            width: 100%;
            margin-top: 10px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        .contact_us textarea {
            height: 100px;
            color: var(--black);
        }

        .contact_us input[type="submit"] {
            font-size: 28px;
            font-weight: normal;
            padding: 10px;
            margin-bottom: 20px;
            color: #D8000C;
            background-color: #FFD2D2;
            border: 1px solid #D8000C;
            border-radius: 8px;
            text-transform: uppercase;
            text-align: center;
            margin-bottom: 30px;
            line-height: 50px;
        }

        .contact_us input[type="submit"]:hover {
            background-color: var(--white); 
        }

    </style>



    <footer class="footer">
        &copy; E-Learning Platform for Programming Languages by <span> Konstantinos Pitsiakkos ID: w21046657</span> Northumbria University
    </footer>

<!-- link to Javascript file -->
<script src="javascript.js"></script>

    
</body>
</html>