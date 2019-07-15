<?php

  if ( isset($_POST['btn-login']) && !empty($_POST['btn-login']) ) {
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
    $query = "SELECT userName, userStatus FROM user WHERE userName='$userName'";
    $result = mysqli_query($conn, $query);
    $count = mysqli_num_rows($result);

    if ($count == 1) {
      $user = $result->fetch_assoc();
      ob_start();
      session_start();
      $_SESSION['user'] = $user['userName'];
      $_SESSION['userStatus'] = $user['userStatus'];
      header('Location: ../');
    }
    }
  }
