<?php
namespace app\models;
use app\core\Db;

class Consoles {

  public static function getAllConsoles() {
    $conn = new Db();
    $response = $conn->execQuery('SELECT id, console_name FROM consoles');
    return $response;
  }

}
?>
