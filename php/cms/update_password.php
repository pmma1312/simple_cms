<?php

  session_start();

  include("../classes/userMessage.php");

  if(!isset($_SESSION['logged_in'])) {
    $error = new userMessage("Unauthorized access.", "error");
    header("Location: ../../login.php");
    session_destroy();
    die();
  }

  if(!isset($_POST['password_1']) || !isset($_POST['password_2'])) {
    $error = new userMessage("A password is missing!", "error");
    header("Location: ../../settings.php");
    die();
  }

  if($_POST['password_1'] != $_POST['password_2']) {
    $error = new userMessage("Passwords do not match!", "error");
    header("Location: ../../settings.php");
    die();
  }

  $password = password_hash($_POST['password_1'], PASSWORD_ARGON2I);

  include("../api/core/database.php");
  $conn = new Database();
  $conn = $conn->getConn();

  $query = "UPDATE admin SET password = '" . $password . "' WHERE aid = " . $_SESSION['aid'];

  if(!$conn->query($query)) {
    $error = new userMessage("Updating the password failed!", "error");
    header("Location: ../../settings.php");
    die();
  }

  $success = new userMessage("The password has successfully been updated.", "success");

  header("Location: ../../settings.php");
  die();

?>
