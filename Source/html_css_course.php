<?php

    ini_set("session.save_path", "/home/w21046657/Session_Data");
    session_start();
    
    //Passing user's id to the user profile page 
    $user_id = $_SESSION['id'];

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

    <!-- .....................  -->
    <!-- Header section starts  -->
    <!-- .....................  -->

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

    <!-- ...................................  -->
    <!-- DASHBOARD OPTION SECTION START HERE  -->
    <!-- ...................................  -->

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
            <a href="courses.php"><i class="fas fa-graduation-cap"></i><span>Courses</span></a>
            <a href="contact_us.php"><i class="fas fa-concierge-bell"></i><span>Contact us</span></a>
            <a href="about_us.php"><i class="fas fa-info"></i><span>About us</span></a>
            <a href="forum.php"><i class="far fa-comments"></i><span>Forum</span></a>
            <a href="admin_login.php"><i class="fa fa-lock"></i><span>Admin</span></a>
        </nav>
    </div>  


    <h1 class="courses-header"> HTML - CSS TUTORIAL </h1>
    
    <?php
    include 'db_connection.php';

    $dbConn = getConnection();

    //................................................................................
    // DISPLAY ALL THE VIDEOS THAT HAVE BEEN INSERTED INTO THE DATABASE FROM THE ADMIN
    //................................................................................

    try {
        // Prepare the SQL statement to include content and published_date, title, url_video
        $sql = "SELECT title, url_video, content, published_date FROM videos";
        $stmt = $dbConn->prepare($sql);

        $stmt->execute();
        $videos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($videos) {
            echo "<ul>";
            foreach ($videos as $video) {
                // Convert YouTube URL to embed URL
                parse_str(parse_url($video['url_video'], PHP_URL_QUERY), $urlParams);
                $videoId = $urlParams['v'];
                $embedUrl = "https://www.youtube.com/embed/" . $videoId;

                // Display video information
                echo "<li>";
                echo "<h3>" . htmlspecialchars($video['title']) . "</h3>";
                // Embed the YouTube video
                echo "<iframe width='760' height='315' src='" . $embedUrl . "' frameborder='0' allowfullscreen></iframe>";
                // Display content and published date
                echo "<p>Published on: " . date("F j, Y", strtotime($video['published_date'])) . "</p>";
                echo "<p>" . htmlspecialchars($video['content']) . "</p>";
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "No videos found.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>


<!-- ............................................................................... -->    
<!-- DISPLAY ALL THE IMAGES THAT HAVE BEEN INSERTED INTO THE DATABASE FORM THE ADMIN -->
<!-- ............................................................................... -->


<h1 class="courses-header">Code Examples </h1>
    <section class="show-images">
        <div class="images">
        
        <?php
            $select_images = $dbConn -> prepare('SELECT * FROM photos'); 
            $select_images->execute();  

            if ($select_images->rowCount() > 0) {
                while ($fetch_products = $select_images -> fetch(PDO::FETCH_ASSOC)) { 
        ?>
        <div class="show-image">
            <div class="title"><?= $fetch_products['title'] ?></div>
            <img src="../course_images/<?= $fetch_products['image_path']; ?>" alt="">
            <div class="description"><?= $fetch_products['description'] ?></div>
        </div>


        <?php
            }
            }else{
                echo '<div class="error-message">There are no images added to the database yet.</div>';
            }
        ?>
        </div>
    </section>

<!-- .........................-->
<!-- QUIZ SECTION STARTS HERE -->
<!-- ........................ -->

<h1 class="courses-header">Start The Quiz </h1>
<?php
require_once 'db_connection.php';
$dbConn = getConnection();


    //Get the total number of questions in the database so we can display them
    $query ="SELECT * FROM quiz_questions";
    $result = $dbConn->query($query);
    $all_questions = $result->rowCount();
?>

<div class="quiz headings">

    <h2>Take the quiz if you understand all the contents provided for the course.</h2>
    <p>Quiz Type: <span>Multiple choice</span></p>
    <p>Total questions: <span><?php echo $all_questions; ?></span></p>

    <a class="start_quiz" href="quiz.php?n=1">Start</a>

</div>



 








<!-- ...........................-->
<!-- FOOTER SECTION STARTS HERE -->
<!-- .......................... -->

<footer class="footer">
    &copy; E-Learning Platform for Programming Languages by <span> Konstantinos Pitsiakkos ID: w21046657</span> Northumbria University
</footer>


<!-- link to Javascript file -->
<script src="javascript.js"></script>
    
</body>
</html>