<?php

  session_start();

  if(!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    session_destroy();
    die();
  }

  if(!isset($_POST['password_1']) || !isset($_POST['password_2'])) {
    echo "Post variables missing!";
    die();
  }

  if($_POST['password_1'] != $_POST['password_2']) {
    echo "Passwords do not match!";
    die();
  }

  $password = password_hash($_POST['password_1'], PASSWORD_ARGON2I);

  include("../api/core/database.php");
  $conn = new Database();
  $conn = $conn->getConn();

  $query = "UPDATE admin SET password = '" . $password . "' WHERE aid = " . $_SESSION['aid'];

  if(!$conn->query($query)) {
    echo "Updating the password failed!";
    die();
  }

  header("Location: ../../settings.php");
  die();

?>
