<?php

  session_start();

  include("../classes/userMessage.php");

  if(!isset($_SESSION['logged_in'])) {
    $error = new userMessage("Unauthorized access.", "error");
    header("Location: ../../login.php");
    session_destroy();
    die();
  }

  if(!isset($_POST['editor']) || !isset($_POST['title'])) {
    $error = new userMessage("Post data missing.", "error");
    header("Location: ../../cms.php");
    die();
  }

  if(strlen($_POST['editor']) < 1 || strlen(trim($_POST['title'])) < 1) {
    $error = new userMessage("Text or title is not set!", "error");
    header("Location: ../../cms.php");
    die();
  }

  include("../api/core/database.php");
  $conn = new Database();
  $conn = $conn->getConn();
  $allowedTags = "<a><b><i><h2><h3><h4><h5><h6><pre>";

  $text = strip_tags($conn->real_escape_string($_POST['editor']), $allowedTags);
  $title = htmlspecialchars(strip_tags($conn->real_escape_string($_POST['title'])));

  $date = date("Y-m-d");

  $query = "INSERT INTO content(aid, title, content, entry_date, deleted) VALUES(" . $_SESSION['aid'] . ", '" . $title . "', '" . $text . "', '" . $date . "', '0')";

  if(!$conn->query($query)) {
    $error = new userMessage("Inserting the entry failed.", "error");
    header("Location: ../../cms.php");
    die();
  }

  include("../classes/success.php");
  $success = new userMessage("The entry has been created.", "success");

  header("Location: ../../cms.php");
  die();

?>
