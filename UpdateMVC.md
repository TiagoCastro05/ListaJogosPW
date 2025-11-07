# **Passos para atualização do MVC**
_Última atualização do doc. 02.Out.2025_

---

Descrição do processo para atualizar a aplicação MVC que, até ao momento, apenas faz listagem de informação, isto é, apenas dá resposta ao _**R**ead_ do **CRUD** pretendido.

# Passos da atualização

> Deve haver um particular cuidado com as rotas nas hiperligações.

1. Atualização do **Controller** `Movie.php`
    - `public function create() `
    - `public function update($id = null)`
    - `public function delete($id = null) `

1. Atualização do **Model** `Movies.php`
    - `public static function addMovie($data)` 
    - `public static function updateMovie($id, $data) `
    - `public static function deleteMovie($id)`

1. Criação do **Model** `Genres.php`
    -  `public static function getAllGenres() `

1. Criação de **Views**
    - View para criar filme (`create.php`)
    - View para editar/atualizar filme (`update.php`)

1. Atualizar listagem de filmes para as novas funcionalidades
    - Novo Filme
    - Editar filme
    - Eliminar filme  
    _Deve ser garantida que as operações acima dão retorno, do resultado de execução, ao utilizador._

1. Atualizar em `core\Db.php`
    - `public function execQuery(string $sql, array $parameters = [])`  
    Para suportar operações de `INSERT`, `UPDATE` e `DELETE`.

1. Outras atualizações 
    - Rever estrutura de `assets` para suporte a ficheiros externos, tais como CSS e JS;
    - Se necessário e se assim for pretendido, fazer inclusão de ficheiros no ficheiro `/index.php`. A inclusão neste ponto permite a aplicação de formatações e/ou ficheiros de script globalmente à aplicação;
    - Alternativamente, os ficheiros podem ser incluídos nas _views_ que deles necessitem; 
 
        Exemplo de inclusão:
        ```html
        <link rel="stylesheet" href="/moviesappf1/assets/css/main.css">
        ```

1. _Como estamos em ambiente de desenvolvimento e cada um de nós tem um **alias** configurado, há uma variável, no exemplo disponibilizado no Moodle, para a qual poderá ser necessária edição_: 

    Em `\app\core\Controller.php`

    ```php
    public function view(string $view, $data = []) {
        $url_alias = '/moviesappf1';
        require 'app/views/' . $view . '.php';
    }
    ```

    A variável `$url_alias` servirá de prefixo para todas as rotas utilizadas. Deverá ser definida de acordo com o _alias_ definido para a aplicação.

---
_José Viana | josev@estg.ipvc.pt_