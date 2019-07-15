<?php

  if ( isset($_POST['btn-signup']) && !empty($_POST['btn-signup']) ) {
    require_once './dbconnect.php';
    $userName = htmlspecialchars(
      strip_tags(
        trim($_POST['userName'])
        )
    );

    $pass = htmlspecialchars(
      strip_tags(
        trim($_POST['pass'])
        )
    );

    //basic email validation
    if ( !filter_var($userName, FILTER_VALIDATE_EMAIL) ) {
    $error = true;
    $userNameError = "Your username must be a valid email address." ;
   } else {
    // checks whether the email exists or not
    $query = "SELECT userName FROM user WHERE userName='$userName'";
    $result = mysqli_query($conn, $query);
    $count = mysqli_num_rows($result);
    if($count!=0){
     $error = true;
     $emailError = "User name is already in use.";
    }
   }
   // password validation
    if (empty($pass)){
    $error = true;
    $passError = "Please enter password.";
   }

   $pw = hash('sha256' , $pass);

   if( !$error ) {

    $query = "INSERT INTO user(userName, userPW) VALUES('$userName','$pw');";
    $res = mysqli_query($conn, $query);

    if ($res) {
     // $errTyp = "success";
     $errMSG = "Successfully registered, you may login now.";
     echo "<h2>$errMSG</h2><h4><a href=\"../\">Login here</a></h4>";
     unset($userName);
     unset($pw);
     $conn->close();
    } else  {
     //$errTyp = "danger";
     $errMSG = "Something went wrong, try again later..." ;
    }

   }
  }
