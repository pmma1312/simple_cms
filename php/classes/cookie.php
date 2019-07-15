<?php

/*
  This class is here to make cookie creation easier
*/

class Cookie {

  private $name;
  private $value;
  private $expirationTime;

  public function setName($name) { # Function which sets the cookie name
    $this->name = $name;
  }

  public function setExpirationTime($time, $type) { # Set the expiration time => Expects value in unit that $type specifies, $type is => s; m; h; d;
    $availableTypes    = array("s", "m", "h", "d"); # s => seconds; m => minutes; h => hours; d => days
    $calculationValues = array(0, 60, 3600, 86400);
    $calculationValue  = null;

    for($i = 0; $i < sizeof($availableTypes); $i++) { # Check which type we're dealing with
      if($availableTypes[$i] == $type) {
        $calculationValue = $calculationValues[$i];
      }
    }

    if(!$calculationValue == null) {
      $this->expirationTime = time() * $calculationValue;
    } else {
      $this->expirationTime = time(); # Should propably trigger an error
    }
  }

  public function setValue($value) {
    $this->value = $value;
  }

  public function setCookie() { # Function which sets the cookie
    setcookie($this->name, $this->value, $this->expirationTime, "/");
  }

}

?>
