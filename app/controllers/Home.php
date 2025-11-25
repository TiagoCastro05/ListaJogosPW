<?php
use app\core\Controller;

class Home extends Controller {
  // invocação da view index.php de /home
  public function index() {
    $this->view('home/index');
  }

  // página "Acerca de Nós"
  public function about() {
    // se quiseres passar dados aos autores, envia um array em segundo argumento
    $this->view('home/about');
  }

}

?>