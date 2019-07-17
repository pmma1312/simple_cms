<?php

  session_start();

  include("../classes/error.php");

  if(!isset($_SESSION['logged_in'])) {
    $error = new myError("Unauthorized access.");
    header("Location: ../../login.php");
    session_destroy();
    die();
  }

  if(!isset($_POST['password_1']) || !isset($_POST['password_2'])) {
    $error = new myError("Post variables missing!");
    header("Location: ../../settings.php");
    die();
  }

  if($_POST['password_1'] != $_POST['password_2']) {
    $error = new myError("Passwords do not match!");
    header("Location: ../../settings.php");
    die();
  }

  $password = password_hash($_POST['password_1'], PASSWORD_ARGON2I);

  include("../api/core/database.php");
  $conn = new Database();
  $conn = $conn->getConn();

  $query = "UPDATE admin SET password = '" . $password . "' WHERE aid = " . $_SESSION['aid'];

  if(!$conn->query($query)) {
    $error = new myError("Updating the password failed!");
    header("Location: ../../settings.php");
    die();
  }

  include("../classes/success.php");
  $success = new mySuccess("The password has successfully been updated.");

  header("Location: ../../settings.php");
  die();

?>
