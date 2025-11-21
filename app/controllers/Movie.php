<?php
use app\core\Controller;
class Movie extends Controller {
  /**
  * Invocação da view index.php
  */
  public function index() {
    $Movies = $this->model('Movies'); // é retornado o model Movies()
    $data = $Movies::getAllMovies();
    /*
    $Movies = new Movies();
    $data = $Movies->getAllMovies();
    ------------------------------------------------------
    $Movies = "Movies";
    $data = $Movies::getAllMovies();
    */
    $this->view('movie/index', ['movies' => $data]);
  }

  /**
  * Invocação da view get.php
  *
  * @param  int   $id   Id. movie
  */
  public function get($id = null) {
    if (is_numeric($id)) {
      $Movies = $this->model('Movies');
      $data = $Movies::findMovieById($id);
      $consoles = $Movies::getGameConsoles($id);
      $genres = $Movies::getGameGenres($id);
      $this->view('movie/get', ['movies' => $data, 'consoles' => $consoles, 'genres' => $genres]);
    } else {
       $this->pageNotFound();
    }
  }

  public function create() {
    $Movies = $this->model('Movies');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $newMovieData = [
        'title' => $_POST['title'],
        'metacritic_rating' => $_POST['metacritic_rating'],
        'release_year' => $_POST['release_year'],
        'game_image' => $_POST['game_image']
      ];
      $info = $Movies::addMovie($newMovieData);

      $data = $Movies::getAllMovies();
      $this->view('movie/index', ['movies' => $data, 'info' => $info, 'type' => 'INSERT']);
    } else {
      $this->view('movie/create');
    }
  }

  public function update($id = null) {
    $Movies = $this->model('Movies');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $updatedMovieData = [
        'title' => $_POST['title'],
        'metacritic_rating' => $_POST['metacritic_rating'],
        'release_year' => $_POST['release_year'],
        'game_image' => $_POST['game_image']
      ];
      $info = $Movies::updateMovie($id, $updatedMovieData);
      
      $data = $Movies::getAllMovies();
      $this->view('movie/index', ['movies' => $data, 'info' => $info, 'type' => 'UPDATE']);
    } else {
      $data = $Movies::findMovieById($id);
      $this->view('movie/update', ['movie' => $data]);
    }
  }

  public function delete($id = null) {
    if (is_numeric($id)) {
      $Movies = $this->model('Movies');
      $info = $Movies::deleteMovie($id);

      $data = $Movies::getAllMovies();
      $this->view('movie/index', ['movies' => $data, 'info' => $info, 'type' => 'DELETE']);
    } else {
      $this->pageNotFound();
    }
  }
}

// :: Scope Resolution Operator
// Utilizado para acesso às propriedades e métodos das classes
?>