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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <title>Settings</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/global_mobile.css">
    <link rel="stylesheet" href="css/settings.css">
    <link rel="stylesheet" href="css/settings_mobile.css">
    <script src="js/settings.js"></script>
  </head>
  <body>
    <div class="container">
      <div class="navbar" id="nav">
        <ul>
          <p id="logged">Logged in as: <?php echo  $_SESSION['username']; ?></p>
          <li><a href="cms.php">Home</a></li>
          <li><a href="#" class="active">Settings</a></li>
          <li><a href="php/logout.php">Logout</a></li>
        </ul>
      </div>
      <div class="main">
        <button id="burgor" onclick="javscript:showmenu();">&#9776;</button>
        <div class="user_settings">
          <div class="update password">
            <h1>Update Password</h1>
            <form action="php/cms/update_password.php" id="fr" onsubmit="event.preventDefault(); validateForm();" method="post">
              <input type="password" name="password_1" id="pw1" placeholder="Password" oninput="comparePasswords();" autocomplete="new-password" required>
              <input type="password" name="password_2" id="pw2" placeholder="Repeat password" oninput="comparePasswords();" autocomplete="new-password" required>
              <input type="submit" value="Submit">
              <p id='pwinfo'>Passwords do not match</p>
            </form>
          </div>
          <div class="update profilepic">
            <h1>Update Profile Picture</h1>
            <form class="" action="php/cms/update_profilepic.php" method="post" enctype="multipart/form-data">
              <img id="output">
              <input type="file" accept="image/*" name="pic" onchange="loadFile(event)">
              <input type="submit" name="" value="Submit">
            </form>
          </div>
        </div>
        <div class="add_user">
          <p>The default password for every user is "admin" I advise to change the password as soon as possible</p>
          <form class="" action="php/cms/adduser.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="submit" name="submit" value="Submit">
          </form>
        </div>
      </div>
    </div>
  </body>
  <script src="js/global.js"></script>
</html>
