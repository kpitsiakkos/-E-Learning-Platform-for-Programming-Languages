<?php
 include 'db_connection.php';
 $dbConn =getConnection();

 ini_set("session.save_path", "/home/w21046657/Session_Data");
 session_start();

 
 //In the score we gonna store the points for each correct question the user has submitted.
 //The score will be stored in Session["Score"] array, where [0] is for first question and so on...
 if(!isset($_SESSION['score'])){
    $_SESSION['score'] = 0;
 }
 
 if($_POST){

    $question_number_n = $_POST['question_number_n'];
    $selected_option = $_POST['option'];
    $next_question = $question_number_n+1;

    // Get the total question to know when to redirect the user to the next question or to the result
    $query ="SELECT * FROM quiz_questions";
    $results = $dbConn->query($query);
    $total_questions = $results->rowCount();


    //checking if the selected option is equal to the right answer of the current question
    $query ="SELECT * FROM quiz_answers WHERE question_number = $question_number_n AND choice_true = 1";
    $result = $dbConn->query($query);
    $row  = $result->fetch(PDO::FETCH_ASSOC);

    //IN $correct_choice we store the correct answer that we want to compaire  with the selected option of the user.
    $correct_choice = $row['id'];


    if($correct_choice == $selected_option) {//If the selected option is equal to the true add one to the question variable
        $_SESSION['score']++;
    }


    //Here we check if the current question of the quiz is the last one to know where to redirect the user
    if($question_number_n == $total_questions){
        //echo" $question_number_n. <br> $total_questions ";
        header('Location: quiz_results.php');
        exit();
    }else{
        header("Location: quiz.php?n=".$next_question);
    }








 }














?>