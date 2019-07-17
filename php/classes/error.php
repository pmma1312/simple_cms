<?php

class myError {

  private $errorText;

  public function __construct($errorText) {
    include("cookie.php");

    $this->errorText = $errorText;

    $cookie = new Cookie();
    $cookie->setName("error");
    $cookie->setValue($this->errorText);
    $cookie->setExpirationTime(2, "m");
    $cookie->setCookie();
  }

}

?>
