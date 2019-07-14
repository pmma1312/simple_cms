<?php

class Database {

  private $mysqli;

  public function __construct() {
    # Config
    $host = "127.0.0.1";
    $db = "cms";
    $user = "content";
    $password = "1337";
    $port = 3306;

    try {
      $this->mysqli = new mysqli($host, $user, $password, $db);
    } catch(Exception $e) {
      $response = array(
        "code" => 99,
        "error" => "Database connection failed!"
      );
      http_response_code(500);
      echo json_encode($response);
      die();
    }
  }

  public function getConn() {
    return $this->mysqli;
  }

}

?>
