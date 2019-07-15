<?php

class File {

  private $type;
  private $name;
  private $tmp_name;
  private $size;
  private $dir;

  public $error;
  public $fullFileName;
  public $insertName;

  public function __construct($file, $conn) {
    $this->type     = $file['type'];
    $this->name     = $conn->real_escape_string(strip_tags(htmlspecialchars($file['name'])));
    $this->tmp_name = $file['tmp_name'];
    $this->size     = $file['size'];
    $this->dir      = "img/admin/";
    $this->error    = null;
  }

  public function checkFile() {
    if(!$this->checkFileType()) {
      $this->error = "Invalid file type! (only jpg, jpeg, png and gif allowed)";
      return false;
    }
    if(!$this->checkFileSize()) {
      $this->error = "Image is too big, please upload a smaller one! Max filesize is 2MB";
      return false;
    }
    $this->checkFileExists();
    $this->insertName = $this->dir . basename($this->name);
    $this->fullFileName = $_SERVER['DOCUMENT_ROOT'] . "/" . $this->dir . basename($this->name);
    return true;
  }

  private function checkFileType() {
    $allowedTypes = array(
                           "image/jpg",
                           "image/jpeg",
                           "image/png",
                           "image/gif"
                         );
    if(!in_array($this->type, $allowedTypes)) {
      return false;
    }
    return true;
  }

  private function checkFileSize() {
    if($this->size < 2048) {
      return false;
    }
    return true;
  }

  private function checkFileExists() {
    $i = 0;
    while(file_exists($_SERVER['DOCUMENT_ROOT'] . "/" . $this->dir . $this->name)) {
      $this->name = $i . $this->name;
      $i += 1;
    }
  }

}

?>
