<?php

  session_start();

  if(!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    session_destroy();
    die();
  }

  if(!isset($_FILES['pic'])) {
    echo "No file found";
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
    echo $file->error;
    die();
  }

  $query = "UPDATE admin SET profile_pic = '" . $file->insertName . "' WHERE aid = " . $_SESSION['aid'];

  if(!move_uploaded_file($_FILES['pic']['tmp_name'], $file->fullFileName)) {
    # Move error
    die();
  }

  if(!$conn->query($query)) {
    # DB error
    die();
  }

  if($old != "img/admin/default.png") {
    unlink($_SERVER['DOCUMENT_ROOT'] . "/" . $old);
  }

  header("Location: ../../settings.php");
  die();

?>
