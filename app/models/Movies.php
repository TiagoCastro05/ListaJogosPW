<?php

namespace app\models;

use app\core\Db;
class Movies {
  /**
  * Método para obtenção do dataset de todos os filmes
  *
  * @return   array
  */
  public static function getAllMovies() {
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
  public static function findMovieById(int $id) {
    $conn = new Db();
    $response = $conn->execQuery('SELECT id, title, metacritic_rating, release_year, game_image FROM jogos WHERE id = ?', array('i', array($id)));
    return $response;
  }

  public static function addMovie($data) {
    $conn = new Db();
    $response = $conn->execQuery('INSERT INTO jogos (title, metacritic_rating, release_year, game_image) VALUES (?, ?, ?, ?)', array(
      'ssss',
      array($data['title'], $data['metacritic_rating'], $data['release_year'], $data['game_image'])
    ));
    return $response;
  }

  public static function updateMovie($id, $data) {
    $conn = new Db();
    $response = $conn->execQuery('UPDATE jogos SET title = ?, metacritic_rating = ?, release_year = ?, game_image = ? WHERE id = ?', array(
      'ssssi',
      array($data['title'], $data['metacritic_rating'], $data['release_year'], $data['game_image'], $id)
    ));
    return $response;
  }

  public static function deleteMovie($id) {
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
  public static function getGameConsoles(int $id) {
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
  public static function getGameGenres(int $id) {
    $conn = new Db();
    $response = $conn->execQuery('SELECT g.id, g.genre FROM genres g INNER JOIN jogo_genres jg ON g.id = jg.genre_id WHERE jg.jogo_id = ?', array('i', array($id)));
    return $response;
  }

  

}