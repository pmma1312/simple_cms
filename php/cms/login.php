<?php

class Login {

  public $aid;

  private $username;
  private $password;
  private $db_password;

  public function __construct($username, $password) {
    $this->username = $username;
    $this->password = $password;
  }

  public function verifyCredentials() {
    $isValid = false;
    if($this->userExists()) {
      if($this->passwordValid()) {
        $isValid = true;
      }
    }
    return $isValid;
  }

  private function userExists() {
    $userExists = false;
    include("php/api/core/database.php");
    $conn = new Database();
    $conn = $conn->getConn();

    $this->username = strip_tags($conn->real_escape_string($this->username));
    $query = "SELECT aid, password FROM admin WHERE username = '" . $this->username . "'";

    $result = $conn->query($query);

    if($result->num_rows == 1) {
      $result = $result->fetch_array(MYSQLI_ASSOC);
      $this->db_password = $result['password'];
      $this->aid = $result['aid'];
      $userExists = true;
    }

    return $userExists;
  }

  private function passwordValid() {
    $isValid = false;
    if(password_verify($this->password, $this->db_password)) {
      $isValid = true;
    }
    return $isValid;
  }

}

?>
