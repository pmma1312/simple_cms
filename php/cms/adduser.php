<?php

  session_start();

  include("../classes/userMessage.php");

  if(!isset($_SESSION['logged_in'])) {
    $error = new userMessage("Unauthorized access.", "error");
    header("Location: ../../login.php");
    session_destroy();
    die();
  }

  if(!isset($_POST['username'])) {
    $error = new userMessage("Username is not set!", "error");
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
    $error = new userMessage("User with this name exists already!", "error");
    header("Location: ../../settings.php");
    die();
  }

  $password = password_hash("admin", PASSWORD_ARGON2I);

  $query = "INSERT INTO admin(username, password, profile_pic) VALUES('" . $username . "', '" . $password . "', 'img/admin/default.png')";

  if(!$conn->query($query)) {
    $error = new userMessage("Adding the user failed!", "error");
    header("Location: ../../settings.php");
    die();
  }

  $success = new userMessage("Successfully added user " . $username, "success");

  header("Location: ../../settings.php");
  die();

?>
