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

  if(strlen($_POST['editor']) < 1 || strlen($_POST['title']) < 1) {
    echo "
      <script>
        alert('No text recieved!');
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
  $allowedTags = "<a><b><i><h2><h3><h4><h5><h6><pre><style>";

  $text = strip_tags($conn->real_escape_string($_POST['editor']), $allowedTags);
  $title = htmlspecialchars(strip_tags($conn->real_escape_string($_POST['title'])));

  $date = date("Y-m-d");

  $query = "INSERT INTO content(aid, title, content, entry_date) VALUES(" . $_SESSION['aid'] . ", '" . $title . "', '" . $text . "', '" . $date . "')";

  if(!$conn->query($query)) {
    die();
  }

  header("Location: ../../cms.php");
  die();

?>
