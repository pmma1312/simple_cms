<?php

  session_start();

  if(!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    die();
  }

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="css/cms.css">
    <script src="js/cms.js"></script>
  </head>
  <body>
    <div class="container">
      <div class="navbar">
        <ul>
          <li><a href="php/logout.php">Logout</a></li>
        </ul>
      </div>
      <div class="main">
        <div class="control">
          <div class="entry-list">

          </div>
          <div class="info">

          </div>
        </div>
        <div class="edit">
          <form class="" action="" method="post">
            <textarea id="myTextarea" name="editor"></textarea>
            <input type="submit" name="" value="Submit">
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
