<?php  
      include 'db_connection.php';
      $dbConn =getConnection();
  
      ini_set("session.save_path", "/home/w21046657/Session_Data");
      session_start();

      if(isset($_POST['delete_user'])) {
        $user_id = $_POST['delete_user'];

        try {
            
            $query = "DELETE FROM user WHERE id=:user_id";
            $statement = $dbConn->prepare($query);
            $result = $statement->execute(['user_id' => $user_id]);

            if ($result) {
                echo '<div class="error-message">User has been deleted successfully!.</div>';
                header("Location: admin.php"); 
            } else {
                echo '<div class="error-message">User has not been deleted!.</div>';
                header("Location: admin.php"); 
            }
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
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
    <link rel="stylesheet" href="css/user_profile.css">

    <title>User Profile</title>

    <!-- Bootstrap CDN -->
    <!-- font awesome  cdn link.-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    
</body>
</html>