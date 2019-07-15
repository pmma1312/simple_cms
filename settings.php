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
    <link rel="stylesheet" href="css/settings.css">
    <script src="js/settings.js"></script>
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
        <div class="user_settings">
          <div class="update password">
            <h1>Update Password</h1>
            <form action="php/cms/update_password.php" id="fr" onsubmit="event.preventDefault(); validateForm();" method="post">
              <input type="password" name="password_1" id="pw1" placeholder="Password" oninput="comparePasswords();" required>
              <input type="password" name="password_2" id="pw2" placeholder="Repeat password" oninput="comparePasswords();" required>
              <input type="submit" value="Submit">
              <p id='pwinfo'>Passwords do not match</p>
            </form>
          </div>
          <div class="update profilepic">
            <h1>Update Profilepic</h1>
            <form class="" action="php/cms/update_profilepic.php" method="post" enctype="multipart/form-data">

            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
