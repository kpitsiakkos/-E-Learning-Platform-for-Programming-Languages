<?php
    ini_set("session.save_path", "/home/w21046657/Session_Data");
    session_start();
   
    $user_id = $_SESSION['id'];  // get the user id from the session
    if(!isset($user_id)){
        header('Location: login_form.php');
   }
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

    <!-- DISPLAY ALL THE COURSES THAT WOULD BE AVAILABLE IN THE FUTURE -->
    <h1 class="courses-header"> All courses </h1>
    <section class="all-courses">

        <div class="courses-area">

            <div class="course">
                <img src="/images/vsc.png" alt="">
                <h2 class="title">Essential! Set up Desktop</h2>
                <a href="essential_course.php" class="button"> Start course</a>
            </div>

            <div class="course">
                <img src="/images/html-css.jpeg" alt="">
                <h2 class="title">MTHS-1001: HTML - CSS</h2>
                <a href="html_css_course.php" class="button"> Start course</a>
            </div>

            <div class="course">
                <img src="/images/python.png" alt="">
                <h2 class="title">MTHS-2001: Python</h2>
                <a href="#" class="button" onclick="showUnavailableMessage(event)">Start course</a>
            </div>

            <div class="course">
                <img src="/images/mysql.png" alt="">
                <h2 class="title">MTHS-1002: MySQL</h2>
                <a href="#" class="button" onclick="showUnavailableMessage(event)">Start course</a>
            </div>

            <div class="course">
                <img src="/images/java.png" alt="">
                <h2 class="title">MTHS-3001: JAVA</h2>
                <a href="#" class="button" onclick="showUnavailableMessage(event)">Start course</a>
            </div>

            <div class="course">
                <img src="/images/php.png" alt="">
                <h2 class="title">MTHS-1003: PHP</h2>
                <a href="#" class="button" onclick="showUnavailableMessage(event)">Start course</a>
            </div>

            <div class="course">
                <img src="/images/javascript.png" alt="">
                <h2 class="title">MTHS-1004: Javascript</h2>
                <a href="#" class="button" onclick="showUnavailableMessage(event)">Start course</a>
            </div>
        </div>
    </section>



    <footer class="footer">
        &copy; E-Learning Platform for Programming Languages by <span> Konstantinos Pitsiakkos ID: w21046657</span> Northumbria University
    </footer>

<!-- link to Javascript file -->
<script src="javascript.js"></script>
    
</body>
</html>