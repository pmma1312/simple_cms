<?php

  session_start();

  if(!isset($_SESSION['logged_in'])) {
    header("Location: ../../login.php");
    die();
  }

  if(!isset($_GET['cid'])) {
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
    # Edit later on
    die();
  }

  $query = "UPDATE content SET deleted = 1 WHERE cid = " . $cid;

  if(!$conn->query($query)) {
    die();
  }

  header("Location: ../../cms.php");
  die();

?>
