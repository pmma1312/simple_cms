<?php

session_start();

if(!isset($_SESSION['logged_in'])) {
  header("Location: login.php");
  session_destroy();
  die();
}

if(!isset($_POST['editor'])) {
  header("Location: cms.php");
  session_destroy();
  die();
}

if(strlen($_POST['editor']) < 1) {
  echo "No text recieved!";
  echo "
    <script>
      setTimeout(function(){
          location.href = '../../cms.php';
      }, 3000);
    </script>
  ";
  die();
}

if(!isset($_GET['cid'])) {
  header("Location: cms.php");
  session_destroy();
  die();
}

include("../api/core/database.php");
include("../classes/error.php");

$conn = new Database();
$conn = $conn->getConn();
$allowedTags = "<a><b><i><h2><h3><h4><h5><h6><pre>";

$text = strip_tags($conn->real_escape_string($_POST['editor']), $allowedTags);
$cid = $conn->real_escape_string($_GET['cid']);

# Check if user that updates is user that wrote the post
$result = $conn->query("SELECT aid FROM content WHERE cid = " . $cid);

if($result->num_rows < 1) {
  # Post not found => error
  die();
}

$result = $result->fetch_assoc();

if($result['aid'] != $_SESSION['aid']) {
  $error = new Error("You can only edit your own posts!");
  header("Location: ../../cms.php");
  die();
}


if(isset($_POST['title'])) {
  if(strlen($_POST['title']) < 1) {
    $error = new Error("The title can't be empty!");
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
    $error = new Error("Update failed, please try again!");
    header("Location: ../../cms.php");
    die();
}

if(isset($query1)) {
  if(!$conn->query($query1)) {
    $error = new Error("Update failed, please try again!");
    header("Location: ../../cms.php");
    die();
  }
}

header("Location: ../../cms.php");
die();

?>
