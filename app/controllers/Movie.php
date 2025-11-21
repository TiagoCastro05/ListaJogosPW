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
    $Consoles = $this->model('Consoles');
    $Genres = $this->model('Genres');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $newMovieData = [
        'title' => $_POST['title'],
        'metacritic_rating' => $_POST['metacritic_rating'],
        'release_year' => $_POST['release_year'],
        'game_image' => $_POST['game_image']
      ];
      $info = $Movies::addMovie($newMovieData);
      
      // Obter o ID do jogo inserido
      $jogoId = $info['id'];
      
      // Adicionar consolas se selecionadas
      if (isset($_POST['consoles']) && is_array($_POST['consoles'])) {
        $Movies::addGameConsoles($jogoId, $_POST['consoles']);
      }
      
      // Adicionar géneros se selecionados
      if (isset($_POST['genres']) && is_array($_POST['genres'])) {
        $Movies::addGameGenres($jogoId, $_POST['genres']);
      }

      $data = $Movies::getAllMovies();
      $this->view('movie/index', ['movies' => $data, 'info' => $info, 'type' => 'INSERT']);
    } else {
      $consoles = $Consoles::getAllConsoles();
      $genres = $Genres::getAllGenres();
      $this->view('movie/create', ['consoles' => $consoles, 'genres' => $genres]);
    }
  }

  public function update($id = null) {
    $Movies = $this->model('Movies');
    $Consoles = $this->model('Consoles');
    $Genres = $this->model('Genres');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $updatedMovieData = [
        'title' => $_POST['title'],
        'metacritic_rating' => $_POST['metacritic_rating'],
        'release_year' => $_POST['release_year'],
        'game_image' => $_POST['game_image']
      ];
      $info = $Movies::updateMovie($id, $updatedMovieData);
      
      // Remover consolas e géneros antigos
      $Movies::removeGameConsoles($id);
      $Movies::removeGameGenres($id);
      
      // Adicionar consolas se selecionadas
      if (isset($_POST['consoles']) && is_array($_POST['consoles'])) {
        $Movies::addGameConsoles($id, $_POST['consoles']);
      }
      
      // Adicionar géneros se selecionados
      if (isset($_POST['genres']) && is_array($_POST['genres'])) {
        $Movies::addGameGenres($id, $_POST['genres']);
      }
      
      $data = $Movies::getAllMovies();
      $this->view('movie/index', ['movies' => $data, 'info' => $info, 'type' => 'UPDATE']);
    } else {
      $data = $Movies::findMovieById($id);
      $consoles = $Consoles::getAllConsoles();
      $genres = $Genres::getAllGenres();
      $selectedConsoles = $Movies::getGameConsoles($id);
      $selectedGenres = $Movies::getGameGenres($id);
      $this->view('movie/update', [
        'movie' => $data, 
        'consoles' => $consoles, 
        'genres' => $genres,
        'selectedConsoles' => $selectedConsoles,
        'selectedGenres' => $selectedGenres
      ]);
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