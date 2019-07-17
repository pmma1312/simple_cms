<?php

class mySuccess {

  private $successText;

  public function __construct($successText) {
    include("cookie.php");

    $this->successText = $successText;

    $cookie = new Cookie();
    $cookie->setName("success");
    $cookie->setValue($this->successText);
    $cookie->setExpirationTime(2, "m");
    $cookie->setCookie();
  }

}

?>
