<?php
use app\core\Controller;

/**
 * Home Controller
 *
 * Responsável por renderizar as views da página inicial.
 * As ações/métodos deste controlador seguem o padrão do framework MVC usado
 * no projeto: cada método invoca `$this->view()` com o caminho da view.
 */
class Home extends Controller {
  /**
+   * Página inicial (home/index)
+   *
+   * Exibe a view principal do site. Não recebe parâmetros e não faz lógica
+   * adicional — delega totalmente para a view.
+   */
  public function index() {
    $this->view('home/index');
  }

  /**
   * Página "Acerca de Nós" (home/about)
   *
   * Exibe informação sobre os autores e o projecto. Se no futuro for
   * necessário passar dados (por exemplo um array com os autores), basta
   * fornecer um segundo argumento a `$this->view('home/about', $data)`.
   */
  public function about() {
    // Chama a view `app/views/home/about.php`
    $this->view('home/about');
  }

}

?>