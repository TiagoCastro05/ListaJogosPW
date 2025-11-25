<?php
namespace app\models;
use app\core\Db;

/**
 * Model: Consoles
 * ----------------
 * Fornece métodos relacionados com a tabela `consoles`.
 */
class Consoles {

  /**
  * getAllConsoles()
  * - Retorna um array com todas as consolas (id e console_name).
  */
  public static function getAllConsoles() {
    $conn = new Db();
    $response = $conn->execQuery('SELECT id, console_name FROM consoles');
    return $response;
  }

}
?>
