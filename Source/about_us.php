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
            <!-- <a href="dashboard.php"><i class="fas fa-house-user"></i><span>home</span></a>  -->
            <a href="courses.php"><i class="fas fa-graduation-cap"></i><span>Courses</span></a>
            <a href="contact_us.php"><i class="fas fa-concierge-bell"></i><span>Contact us</span></a>
            <a href="about_us.php"><i class="fas fa-info"></i><span>About us</span></a>
            <a href="forum.php"><i class="far fa-comments"></i><span>Forum</span></a>
            <a href="admin_login.php"><i class="fa fa-lock"></i><span>Admin</span></a>
        </nav>
    </div>  

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

    <section class="about_us">
        <div class="area">
            <h5>About us</h5>
            <img src="/images/homepage/aboutus.webp">
            <div class="text">
                <h6>MATHISI E-Learning Platform</h6>
                <p>Mathisi, an immersive e-learning platform dedicated to developing the skills of aspiring programmers and developers.
                     At Mathisi, we believe in the power of education and are committed to providing students with comprehensive, 
                     accessible and engaging programming courses. Our mission is to deliver the knowledge to the world
                      of programming and empower individuals to unlock their full potential through customized lessons, 
                      and interactive learning experiences. With a focus on quality, innovation and community, 
                      Mathisi is can offer to students and tutors to communicate online and provide better understanding of the materials.
                </p>
            </div>
        </div>
    </section>

    <!-- ADD THE STYLE HERE BECAUSE IT WASN'T WORKING FROM CSS FILE -->
    <style>
        .about_us {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 100px;
            box-sizing: border-box;
        }

        .area {
            width: 100%;
            max-width: 1200px;
            text-align: center;
        }

        .area img {
            width: 100%;
            max-width: 900px;
            height: auto;
            margin-bottom: 30px;
        }

        h5 {
            font-size: 28px;
            font-weight: normal;
            margin-bottom: 20px;
            color: #D8000C;
            background-color: #FFD2D2;
            border: 1px solid #D8000C;
            border-radius: 8px;
            text-transform: uppercase;
            text-align: center;
            margin-bottom: 30px;
            line-height: 50px;
            letter-spacing: 4px;
        }

        .text h6 {
            font-size: 24px;
            font-weight: bold;
            color: var(--main-color1);
            font-weight: normal;
            margin-bottom: 20px;
        }

        .text p {
            font-size: 18px;
            color: var(--black);
            line-height: 1.6;
            margin-bottom: 20px;
            line-height: 2;
        }
    </style>





    <footer class="footer">
        &copy; E-Learning Platform for Programming Languages by <span> Konstantinos Pitsiakkos ID: w21046657</span> Northumbria University
    </footer>

<!-- link to Javascript file -->
<script src="javascript.js"></script>
    
</body>
</html>