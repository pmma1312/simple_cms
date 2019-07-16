<?php

class Database {

  private $mysqli;

  public function __construct() {
    # Config
    define("HOST", "127.0.0.1");
    define("DATABASE", "cms");
    define("USERNAME", "content");
    define("PASSWORD", "1337");

    try {
      $this->mysqli = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
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
