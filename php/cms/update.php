<?php

  session_start();

  include("../classes/error.php");

  if(!isset($_SESSION['logged_in'])) {
    $error = new myError("Unauthorized access.");
    header("Location: ../../login.php");
    session_destroy();
    die();
  }

  if(!isset($_POST['editor'])) {
    $error = new myError("Post data missing.");
    header("Location: ../../cms.php");
    session_destroy();
    die();
  }

  if(strlen($_POST['editor']) < 1) {
    $error = new myError("No text recieved.");
    header("Location: ../../cms.php");
    die();
  }

  if(!isset($_GET['cid'])) {
    $error = new myError("CID missing.");
    header("Location: ../../cms.php");
    session_destroy();
    die();
  }

  include("../api/core/database.php");

  $conn = new Database();
  $conn = $conn->getConn();
  $allowedTags = "<a><b><i><h2><h3><h4><h5><h6><pre>";

  $text = strip_tags($conn->real_escape_string($_POST['editor']), $allowedTags);
  $cid = $conn->real_escape_string($_GET['cid']);

  # Check if user that updates is user that wrote the post
  $result = $conn->query("SELECT aid FROM content WHERE cid = " . $cid);

  if($result->num_rows < 1) {
    $error = new myError("The post you're trying to edit doesn't exist.");
    header("Location: ../../cms.php");
    die();
  }

  $result = $result->fetch_assoc();

  if($result['aid'] != $_SESSION['aid']) {
    $error = new myError("You can only edit your own posts!");
    header("Location: ../../cms.php");
    die();
  }

  if(isset($_POST['title'])) {
    if(strlen($_POST['title']) < 1) {
      $error = new myError("The title can't be empty!");
      header("Location: ../../cms.php");
      die();
    }
    $title = htmlspecialchars(strip_tags($conn->real_escape_string($_POST['title'])));
  }

  if(isset($_POST['title']) && isset($_POST['editor'])) {
    $query = "UPDATE content SET title = '" . $title . "' WHERE cid = " . $cid;
    $query1 = "UPDATE content SET content = '" . $text . "' WHERE cid = " . $cid;
  } elseif(isset($_POST['title']) && !isset($_POST['editor'])) {
    $query = "UPDATE content SET title = '" . $title . "' WHERE cid = " . $cid;
  } else {
    $query = "UPDATE content SET content = '" . $text . "' WHERE cid = " . $cid;
  }

  if(!$conn->query($query)) {
      $error = new myError("Update failed, please try again!");
      header("Location: ../../cms.php");
      die();
  }

  if(isset($query1)) {
    if(!$conn->query($query1)) {
      $error = new myError("Update failed, please try again!");
      header("Location: ../../cms.php");
      die();
    }
  }

  header("Location: ../../cms.php");
  die();

?>
