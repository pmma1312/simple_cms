<?php

  session_start();

  include("../classes/userMessage.php");

  if(!isset($_SESSION['logged_in'])) {
    $error = new userMessage("Unauthorized access.", "error");
    header("Location: ../../login.php");
    die();
  }

  if(!isset($_GET['cid'])) {
    $error = new userMessage("CID is not set.", "error");
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
    $error = new userMessage("The entry you're trying to edit doesn't exist.", "error");
    header("Location: ../../cms.php");
    die();
  }

  $result = $result->fetch_assoc();

  if($result['aid'] != $_SESSION['aid']) {
    $error = new userMessage("You can only delete your own entrys.", "error");
    header("Location: ../../cms.php");
    die();
  }

  $query = "UPDATE content SET deleted = 1 WHERE cid = " . $cid;

  if(!$conn->query($query)) {
    $error = new userMessage("Update failed, please try again.", "error");
    header("Location: ../../cms.php");
    die();
  }

  $success = new userMessage("Deleted entry successful.", "success");

  header("Location: ../../cms.php");
  die();

?>
