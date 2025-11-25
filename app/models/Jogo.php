<?php

namespace app\models;

use app\core\Db;

/**
 * Model: Movies
 * --------------
 * Contém métodos estáticos para operações CRUD sobre a tabela `jogos` e
 * métodos auxiliares para gerir as relações com `consoles` e `genres`.
 *
 * Padrões usados:
 * - Cada método instancia `new Db()` e usa `execQuery` para interagir com a BD.
 * - Os métodos que manipulam relações (jogo_consoles / jogo_genres) iteram
 *   sobre arrays de IDs e inserem/registam conforme necessário.
 */
class Jogo {
  /**
  * Método para obtenção do dataset de todos os jogos
  *
  * @return   array
  */
  public static function getAllJogos() {
    $conn = new Db();
    $response = $conn->execQuery('SELECT id, title, metacritic_rating, release_year, game_image FROM jogos');
    return $response;
  }

  /**
  * Método para a obtenção de um filme pelo id correspondente
  * @param    int     $id   Id. do filme
  *
  * @return   array
  */
  public static function findJogoById(int $id) {
    $conn = new Db();
    $response = $conn->execQuery('SELECT id, title, metacritic_rating, release_year, game_image FROM jogos WHERE id = ?', array('i', array($id)));
    return $response;
  }

  public static function addJogo($data) {
    $conn = new Db();
    $response = $conn->execQuery('INSERT INTO jogos (title, metacritic_rating, release_year, game_image) VALUES (?, ?, ?, ?)', array(
      'ssss',
      array($data['title'], $data['metacritic_rating'], $data['release_year'], $data['game_image'])
    ));
    return $response;
  }

  public static function updateJogo($id, $data) {
    $conn = new Db();
    $response = $conn->execQuery('UPDATE jogos SET title = ?, metacritic_rating = ?, release_year = ?, game_image = ? WHERE id = ?', array(
      'ssssi',
      array($data['title'], $data['metacritic_rating'], $data['release_year'], $data['game_image'], $id)
    ));
    return $response;
  }

  public static function deleteJogo($id) {
    $conn = new Db();
    $response = $conn->execQuery('DELETE FROM jogos WHERE id = ?', array(
      'i', array($id)
    ));
    return $response;
  }

  /**
  * Método para obtenção das consolas associadas a um jogo
  * @param    int     $id   Id. do jogo
  *
  * @return   array
  */
  public static function getJogoConsoles(int $id) {
    $conn = new Db();
    $response = $conn->execQuery('SELECT c.id, c.console_name FROM consoles c INNER JOIN jogo_consoles jc ON c.id = jc.console_id WHERE jc.jogo_id = ?', array('i', array($id)));
    return $response;
  }

  /**
  * Método para obtenção dos géneros associados a um jogo
  * @param    int     $id   Id. do jogo
  *
  * @return   array
  */
  public static function getJogoGenres(int $id) {
    $conn = new Db();
    $response = $conn->execQuery('SELECT g.id, g.genre FROM genres g INNER JOIN jogo_genres jg ON g.id = jg.genre_id WHERE jg.jogo_id = ?', array('i', array($id)));
    return $response;
  }

  /**
  * Método para adicionar consolas a um jogo
  * @param    int     $jogoId      Id. do jogo
  * @param    array   $consoleIds  Array de IDs das consolas
  */
  public static function addJogoConsoles(int $jogoId, array $consoleIds) {
    $conn = new Db();
    foreach ($consoleIds as $consoleId) {
      $conn->execQuery('INSERT INTO jogo_consoles (jogo_id, console_id) VALUES (?, ?)', array('ii', array($jogoId, $consoleId)));
    }
  }

  /**
  * Método para adicionar géneros a um jogo
  * @param    int     $jogoId    Id. do jogo
  * @param    array   $genreIds  Array de IDs dos géneros
  */
  public static function addJogoGenres(int $jogoId, array $genreIds) {
    $conn = new Db();
    foreach ($genreIds as $genreId) {
      $conn->execQuery('INSERT INTO jogo_genres (jogo_id, genre_id) VALUES (?, ?)', array('ii', array($jogoId, $genreId)));
    }
  }

  /**
  * Método para remover todas as consolas de um jogo
  * @param    int     $jogoId   Id. do jogo
  */
  public static function removeJogoConsoles(int $jogoId) {
    $conn = new Db();
    $conn->execQuery('DELETE FROM jogo_consoles WHERE jogo_id = ?', array('i', array($jogoId)));
  }

  /**
  * Método para remover todos os géneros de um jogo
  * @param    int     $jogoId   Id. do jogo
  */
  public static function removeJogoGenres(int $jogoId) {
    $conn = new Db();
    $conn->execQuery('DELETE FROM jogo_genres WHERE jogo_id = ?', array('i', array($jogoId)));
  }

  

}