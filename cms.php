<?php

  session_start();

  if(!isset($_SESSION['logged_in'])) {
    include("php/classes/error.php");
    $error = new myError("Unauthorized access.");
    header("Location: login.php");
    session_destroy();
    die();
  }

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="theme-color" content="#141414">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/cms.css">
    <link rel="stylesheet" href="css/cms_mobile.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/global_mobile.css">
    <script src="js/cms.js"></script>
  </head>
  <body>
    <div class="container">
      <div class="navbar" id="nav">
        <ul>
          <p id="logged">Logged in as: <?php echo  $_SESSION['username']; ?></p>
          <li><a href="#" class="active">Home</a></li>
          <li><a href="settings.php">Settings</a></li>
          <li><a href="php/logout.php">Logout</a></li>
        </ul>
      </div>
      <div class="main">
        <button id="burgor" onclick="javscript:showmenu();">&#9776;</button>
        <div class="control">
          <div class="entry-list">

          </div>
          <div class="info">
            <div class="stats">
              <p id="total"></p>
              <p id="visit_t"></p>
              <p id="visit_u"></p>
            </div>
            <div class="allowed">
              <p>
                The following HTML tags are allowed to use within entries:
              </p>
              <p class="tags">
                &lt;h2-h6&gt;
                &lt;i&gt;
                &lt;b&gt;
                &lt;pre&gt;
                &lt;a&gt;
              </p>
            </div>
            <div class="buttons">
              <button type="button" name="button" class="btn" onclick="javascript:newEntry();">New Blog Entry</button>
              <button type="button" name="button" class="btn" onclick="javascript:clearInputFields();">Clear Text Input Fields</button>
            </div>
          </div>
        </div>
        <div class="edit">
          <form class="" action="php/cms/entry.php" id="edit_form" method="post">
            <input type="text" name="title" id="title" placeholder="Title" autocomplete="off" required>
            <textarea id="" name="editor" required></textarea>
            <input type="submit" name="" value="Submit">
          </form>
        </div>
      </div>
    </div>
  </body>
  <script src="js/global.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
  <script src="js/error.js"></script>
</html>
