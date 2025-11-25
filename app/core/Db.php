<?php
//======================================================================
// namespace:
// Numa definição mais ampla os namespaces são uma forma de encapsulamento de itens.
// Os namespaces em PHP são uma forma de encapsulamento de itens.
// Resolve o problema de colisões:
// _ dentro de um mesmo projeto (de nomes de classes, funções e constantes)
// _ após a importação de bibliotecas/código de "terceiros" 
//   (de nomes de classes, funções e constantes)
//======================================================================
namespace app\core;
use mysqli;

/**
 * Class Db
 * --------
 * Pequeno wrapper para a extensão mysqli que fornece um método genérico
 * `execQuery` para executar queries parametrizadas (prepared statements).
 *
 * Observações importantes:
 * - A implementação atual tem algumas regras específicas para tratar SELECT,
 *   INSERT, UPDATE e DELETE de forma diferente (por exemplo, devolve o registo
 *   inserido após um INSERT se for uma tabela de jogos).
 * - Em aplicações maiores é recomendável usar uma camada de abstração mais
 *   robusta (PDO com tratamento de erros/transactions ou um ORM).
 */
class Db {
  private $DBServer;
  private $DBUser;
  private $DBPass;
  private $DBName;

  private $conn;

  public function __construct() {
    $this->DBServer = 'localhost';
    $this->DBUser   = 'root';
    $this->DBPass   = '';
    $this->DBName   = 'jogosdb';
    $this->conn = new mysqli($this->DBServer, $this->DBUser, $this->DBPass, $this->DBName);
    $this->conn->set_charset("utf8");
  }

  /**
  * Método para a definição dos parâmetros para o prepared statement
  * @param  MySQLiStatement   $stmt         query "preparada".
  * @param  array             $parameters   array com tipos e respetivos valores (caso existam)
  */
  /**
  * Bind de parâmetros para prepared statements
  * @param  mysqli_stmt  $stmt        statement preparado
  * @param  array        $parameters  array no formato: [types, values]
  *                                      - types: string com os tipos (ex: 'iss')
  *                                      - values: array com os valores a bindar
  */
  private function setParameters($stmt, array $parameters) {
    if (count($parameters)) {
      $types = $parameters[0];
      $values = $parameters[1];
      $stmt->bind_param($types, ...$values); // *1 - Argument unpacking (splat)
    }
  }

  /**
  * Método para a execução do SQL
  * @param  string   $sql         instrução SQL
  * @param  array    $parameters  array de parâmetros
  *
  * @return array    $response    dataset
  */
  
  // Nota: a implementação tem regras específicas, ver comentários abaixo.
  /**
  * Executa uma query parametrizada usando prepared statements.
  *
  * Comportamento por tipo de query:
  * - SELECT: executa e devolve array associativo com todas as linhas
  * - INSERT: executa e devolve o registo inserido (quando a tabela for `jogos`)
  *           ou um array com ['id' => lastInsertId]
  * - UPDATE: executa e devolve os dados recebidos em $parameters[1]
  * - DELETE: para relações (jogo_consoles/jogo_genres) devolve true;
  *           para DELETE na tabela `jogos` devolve os dados do registo eliminado
  *           (busca-os antes de apagar)
  *
  * Atenção: esta função assume que o array $parameters tem o formato
  * ['types', ['val1', 'val2', ...]] quando existem parâmetros.
  *
  * @param  string $sql         Instrução SQL (com ? para parâmetros)
  * @param  array  $parameters  Array de parâmetros no formato descrito acima
  * @return mixed  Resultado dependente do tipo de query
  */
  public function execQuery(string $sql, array $parameters = []) {
      $stmt = $this->conn->prepare($sql);
      $this->setParameters($stmt, $parameters);
      
      if (stripos(trim($sql), 'SELECT') === 0) { 
          $stmt->execute();
          $response = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
      } elseif (stripos(trim($sql), 'INSERT') === 0) { 
          $stmt->execute();
          $lastId = $this->conn->insert_id; // ID do registo inserido
          // Apenas buscar dados se for uma inserção na tabela jogos
          if (stripos($sql, 'jogos') !== false && stripos($sql, 'jogo_') === false) {
            $result = $this->execQuery('SELECT * FROM jogos WHERE id = ?', ['i', [$lastId]]); 
            $response = $result[0];
          } else {
            $response = ['id' => $lastId];
          }
      } elseif (stripos(trim($sql), 'UPDATE') === 0) { 
          $stmt->execute();
          $response = $parameters[1]; // devolve os dados enviados para o execQuery (não há necessidade de ir buscar à BD)
      } elseif (stripos(trim($sql), 'DELETE') === 0) {
          // Para DELETE de relações, apenas executar
          if (stripos($sql, 'jogo_consoles') !== false || stripos($sql, 'jogo_genres') !== false) {
            $stmt->execute();
            $response = true;
          } else {
            // Para DELETE de jogos, buscar dados antes de deletar
            $id = $parameters[1][0]; // id do registo para DELETE
            $deletedData = $this->execQuery('SELECT * FROM jogos WHERE id = ?', ['i', [$id]]);
            if (!empty($deletedData)) {
              $response = $deletedData[0];
            } else {
              $response = null;
            }
            $stmt->execute();
          }
      }

      return $response;
  }



  // *1
  // ... Operador splat
  // Uma das funções deste operador é transformar um array em parâmetros separados a passar para
  // determinado método/função (Argument Unpacking)

}