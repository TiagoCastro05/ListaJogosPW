<?php
/**
 * View: Acerca de Nós (About)
 * ---------------------------
 * Objetivo: apresentar os autores do projecto e uma breve descrição técnica.
 * Este ficheiro é uma view simples que é incluída pelo layout da aplicação.
 *
 * Variáveis esperadas (definidas externamente):
 * - $url_alias : string com o base URL da aplicação (usado para montar links/paths).
 *
 * Nota: esta view contém apenas marcação HTML e pequenas expressões PHP
 * para criar caminhos relativos. Não deve executar lógica de negócio.
 */
?>

<!-- Incluir o CSS principal da aplicação. -->
<link rel="stylesheet" href="<?php echo $url_alias;?>/assets/css/main.css">

<!--
  Secção principal: container com o conteúdo da página "Acerca de Nós".
  Estrutura:
  - Cabeçalho (h1)
  - Lista de autores
  - Descrição do projecto
  - Nota/observação para editores
  - Botão/link de retorno para a listagem de jogos
-->

<div class="container">
  <!-- Título da página -->
  <h1>Acerca de Nós</h1>

  <!--
    Lista de autores.
    Cada <li> contém o nome e, opcionalmente, um identificador/numero.
    Edita estes valores diretamente para actualizar os autores.
  -->
  <p>Esta aplicação foi desenvolvida por:</p>

  <ul>
    <li><strong>Autor 1:</strong> Tiago Alexandre Quesado Castro Nº 31456</li>
    <li><strong>Autor 2:</strong> Tomás Franco Amorim Nº 31371</li>
  </ul>

  <!--
    Descrição do projecto:
    - Explica, em poucas linhas, o que a aplicação faz e a tecnologia usada.
    - Referimos explicitamente o ficheiro CSS principal para que futuros
      editores saibam onde colocar estilos.
  -->
  <h3>Descrição</h3>
  <p>
    Esta aplicação é uma lista de jogos construída em PHP seguindo o
    padrão MVC. Permite listar, pesquisar, criar, editar e eliminar jogos,
    associá-los a consolas e géneros, e ver detalhes individuais.
  </p>

  <div style="margin-top: 20px;">
    <!--
      Botão de regresso:
      - Usa $url_alias para construir a URL base.
      - Classe Bootstrap `btn btn-secondary` para aparência consistente.
    -->
    <a href="<?php echo $url_alias;?>/jogo" class="btn btn-secondary">← Voltar à Lista</a>
  </div>
</div>

<!--
  Observação sobre as tags de fecho: o layout que inclui esta view pode
  já ter estruturas HTML adicionais (por exemplo, `<main>`, `<div>` wrappers).
  Mantemos aqui apenas o conteúdo específico da view; não fechemos ou
  dupliquemos wrappers do layout para evitar problemas de marcação.
-->
