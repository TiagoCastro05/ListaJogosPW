<!doctype html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Acerca de Nós - Jogos App</title>
    <link rel="stylesheet" href="<?php echo $url_alias;?>/assets/css/main.css">
</head>
<body>

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
    associá-los a consolas e géneros e ver detalhes individuais.
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
</body>
</html>


