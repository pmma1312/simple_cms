<?php

if($_SERVER['REQUEST_METHOD'] != "GET") {
  $response = array(
      "code" => 100,
      "error" => "Invalid request method!"
  );
  http_response_code(405);
  echo json_encode($response);
  die();
}

if(!isset($_GET['page']) && !isset($_GET['no_limit'])) {
  $response = array(
    "code" => 101,
    "error" => "GET variable missing!"
  );
  http_response_code(400);
  echo json_encode($response);
  die();
}

if(isset($_GET['page'])) {
  if(strlen($_GET['page']) < 1) {
    $response = array(
      "code" => 103,
      "error" => "GET variable empty!"
    );
    http_response_code(400);
    echo json_encode($response);
    die();
  }
}

header('HTTP/1.1 200 OK');
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");

include("core/database.php");
$conn = new Database();
$conn = $conn->getConn();

if(!isset($_GET['no_limit'])) {
  $page = strip_tags($conn->real_escape_string($_GET['page']));
  $query = "SELECT content.cid, admin.username, content.content, DATE_FORMAT(content.entry_date, '%d.%m.%Y') AS entry_date FROM content JOIN admin ON content.aid = admin.aid ORDER BY content.cid LIMIT 1 OFFSET " . $page;
} else {
  $query = "SELECT content.cid, admin.username, content.content, DATE_FORMAT(content.entry_date, '%d.%m.%Y') AS entry_date FROM content JOIN admin ON content.aid = admin.aid ORDER BY content.cid";
}

$result = $conn->query($query);

if($result->num_rows < 1) {
  $response = array(
    "code" => 102,
    "error" => "No data found!"
  );
  http_response_code(200);
  echo json_encode($response);
  die();
}

http_response_code(200);
echo json_encode($result->fetch_all(MYSQLI_ASSOC));
die();

?>
