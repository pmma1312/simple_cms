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
    <link rel="stylesheet" href="css/cms.css">
    <script src="js/cms.js"></script>
  </head>
  <body>
    <div class="container">
      <div class="navbar">
        <ul>
          <li><a href="" class="active">Home</a></li>
          <li><a href="settings.php">Settings</a></li>
          <li><a href="php/logout.php">Logout</a></li>
        </ul>
      </div>
      <div class="main">
        <div class="control">
          <div class="entry-list">

          </div>
          <div class="info">
            <div class="buttons">
              <button type="button" name="button" class="btn" onclick="javascript:newEntry();">New Blog Entry</button>
              <button type="button" name="button" class="btn" onclick="javascript:clearTextarea();">Clear Text Input Field</button>
            </div>
          </div>
        </div>
        <div class="edit">
          <form class="" action="php/cms/entry.php" id="edit_form" method="post">
            <input type="text" name="title" id="title" placeholder="Title" autocomplete="off">
            <textarea id="" name="editor" required></textarea>
            <input type="submit" name="" value="Submit">
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
