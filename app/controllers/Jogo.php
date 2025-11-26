<?php
use app\core\Controller;

/**
 * Controller: Jogo
 * -----------------
 * Responsável por tratar pedidos relacionados com a entidade "Jogo".
 * Segue o padrão comum dos controllers no projecto:
 * - Recebe pedidos (HTTP GET/POST)
 * - Carrega os modelos necessários
 * - Executa operações (listar, criar, actualizar, apagar)
 * - Carrega a view correspondente passando os dados necessários
 *
 * Observação: os métodos usam chamadas estáticas ao model (`Jogo::method()`)
 * quando apropriado.
 */
class Jogo extends Controller {
  /**
   * index()
  * - GET /jogo
  * - Obtém a lista de todos os jogos e invoca a view `jogo/index`.
   * - Recebe do model um array com os jogos e passa-o para a view.
   */
  public function index() {
    // Instancia o model `Jogo` (classe em app/models/Jogo.php)
    $JogoModel = $this->model('Jogo');
    // Obtém todos os jogos usando o método do model
    $data = $JogoModel::getAllJogos();
    // Anexar consolas e géneros a cada jogo para uso na view (filters/data-attrs)
    if (is_array($data)) {
      foreach ($data as $k => $j) {
        if (isset($j['id'])) {
          $data[$k]['consoles'] = $JogoModel::getJogoConsoles($j['id']);
          $data[$k]['genres'] = $JogoModel::getJogoGenres($j['id']);
        } else {
          $data[$k]['consoles'] = [];
          $data[$k]['genres'] = [];
        }
      }
    }
    // também obter listas de consolas e géneros para os filtros
    $Consoles = $this->model('Consoles');
    $Genres = $this->model('Genres');
    $consoles = $Consoles::getAllConsoles();
    $genres = $Genres::getAllGenres();
    /*
    $Jogo = new Jogo();
    $data = $Jogo->getAllJogos();
    ------------------------------------------------------
    $Jogo = "Jogo";
    $data = $Jogo::getAllJogos();
    */
    // Passa os dados para a view usando as chaves 'jogos', 'consoles', 'genres'
    $this->view('jogo/index', ['jogos' => $data, 'consoles' => $consoles, 'genres' => $genres]);
  }

  /**
   * get($id)
  * - GET /jogo/get/{id}
   * - Recupera um jogo pelo id e as relações (consolas e géneros) associadas.
   * - Valida que o id é numérico; caso contrário chama `pageNotFound()`.
   *
   * Parâmetros:
   * - $id: identificador do jogo (int)
   *
   * Comportamento:
  * - Carrega o model `Jogo` e usa os métodos do model para buscar dados.
  * - Passa para a view `jogo/get` um array com chaves: 'jogos', 'consoles', 'genres'.
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
  * - GET /jogo/create -> mostra o formulário de criação
  * - POST /jogo/create -> processa o formulário e insere o novo jogo
   *
   * Fluxo POST:
   * - Lê os campos do formulário via $_POST
  * - Chama `Jogo::addJogo()` para inserir o registo principal
   * - Recupera o id inserido e associa consolas/ géneros com métodos dedicados
   * - Redireciona (na prática: carrega a view index com informação de sucesso)
   *
   * Fluxo GET:
  * - Carrega dados de suporte (listas de consolas e géneros) e mostra a view `jogo/create`.
   */
  public function create() {
    $JogoModel = $this->model('Jogo');
    $Consoles = $this->model('Consoles');
    $Genres = $this->model('Genres');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $newJogoData = [
        'title' => isset($_POST['title']) ? trim($_POST['title']) : '',
        'metacritic_rating' => isset($_POST['metacritic_rating']) ? trim($_POST['metacritic_rating']) : '',
        'release_year' => isset($_POST['release_year']) ? trim($_POST['release_year']) : '',
        'game_image' => isset($_POST['game_image']) ? trim($_POST['game_image']) : ''
      ];

      // Validação server-side dos ranges
      $errors = [];
      if ($newJogoData['metacritic_rating'] !== '') {
        if (!is_numeric($newJogoData['metacritic_rating']) || $newJogoData['metacritic_rating'] < 0 || $newJogoData['metacritic_rating'] > 100) {
          $errors[] = 'Metacritic rating deve ser um número entre 0 e 100.';
        }
      }
      if ($newJogoData['release_year'] !== '') {
        if (!ctype_digit($newJogoData['release_year']) || (int)$newJogoData['release_year'] < 1900 || (int)$newJogoData['release_year'] > 2080) {
          $errors[] = 'Ano de lançamento deve ser um inteiro entre 1900 e 2080.';
        }
      }

      if (count($errors) > 0) {
        // Recarregar os dados de suporte e mostrar erros
        $consoles = $Consoles::getAllConsoles();
        $genres = $Genres::getAllGenres();
        $this->view('jogo/create', ['consoles' => $consoles, 'genres' => $genres, 'errors' => $errors, 'old' => $newJogoData]);
        return;
      }

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
  * - GET /jogo/update/{id} -> mostra formulário de edição com dados preenchidos
  * - POST /jogo/update/{id} -> atualiza os dados do jogo
   *
   * Fluxo POST:
   * - Lê os campos do formulário
  * - Chama `Jogo::updateJogo()` para actualizar o registo
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
        'title' => isset($_POST['title']) ? trim($_POST['title']) : '',
        'metacritic_rating' => isset($_POST['metacritic_rating']) ? trim($_POST['metacritic_rating']) : '',
        'release_year' => isset($_POST['release_year']) ? trim($_POST['release_year']) : '',
        'game_image' => isset($_POST['game_image']) ? trim($_POST['game_image']) : ''
      ];

      // Validação server-side dos ranges
      $errors = [];
      if ($updatedJogoData['metacritic_rating'] !== '') {
        if (!is_numeric($updatedJogoData['metacritic_rating']) || $updatedJogoData['metacritic_rating'] < 0 || $updatedJogoData['metacritic_rating'] > 100) {
          $errors[] = 'Metacritic rating deve ser um número entre 0 e 100.';
        }
      }
      if ($updatedJogoData['release_year'] !== '') {
        if (!ctype_digit($updatedJogoData['release_year']) || (int)$updatedJogoData['release_year'] < 1900 || (int)$updatedJogoData['release_year'] > 2080) {
          $errors[] = 'Ano de lançamento deve ser um inteiro entre 1900 e 2080.';
        }
      }

      if (count($errors) > 0) {
        // Recarregar dados para o formulário de edição mantendo os valores submetidos
        $consoles = $Consoles::getAllConsoles();
        $genres = $Genres::getAllGenres();
        $selectedConsoles = isset($_POST['consoles']) && is_array($_POST['consoles']) ? $_POST['consoles'] : [];
        $selectedGenres = isset($_POST['genres']) && is_array($_POST['genres']) ? $_POST['genres'] : [];
        // For compatibility the view expects 'jogo' as an array with index 0
        $this->view('jogo/update', [
          'jogo' => [0 => $updatedJogoData],
          'consoles' => $consoles,
          'genres' => $genres,
          'selectedConsoles' => $selectedConsoles,
          'selectedGenres' => $selectedGenres,
          'errors' => $errors
        ]);
        return;
      }

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
  * - GET /jogo/delete/{id}
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