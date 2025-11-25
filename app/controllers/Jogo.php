<?php
use app\core\Controller;

/**
 * Controller: Movie
 * -----------------
 * Responsável por tratar pedidos relacionados com a entidade "Movie" (jogo).
 * Segue o padrão comum dos controllers no projecto:
 * - Recebe pedidos (HTTP GET/POST)
 * - Carrega os modelos necessários
 * - Executa operações (listar, criar, actualizar, apagar)
 * - Carrega a view correspondente passando os dados necessários
 *
 * Observação: os métodos usam chamadas estáticas ao model (`Movies::method()`)
 * porque os models foram implementados com métodos estáticos.
 */
class Jogo extends Controller {
  /**
   * index()
   * - GET /movie
   * - Obtém a lista de todos os jogos e invoca a view `movie/index`.
   * - Recebe do model um array com os jogos e passa-o para a view.
   */
  public function index() {
    // Instancia o model `Jogo` (classe em app/models/Jogo.php)
    $JogoModel = $this->model('Jogo');
    // Obtém todos os jogos usando o método do model
    $data = $JogoModel::getAllJogos();
    /*
    $Movies = new Movies();
    $data = $Movies->getAllMovies();
    ------------------------------------------------------
    $Movies = "Movies";
    $data = $Movies::getAllMovies();
    */
    // Passa os dados para a view usando a chave 'jogos'
    $this->view('jogo/index', ['jogos' => $data]);
  }

  /**
   * get($id)
   * - GET /movie/get/{id}
   * - Recupera um jogo pelo id e as relações (consolas e géneros) associadas.
   * - Valida que o id é numérico; caso contrário chama `pageNotFound()`.
   *
   * Parâmetros:
   * - $id: identificador do jogo (int)
   *
   * Comportamento:
   * - Carrega o model `Movies` e usa os métodos do model para buscar dados.
   * - Passa para a view `movie/get` um array com chaves: 'movies', 'consoles', 'genres'.
   */
  public function get($id = null) {
    if (is_numeric($id)) {
      $JogoModel = $this->model('Jogo');
      $data = $JogoModel::findJogoById($id);
      $consoles = $JogoModel::getJogoConsoles($id);
      $genres = $JogoModel::getJogoGenres($id);
      $this->view('jogo/get', ['jogos' => $data, 'consoles' => $consoles, 'genres' => $genres]);
    } else {
       $this->pageNotFound();
    }
  }

  /**
   * create()
   * - GET /movie/create -> mostra o formulário de criação
   * - POST /movie/create -> processa o formulário e insere o novo jogo
   *
   * Fluxo POST:
   * - Lê os campos do formulário via $_POST
   * - Chama `Movies::addMovie()` para inserir o registo principal
   * - Recupera o id inserido e associa consolas/ géneros com métodos dedicados
   * - Redireciona (na prática: carrega a view index com informação de sucesso)
   *
   * Fluxo GET:
   * - Carrega dados de suporte (listas de consolas e géneros) e mostra a view `movie/create`.
   */
  public function create() {
    $JogoModel = $this->model('Jogo');
    $Consoles = $this->model('Consoles');
    $Genres = $this->model('Genres');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $newJogoData = [
        'title' => $_POST['title'],
        'metacritic_rating' => $_POST['metacritic_rating'],
        'release_year' => $_POST['release_year'],
        'game_image' => $_POST['game_image']
      ];
      $info = $JogoModel::addJogo($newJogoData);
      
      // Obter o ID do jogo inserido
      $jogoId = $info['id'];
      // Adicionar consolas se selecionadas
      if (isset($_POST['consoles']) && is_array($_POST['consoles'])) {
        $JogoModel::addJogoConsoles($jogoId, $_POST['consoles']);
      }
      // Adicionar géneros se selecionados
      if (isset($_POST['genres']) && is_array($_POST['genres'])) {
        $JogoModel::addJogoGenres($jogoId, $_POST['genres']);
      }

      $data = $JogoModel::getAllJogos();
      $this->view('jogo/index', ['jogos' => $data, 'info' => $info, 'type' => 'INSERT']);
    } else {
      $consoles = $Consoles::getAllConsoles();
      $genres = $Genres::getAllGenres();
      $this->view('jogo/create', ['consoles' => $consoles, 'genres' => $genres]);
    }
  }

  /**
   * update($id)
   * - GET /movie/update/{id} -> mostra formulário de edição com dados preenchidos
   * - POST /movie/update/{id} -> atualiza os dados do jogo
   *
   * Fluxo POST:
   * - Lê os campos do formulário
   * - Chama `Movies::updateMovie()` para actualizar o registo
   * - Remove as relações antigas (consolas/genres) e re-insere as selecionadas
   *
   * Fluxo GET:
   * - Busca o jogo e listas de consolas/genres
   * - Passa também as consolas/genres selecionadas para a view para marcar os checkboxes
   */
  public function update($id = null) {
    $JogoModel = $this->model('Jogo');
    $Consoles = $this->model('Consoles');
    $Genres = $this->model('Genres');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $updatedJogoData = [
        'title' => $_POST['title'],
        'metacritic_rating' => $_POST['metacritic_rating'],
        'release_year' => $_POST['release_year'],
        'game_image' => $_POST['game_image']
      ];
      $info = $JogoModel::updateJogo($id, $updatedJogoData);
      
      // Remover consolas e géneros antigos
      $JogoModel::removeJogoConsoles($id);
      $JogoModel::removeJogoGenres($id);
      
      // Adicionar consolas se selecionadas
      if (isset($_POST['consoles']) && is_array($_POST['consoles'])) {
        $JogoModel::addJogoConsoles($id, $_POST['consoles']);
      }
      
      // Adicionar géneros se selecionados
      if (isset($_POST['genres']) && is_array($_POST['genres'])) {
        $JogoModel::addJogoGenres($id, $_POST['genres']);
      }
      
      $data = $JogoModel::getAllJogos();
      $this->view('jogo/index', ['jogos' => $data, 'info' => $info, 'type' => 'UPDATE']);
    } else {
      $data = $JogoModel::findJogoById($id);
      $consoles = $Consoles::getAllConsoles();
      $genres = $Genres::getAllGenres();
      $selectedConsoles = $JogoModel::getJogoConsoles($id);
      $selectedGenres = $JogoModel::getJogoGenres($id);
      $this->view('jogo/update', [
        'jogo' => $data, 
        'consoles' => $consoles, 
        'genres' => $genres,
        'selectedConsoles' => $selectedConsoles,
        'selectedGenres' => $selectedGenres
      ]);
    }
  }

  /**
   * delete($id)
   * - GET /movie/delete/{id}
   * - Valida o id e pede ao model para remover o registo. Depois carrega a
   *   listagem novamente apresentando uma mensagem informativa.
   */
  public function delete($id = null) {
    if (is_numeric($id)) {
      $JogoModel = $this->model('Jogo');
      $info = $JogoModel::deleteJogo($id);

      $data = $JogoModel::getAllJogos();
      $this->view('jogo/index', ['jogos' => $data, 'info' => $info, 'type' => 'DELETE']);
    } else {
      $this->pageNotFound();
    }
  }
}

// :: Scope Resolution Operator
// Utilizado para acesso às propriedades e métodos das classes
?>