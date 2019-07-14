<?php

  session_start();

  if(!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    session_destroy();
    die();
  }

  if(!isset($_POST['editor'])) {
    die();
  }

  if(strlen($_POST['editor']) < 1) {
    die();
  }

  include("../api/core/database.php");
  $conn = new Database();
  $conn = $conn->getConn();

  $text = strip_tags($conn->real_escape_string($_POST['editor']));

  $date = date("Y-m-d");

  $query = "INSERT INTO content(aid, content, entry_date) VALUES(" . $_SESSION['aid'] . ",'" . $text . "', '" . $date . "')";

  if(!$conn->query($query)) {
    die();
  }

  header("Location: ../../cms.php");
  die();

?>
