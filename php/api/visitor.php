<?php

  if($_SERVER['REQUEST_METHOD'] != "GET" && $_SERVER['REQUEST_METHOD'] != "PUT") {
    $response = array(
        "code" => 100,
        "error" => "Invalid request method!"
    );
    http_response_code(405);
    echo json_encode($response);
    die();
  }

  include("core/database.php");
  $conn = new Database();
  $conn = $conn->getConn();

  if($_SERVER['REQUEST_METHOD'] == "PUT") {

    $query = "INSERT INTO visitors(ip) VALUES('" . $_SERVER['REMOTE_ADDR'] . "')";

    $conn->query($query);

    http_response_code(200);

    die();
  }

  session_start();

  if($_SERVER['REQUEST_METHOD'] == "GET") {

    if(!isset($_SESSION['logged_in'])) {
      $response = array(
          "code" => 100,
          "error" => "Unauthorized access!"
      );
      http_response_code(401);
      echo json_encode($response);
      die();
    }

    $query = "SELECT COUNT(ip) AS visits, COUNT(DISTINCT(ip)) AS visitors_unique FROM visitors";
    $result = $conn->query($query);

    http_response_code(200);
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
    die();
  }

  die();

?>
