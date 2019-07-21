<?php

class userMessage {

  private $text;

  public function __construct($text, $type) {
    include("cookie.php");

    $this->text = $text;

    $cookie = new Cookie();
    $cookie->setName($type);
    $cookie->setValue($this->text);
    $cookie->setExpirationTime(2, "m");
    $cookie->setCookie();
  }

}

?>
