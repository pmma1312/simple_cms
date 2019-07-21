<?php

  session_start();

  include("../classes/userMessage.php");

  if(!isset($_SESSION['logged_in'])) {
    $error = new userMessage("Unauthorized access.", "error");
    header("Location: ../../login.php");
    session_destroy();
    die();
  }

  if(!isset($_FILES['pic'])) {
    $error = new userMessage("No file found", "error");
    header("Location: ../../settings.php");
    die();
  }

  include("../api/core/database.php");
  include("../classes/file.php");

  $conn = new Database();
  $conn = $conn->getConn();

  # Get old profile pic
  $query = "SELECT profile_pic FROM admin WHERE aid = " . $_SESSION['aid'];
  $result = $conn->query($query);
  $result = $result->fetch_assoc();

  $old = $result['profile_pic'];

  $file = new File($_FILES['pic'], $conn);

  if(!$file->checkFile()) {
    $error = new userMessage($file->error, "error");
    header("Location: ../../settings.php");
    die();
  }

  $query = "UPDATE admin SET profile_pic = '" . $file->insertName . "' WHERE aid = " . $_SESSION['aid'];

  if(!move_uploaded_file($_FILES['pic']['tmp_name'], $file->fullFileName)) {
    $error = new userMessage("Moving the uploaded file failed.", "error");
    header("Location: ../../settings.php");
    die();
  }

  if(!$conn->query($query)) {
    $error = new userMessage("Database update failed.", "error");
    header("Location: ../../settings.php");
    die();
  }

  if($old != "img/admin/default.png") {
    unlink($_SERVER['DOCUMENT_ROOT'] . "/" . $old);
  }

  $success = new userMessage("The profile pic has successfully been updated.", "success");

  header("Location: ../../settings.php");
  die();

?>
