<?php

  session_start();

  if(!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    session_destroy();
    die();
  }

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/global.css">
  </head>
  <body>
    <div class="container">
      <div class="navbar">
        <ul>
          <li><a href="cms.php">Home</a></li>
          <li><a href="" class="active">Settings</a></li>
          <li><a href="php/logout.php">Logout</a></li>
        </ul>
      </div>
      <div class="main">
      </div>
    </div>
  </body>
</html>
