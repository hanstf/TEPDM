<?php   
require 'func.php';

session_start();

$errMsg = array();

if(isset($_POST['submit'])){
 

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if(count($errMsg)==0){
        $userVerification = verifyUser($username, $password);
        if( $userVerification !== false){
            $_SESSION['user'] = $userVerification;
           
            header('location:main.php');
            exit;
        }else{
         array_push($errMsg, 'Wrong username or password');
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>TEPDM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <!-- Optional Bootstrap theme -->
    <link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="style/custom.css">
    <link href="img/favicon.ico" rel="icon" type="image/x-icon">
</head>
<body>
    <div class="container">
        <div class="margin-auto">
            
                
                <img  alt="Brand" src="img/logo.png">
              
                
        </div>

        
      <form class="form-signin" action="" method="POST">
      <h3 class="form-signin-heading margin-auto-title">Data Management System</h3>
       <?php 
        if (count($errMsg)>0){
            foreach($errMsg as $error){
                
                echo '<div class="alert alert-danger"><p>';
                echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>';
                echo $error; 
                echo '</p></div>';
            }
        }
        
    ?>
        <label for="inputUsername" class="sr-only">Username</label>
        <input type="text" id="inputUsername" name="username" class="margin-large form-control" placeholder="Username" required autofocus>
        
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
        
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Sign in</button>
      </form>

    </div>
    <script src="jquery/jquery-2.1.4.min.js"></script>
    <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</body>
</html>