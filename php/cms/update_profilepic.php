<?php

  session_start();

  include("../classes/error.php");

  if(!isset($_SESSION['logged_in'])) {
    $error = new myError("Unauthorized access.");
    header("Location: ../../login.php");
    session_destroy();
    die();
  }

  if(!isset($_FILES['pic'])) {
    $error = new myError("No file found");
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
    $error = new myError($file->error);
    header("Location: ../../settings.php");
    die();
  }

  $query = "UPDATE admin SET profile_pic = '" . $file->insertName . "' WHERE aid = " . $_SESSION['aid'];

  if(!move_uploaded_file($_FILES['pic']['tmp_name'], $file->fullFileName)) {
    $error = new myError("Moving the uploaded file failed.");
    header("Location: ../../settings.php");
    die();
  }

  if(!$conn->query($query)) {
    $error = new myError("Database update failed.");
    header("Location: ../../settings.php");
    die();
  }

  if($old != "img/admin/default.png") {
    unlink($_SERVER['DOCUMENT_ROOT'] . "/" . $old);
  }

  header("Location: ../../settings.php");
  die();

?>
