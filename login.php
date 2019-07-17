<?php

  session_start();

  if(isset($_SESSION['logged_in'])) {
    header("Location: cms.php");
    die();
  }

  if(isset($_POST['username']) && isset($_POST['password'])) {
    include("php/cms/login.php");
    include("php/classes/error.php");

    $login = new Login($_POST['username'], $_POST['password']);

    if($login->verifyCredentials()) {
      $_SESSION['logged_in'] = true;
      $_SESSION['aid'] = $login->aid;
      $_SESSION['username'] = $login->username;
      header("Location: cms.php");
      die();
    } else {
      $error = new myError("Invalid username or password!");
      header("Location: login.php");
      die();
    }
  }

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta name="theme-color" content="#141414">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <title>Admin Panel Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/login_mobile.css">
  </head>
  <body>
    <div class="container">
      <div class="main">
        <form class="" method="post">
          <h1>Admin Panel Login</h1>
          <input type="text" name="username" placeholder="Username" autocomplete="off" required autofocus>
          <input type="password" name="password" placeholder="Password" required>
          <input type="submit" name="submit" value="Login">
        </form>
        <a href="index.html">Home</a>
      </div>
    </div>
  </body>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
  <script src="js/error_success_helper.js"></script>
  <script src="js/error.js"></script>
</html>
