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

  $file = new File($_FILES['pic'], $conn);

  if(!$file->checkFile()) {
    echo $file->error;
    die();
  }

  $query = "UPDATE admin SET profile_pic = '" . $file->fullFileName . "' WHERE aid = " . $_SESSION['aid'];

  if(!$conn->query($query)) {
    # DB error
    die();
  }

  if(!move_uploaded_file($_FILES['pic']['tmp_name'], $file->fullFileName)) {
    # Move error
    die();
  }

  header("Location: ../../settings.php");
  die();

?>
