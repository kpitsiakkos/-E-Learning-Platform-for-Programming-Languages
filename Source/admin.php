<?php
    include 'db_connection.php';
    $dbConn =getConnection();

    ini_set("session.save_path", "/home/w21046657/Session_Data");
    session_start();
    
    //Passing user's id to the user profile page 
    $user_id = $_SESSION['id'];

    // if user id not found in session bring user back to login form
    if(!isset($user_id)){
         header('Location: login_form.php');
    }
    //Get the current date and time
    date_default_timezone_set('UTC');


    if(isset($_POST["quiz_submit"])) {
       $question_number = $_POST["question_number"];
       $quiz_question = $_POST["quiz_question"];
       $correct_answer = $_POST["correct_answer"];
       
       
       $choices = array();
       $choices[1] = $_POST['choice1'];
       $choices[2] = $_POST['choice2'];
       $choices[3] = $_POST['choice3'];
       $choices[4] = $_POST['choice4'];
       $choices[5] = $_POST['choice5'];

       

        //  Insert the question into quiz_question table
             
        $questions_query = $dbConn -> prepare("INSERT INTO quiz_questions (question_number, question) VALUES (?,?)");
        $questions_query->execute([$question_number, $quiz_question]);

        if($questions_query){
            //in the $value we have the users choice
            foreach($choices as $choice => $value){
                //check for blank choices not to be inserted into database
                if($value != ''){
                    if($correct_answer == $choice){     
                        $choice_true = 1;
                    }else{
                        $choice_true = 0;
                    }
                    $choice_query = $dbConn -> prepare("INSERT INTO quiz_answers (question_number, choice_true, choice) VALUES (?,?,?)");
                    $choice_query->execute([$question_number, $choice_true, $value]);

                    if($choice_query){ 
                        continue;
                    }else{
                        echo "Error: " . $e->getMessage();
                    }
                }
            }
            echo '<div class="error-message">The quiz have been added to the database.</div>';
            //header("location:admin.php");
        }
    }
    //Get the number of the question that is going to be inserted as the next question
    // Add one question number as the next question id each time a new question is added
    $query ="SELECT * FROM quiz_questions";
    $results = $dbConn->query($query);
    $total_questions = $results->rowCount();
    $next_question = $total_questions+1;

// .....................................................................................
// RETRIEVE THE INPUTS FROM THE ADD IMAGE SECTION HERE AND INSERT THEM INTO THE DATABASE
// .....................................................................................

if(isset($_POST["add_image"])){

    $image_title = $_POST['image_title'];
    $image_title = filter_var($image_title, FILTER_SANITIZE_STRING);

    $image_description = $_POST['image_description'];
    $image_description = filter_var($image_description, FILTER_SANITIZE_STRING);

    $image_path = $_FILES['image_path']['name'];
    $image_path = filter_var($image_path, FILTER_SANITIZE_STRING);
    $image_path_size = $_FILES[ 'image_path' ]['size'];
    $image_path_tmp_name = $_FILES[ 'image_path' ]['tmp_name'];
    $image_path_folder = 'course_images/'.$image_path;

    // .......................................................
    // CHECK IF THE IMAGES TITLE ALREADY EXIST IN OUR DATABASE
    // .......................................................

    $check = $dbConn->prepare("SELECT * FROM photos WHERE title = ? ");
    $check->execute([$image_title]);

    if ($check->rowCount() > 0){
        echo '<div class="error-message">Image Title already exists!</div>';
    } else {
            if($image_path_size > 2000000){
                echo '<div class="error-message">The size of the image is too big</div>';
            }else{
                // Ensure the course_images folder exists in the correct location.
                // If the folder doesn't exist, create a new one.
                if (!is_dir('course_images')) {
                    mkdir('course_images', 0777, true);
                }
                move_uploaded_file($image_path_tmp_name, $image_path_folder);
                // UPLOADING THE FILE TO THE DATABASE
                $insert_image = $dbConn -> prepare("INSERT INTO photos (title, description, image_path) VALUES (?,?,?)");
                $insert_image->execute([$image_title, $image_description, $image_path]);

                echo '<div class="error-message">The image added successfully</div>';
            }
    }

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

    <title>Admin Dashboard</title>

    <!-- Bootstrap CDN -->
    <!-- font awesome  cdn link.-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Bootstrap CDN Link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

</head>

<body>

    <!-- ...................... -->
    <!-- Header section starts  -->
    <!-- ...................... -->

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

    <!-- ....................... -->
    <!-- Dashboard options-->
    <!-- ....................... -->

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
            <a href="admin.php"><i class="fa fa-lock"></i><span>Admin</span></a>
        </nav>
    </div>  

    <!-- ....................... -->
    <!-- Add videos to users page-->
    <!-- ....................... -->
    <?php
        if(isset($_POST['add_video'])) {

            $title = $_POST['title'];   
            $title = filter_var($title, FILTER_SANITIZE_STRING);

            $video_url = $_POST['video_url'];
            $video_url = filter_var($video_url, FILTER_SANITIZE_STRING);

            $details = $_POST['details'];
            $details = filter_var($details, FILTER_SANITIZE_STRING);

            $date = $_POST['date'];
            $date = filter_var($date, FILTER_SANITIZE_STRING);

            $select_video = $dbConn->prepare("SELECT * FROM videos WHERE url_video = ? ");
            $select_video->execute([$video_url]);

            if($select_video->rowCount() > 0){
                echo '<div class="error-message">This video already exist.</div>';
            }else{
                $insert_video = $dbConn -> prepare("INSERT INTO videos (title, content, published_date, url_video) VALUES (?,?,?,?)");
                $insert_video-> execute([$title, $details, $date, $video_url]);
            
                echo '<div class="error-message">Video added successfully.</div>';
            }
            }
    ?>

    <!-- ............................................... -->
    <!-- THE FORM FOR ADMIN TO ADD VIDEOS TO THE COURSE  -->
    <!-- ............................................... -->

    <h1 class="heading">Add Video for the Course Here</h1>
    <section class="add-videos">
        
        <form method="post" enctype="multipart/form-data">
        
            <div class="flex">

                <div class="inputs">
                    <span> Title of Video:</span>
                    <input type="text" class="input-box" required placeholder="Enter Video Title here..." name="title" maxlength="50">
                </div>

                <div class="inputs">
                    <span>Date of Published: </span>
                    <input type="datetime-local" class="input-box" required name="date" value="<?php echo date('Y-m-d\TH:i'); ?>">
                </div>

                <div class="inputs">
                    <span>Video URL:</span>
                    <input type="url" class="input-box" required placeholder="Enter Video URL here..." name="video_url">
                </div>

                <div class="inputs">
                    <span> Details of Video:</span>
                    <textarea type="text" class="input-box" required placeholder="Enter some details of the video here..." name="details" maxlength="600" cols="30" rows="10"></textarea>
                </div>

                <input type="submit" name="add_video" class="button" value="Add video">

            </div>
        </form>

    </section>

    <!-- .......................................................... -->
    <!-- THE SECTION WHERE ADMIN ADD PHOTO EXAMPLES TO THE DATABASE -->
    <!-- .......................................................... -->

    <h1 class="heading">Add Photos for The Course Here</h1>

    <section>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="image_flex">

                <div class="image_details">
                    <span>Image Title</span>
                    <input type="text" class="image_input" placeholder="Enter Image Title..." name="image_title">
                </div>

                <div class="image_details">
                    <span>Image Description</span>
                    <input type="text" class="image_input" placeholder="Enter Image Description..." name="image_description">
                </div>

                <div class="image_details">
                    <span>Select An Image</span>
                    <input type="file" class="image_input" name="image_path" accept="image/jpg, image/jpeg, image/png, image/webp" required> 
                </div>

                <input type="submit" name="add_image" class="button" value="Add image">
                
            </div>
        </form>
    </section>




    <!-- ............................................................................................ -->
    <!-- DISPLAY THE ALL THE USERS DETAILS IN A TABLE FOR ADMIN TO BE ABLE TO MAKE CHANGES IF NEEDED  -->
    <!-- ............................................................................................ -->


    <h1 class="heading">Make Changes To Any User Details </h1>
    <!-- Create the table  -->
     <div class="container">
        <div class="row">
            <div class="col-md-10 mt-4">
                <div class="table">
                    <div class="table_header">
                    <h3>List of Users
                            <a href="add_user.php" class=" btn btn-primary float-end">Add User</a>
                    </h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email Address</th>
                                    <th>User Type</th>
                                    <th>Customise</th> 
                                    <th>Delete</th>
                            </thead>

                            <tbody>
                                <?php $query = "SELECT * FROM user";

                                $statement = $dbConn->prepare($query);
                                $statement->execute();
                                $result = $statement->fetchAll();

                                if($result){
                                    foreach($result as $row){
                                ?>
                                     <tr> <!-- Display in each row user details -->
                                        <td><?= htmlspecialchars($row['id']); ?></td>
                                        <td><?= htmlspecialchars($row['username']); ?></td>
                                        <td><?= htmlspecialchars($row['password']); ?></td>
                                        <td><?= htmlspecialchars($row['first_name']); ?></td>
                                        <td><?= htmlspecialchars($row['last_name']); ?></td>
                                        <td><?= htmlspecialchars($row['email']); ?></td>
                                        <td><?= htmlspecialchars($row['user_type']); ?></td>
                                        <td>
                                            <!-- Passing the id of the selected user to the form so the data will be displayed in the form -->
                                            <a href="edit_user.php?id=<?= $row['id']; ?>" class="btn btn-primary">Edit</a>
                                        </td>
                                        <td>
                                            <form action="delete.php" method="POST">
                                                <!-- Passing the selected id to the file so the selected user will be deleted -->
                                                <button type="submit" class="btn btn-danger" name="delete_user" value="<?= $row['id']; ?>">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php 
                                }

                            }else{
                                echo "DATA NOT FOUND.";
                            }

                            ?>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>    

    <!-- ........................................................................................ -->
    <!-- DISPLAY THE ALL THE QUESTIONS FOR THE QUIZ TO THE ADMIN CAN ADD QUESTION FOR THE COURSE  -->
    <!-- ........................................................................................ -->
                        
    <h1 class="heading">Insert Questions for the Quiz </h1>
                            
    <section class="add-questions">

        <form method="post" enctype="multipart/form-data">

                <div class="inputs">
                    <span> Question Number:</span>
                    <input type="number" class="input-box" value="<?php echo $next_question; ?>" required placeholder="Enter Question Number" name="question_number">
                </div>

                <div class="inputs">
                    <span>Question</span>
                    <input type="text" class="input-box" name="quiz_question" placeholder="Enter question here...">
                </div>

                <div class="inputs">
                    <span>Choice No: 1</span>
                    <input type="text" class="input-box" required placeholder="Enter Question Choice 1" name="choice1">
                </div>
                
                <div class="inputs">
                    <span>Choice No: 2</span>
                    <input type="text" class="input-box" required placeholder="Enter Question Choice 2" name="choice2">
                </div>

                <div class="inputs">
                    <span>Choice No: 3</span>
                    <input type="text" class="input-box" required placeholder="Enter Question Choice 3" name="choice3">
                </div>

                <div class="inputs">
                    <span>Choice No: 4</span>
                    <input type="text" class="input-box" required placeholder="Enter Question Choice 4" name="choice4">
                </div>

                <div class="inputs">
                    <span>Choice No: 5</span>
                    <input type="text" class="input-box" required placeholder="Enter Question Choice 5" name="choice5">
                </div>

                <div class="inputs">
                    <span>Correct Answer:</span>
                    <input type="number" class="input-box" required placeholder="Enter Correct Answer" name="correct_answer">
                </div>

                <input type="submit" name="quiz_submit" class="button" value="submit">

        </form>

    </section>

    <!-- ............................................................. -->
    <!-- DISPLAY THE ALL THE MESSAGES FROM THE STUDENTS TO THE ADMIN   -->
    <!-- ............................................................. -->
    

    <h1 class="heading">Show All Students Messages </h1>
    <section class="show-message">
        <div class="message">
    <?php
            $select_message = $dbConn -> prepare('SELECT * FROM contact'); 
            $select_message->execute();  

            if ($select_message->rowCount() > 0) {
                while ($fetch_message = $select_message -> fetch(PDO::FETCH_ASSOC)) { 
        ?>
        <div class="show-image">
            <div class="name"><?= $fetch_message['name'] ?></div>
            <div class="email"><?= $fetch_message['email']; ?></div>
            <div class="subject"><?= $fetch_message['subject'] ?></div>
            <div class="message"><?= $fetch_message['message'] ?></div>
        </div>

        <?php
            }
            }else{
                echo '<div class="error-message">There are no messages added to the database yet.</div>';
            }
        ?>
        </div>
    </section>



<style>
    .heading {
    text-align: center;
    color: #333;
    font-size: 28px;
    margin: 20px 0;
}

.show-message {
    padding: 20px;
    margin: auto;
    max-width: 800px;
    background: white;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.show-image {
    background: white;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

.show-image .name, 
.show-image .email, 
.show-image .subject, 
.show-image .message {
    margin-bottom: 10px;
    color: #555;
}

.show-image .name {
    font-weight: bold;
    font-size: 20px;
}

.show-image .email {
    color: #888;
    font-size: 16px;
}

.show-image .subject {
    color: #555;
    font-size: 18px;
    font-weight: bold;
}

.show-image .message {
    font-size: 16px;
    line-height: 1.5;
    color: #333;
    white-space: pre-wrap;
}
</style>


    <footer class="footer">
        &copy; E-Learning Platform for Programming Languages by <span> Konstantinos Pitsiakkos ID: w21046657</span> Northumbria University
    </footer>

    <!-- link to Javascript file -->
    <script src="javascript.js"></script>
    
</body>
</html>