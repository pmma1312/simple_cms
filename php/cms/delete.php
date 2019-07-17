<?php

  session_start();

  include("../classes/error.php");

  if(!isset($_SESSION['logged_in'])) {
    $error = new myError("Unauthorized access.");
    header("Location: ../../login.php");
    die();
  }

  if(!isset($_GET['cid'])) {
    $error = new myError("CID is not set.");
    header("Location: ../../cms.php");
    die();
  }

  include("../api/core/database.php");
  $conn = new Database();
  $conn = $conn->getConn();

  $cid = $conn->real_escape_string($_GET['cid']);

  $query = "SELECT * FROM content WHERE cid = " . $cid;
  $result = $conn->query($query);

  if($result->num_rows < 1) {
    $error = new myError("The entry you're trying to edit doesn't exist.");
    header("Location: ../../cms.php");
    die();
  }

  $result = $result->fetch_assoc();

  if($result['aid'] != $_SESSION['aid']) {
    $error = new myError("You can only delete your own entrys.");
    header("Location: ../../cms.php");
    die();
  }

  $query = "UPDATE content SET deleted = 1 WHERE cid = " . $cid;

  if(!$conn->query($query)) {
    $error = new myError("Update failed, please try again.");
    header("Location: ../../cms.php");
    die();
  }

  include("../classes/success.php");
  $success = new mySuccess("Deleted entry successful.");

  header("Location: ../../cms.php");
  die();

?>
