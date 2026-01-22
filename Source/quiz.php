<?php
    include 'db_connection.php';
    $dbConn = getConnection();
    
    ini_set("session.save_path", "/home/w21046657/Session_Data");
    session_start();


    //Get the question number that we passed from the previous page
    $question_number_n = (int) $_GET['n'];

    // Get the total question to know when to redirect the user to the next question or to the result
    $query ="SELECT * FROM quiz_questions";
    $result = $dbConn->query($query);
    $all_questions = $result->rowCount();



    $query ="SELECT * FROM quiz_questions WHERE question_number = $question_number_n";

    $result = $dbConn->query($query);
    $question  = $result->fetch(PDO::FETCH_ASSOC);

    // Get the choices from the database so we can display them on the HTML form
    $query ="SELECT * FROM quiz_answers WHERE question_number = $question_number_n";

    $choices = $dbConn->query($query);
    

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

    <div class="question">
        <div class="current_question">Question <?php echo $question['question_number']; ?> of <?php echo $all_questions; ?> </div>
        <p class="question_title"><?php echo $question['question']?></p>

        <form action="quiz_process.php" method="post">
            <ul class="options">

                <?php while($row = $choices->fetch(PDO::FETCH_ASSOC)) : ?>
                    <li><input name="option" type="radio" value="<?php echo $row['id']; ?>"/><?php echo $row['choice'];?></li> <!-- value is the same as the id question -->
                <?php endwhile; ?>

            </ul>
            <input type="submit" class="option_button" value="submit">
            <input type="hidden" name="question_number_n" value="<?php echo $question_number_n; ?>"/>
        </form>
    </div>







</body>
</html>