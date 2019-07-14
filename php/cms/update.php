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
$conn = new Database();
$conn = $conn->getConn();

$text = strip_tags($conn->real_escape_string($_POST['editor']));
$cid = $conn->real_escape_string($_GET['cid']);

$query = "UPDATE content SET content = '" . $text . "' WHERE cid = " . $cid;

if(!$conn->query($query)) {
    echo $conn->error;
    die();
}

header("Location: ../../cms.php");
die();

?>
