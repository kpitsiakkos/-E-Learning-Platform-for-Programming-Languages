<?php
    include 'db_connection.php';
    $dbConn =getConnection();

    ini_set("session.save_path", "/home/w21046657/Session_Data");
    session_start();


    //Get the total number of questions in the database so we can display them
    $query ="SELECT * FROM quiz_questions";
    $result = $dbConn->query($query);
    $all_questions = $result->rowCount();

    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <!-- CSS link -->
    <link rel="stylesheet" href="dashboard_style.css">

    <title>Quiz</title>
</head>
<body>
    
    <div class="quiz_heading">
        <h3>HTML-CSS QUIZ</h3>
    </div>

    <div class="quiz_results">
        <h3>Quiz is over.</h3>
        <p>You have answer all the questions of the quiz. </p>
        <p>Your final Score: <?php echo $_SESSION['score'];?></p>
        <a class="start_quiz" name="retake_quiz" href="quiz.php?n=1">Retake The Quiz</a>
    </div>

    <?php
//if (isset($_POST['retake_quiz'])) {
    //$_SESSION['score'] = 0; 
//}
    ?>





</body>
</html>