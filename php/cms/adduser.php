<?php

  session_start();

  include("../classes/error.php");

  if(!isset($_SESSION['logged_in'])) {
    $error = new myError("Unauthorized access.");
    header("Location: ../../login.php");
    session_destroy();
    die();
  }

  if(!isset($_POST['username'])) {
    $error = new myError("Username is not set!");
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
    $error = new myError("User with this name exists already!");
    header("Location: ../../settings.php");
    die();
  }

  $password = password_hash("admin", PASSWORD_ARGON2I);

  $query = "INSERT INTO admin(username, password, profile_pic) VALUES('" . $username . "', '" . $password . "', 'img/admin/default.png')";

  if(!$conn->query($query)) {
    $error = new myError("Adding the user failed!");
    header("Location: ../../settings.php");
    die();
  }

  include("../classes/success.php");
  $success = new mySuccess("Successfully added user " . $username);

  header("Location: ../../settings.php");
  die();

?>
