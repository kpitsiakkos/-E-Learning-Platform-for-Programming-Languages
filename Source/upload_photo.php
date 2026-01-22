<?php
include 'db_connection.php';
$dbConn =getConnection();

ini_set("session.save_path", "/home/w21046657/Session_Data");
session_start();

//Passing user's id to the user profile page 
$user_id = $_SESSION['id'];


if(isset($_POST["submit"])) {

    $count_files = count($_FILES["files"]['name']); //Number of files

    $query = "INSERT INTO photos (title, description, image_path) VALUES (?,?,?)";
    $statement = $dbConn->prepare($query);

    

}
?>