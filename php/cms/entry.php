<?php

  session_start();

  include("../classes/error.php");

  if(!isset($_SESSION['logged_in'])) {
    $error = new myError("Unauthorized access.");
    header("Location: ../../login.php");
    session_destroy();
    die();
  }

  if(!isset($_POST['editor']) || !isset($_POST['title'])) {
    $error = new myError("Post data missing.");
    header("Location: ../../cms.php");
    die();
  }

  if(strlen($_POST['editor']) < 1 || strlen(trim($_POST['title'])) < 1) {
    $error = new myError("Text or title is not set!");
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
    $error = new myError("Inserting the entry failed.");
    header("Location: ../../cms.php");
    die();
  }

  include("../classes/success.php");
  $success = new mySuccess("The entry has been created.");

  header("Location: ../../cms.php");
  die();

?>
