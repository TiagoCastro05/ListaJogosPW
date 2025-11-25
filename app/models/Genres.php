<?php
namespace app\models;
use app\core\Db;

/**
 * Model: Genres
 * -------------
 * Métodos para interagir com a tabela `genres`.
 */
class Genres {

  /**
  * getAllGenres()
  * - Retorna um array com todos os géneros (id e genre).
  */
  public static function getAllGenres() {
    $conn = new Db();
    $response = $conn->execQuery('SELECT id, genre FROM genres');
    return $response;
  }

}
?>
