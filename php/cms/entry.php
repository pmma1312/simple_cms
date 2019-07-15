<?php

  session_start();

  if(!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    session_destroy();
    die();
  }

  if(!isset($_POST['editor']) || !isset($_POST['title'])) {
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

  include("../api/core/database.php");
  $conn = new Database();
  $conn = $conn->getConn();

  $text = htmlspecialchars(strip_tags($conn->real_escape_string($_POST['editor'])));
  $title = htmlspecialchars(strip_tags($conn->real_escape_string($_POST['title'])));

  $date = date("Y-m-d");

  $query = "INSERT INTO content(aid, title, content, entry_date) VALUES(" . $_SESSION['aid'] . ", '" . $title . "', '" . $text . "', '" . $date . "')";

  if(!$conn->query($query)) {
    die();
  }

  header("Location: ../../cms.php");
  die();

?>
