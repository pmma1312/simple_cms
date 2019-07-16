<?php

  session_start();

  if(!isset($_SESSION['logged_in'])) {
    header("Location: ../../login.php");
    session_destroy();
    die();
  }

  if(!isset($_POST['username'])) {
    echo "<script>alert('Username is not set!');</script>";
    header("Location: ../../settings.php");
    die();
  }

  include("../api/core/database.php");
  $conn = new Database();
  $conn = $conn->getConn();

  $username = htmlspecialchars(strip_tags($conn->real_escape_string($_POST['username'])));

  $query = "SELECT * FROM admin WHERE username = '" . $username . "'";
  $result = $conn->query($query);

  if($result->num_rows > 0) {
    echo "<script>alert('User with this name exists already!');</script>";
    header("Location: ../../settings.php");
    die();
  }

  $password = password_hash("admin", PASSWORD_ARGON2I);

  $query = "INSERT INTO admin(username, password, profile_pic) VALUES('" . $username . "', '" . $password . "', 'img/admin/default.png')";

  if(!$conn->query($query)) {
    echo "<script>alert('Adding the user failed!');</script>";
    header("Location: ../../settings.php");
    die();
  }

  header("Location: ../../settings.php");
  die();

?>
