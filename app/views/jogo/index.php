<link rel="stylesheet" href="<?php echo $url_alias;?>/assets/css/main.css">

<!--
  View: Lista de Jogos
  --------------------
  Esta view apresenta a listagem de jogos (renderizada a partir de
  `app/controllers/Jogo.php`). Contém:
  - Ações principais (criar, voltar à home)
  - Barra de pesquisa (filtragem no cliente)
  - Lista de resultados (cada item tem ações: ver, editar, apagar)
  - Um link fixo para a página "Acerca de Nós"
-->

<div class="container">
  <h1>🎮 Lista de Jogos</h1>
  
  <!-- Ações rápidas no topo: voltar à home e criar novo jogo -->
  <div class="top-actions">
    <a href="/jogosapp/" class="btn btn-home">🏠 Início</a>
    <a href="<?php echo $url_alias;?>/jogo/create" class="btn btn-success">➕ Adicionar Novo Jogo</a>
  </div>

  <!-- Barra de pesquisa: filtra a lista sem reload usando JavaScript simples -->
  <div class="search-bar">
    <input type="text" id="searchInput" placeholder="🔍 Pesquisar jogos..." onkeyup="searchGames()">
  </div>

  <?php
  // debug
  //print_r($data);

  if (isset($data['info']) && isset($data['type'])) {
    $type = $data['type'];
    switch ($type) {
      case 'INSERT':
        echo '<h3>✅ Jogo "' . $data['info']['title'] . '" inserido com sucesso!</h3>';
        break;
      case 'UPDATE':
        echo '<h3>✅ Informação do jogo "' . $data['info'][0] . '" atualizada com sucesso!</h3>';
        break;
      case 'DELETE':
        echo '<h3>✅ Jogo "' . $data['info']['title'] . '" eliminado com sucesso!</h3>';
        break;
    }
  }
  ?>

  <!-- Lista de jogos: gerada dinamicamente a partir do array `$data['jogos']` -->
  <ul id="gamesList">
    <?php foreach ($data['jogos'] as $jogo) { ?>
      <li class="game-item">
        <strong><?php echo $jogo['title']; ?></strong>
        <div>
          <!-- Ações por jogo:
               - Ver +: mostra a view `jogo/get` com detalhes
               - Editar: redireciona para o formulário de edição
               - Eliminar: faz GET para delete (com confirm no cliente)
          -->
          <a href="<?php echo $url_alias;?>/jogo/get/<?php echo $jogo['id'];?>" class="btn btn-info">Ver +</a>
          <a href="<?php echo $url_alias;?>/jogo/update/<?php echo $jogo['id'];?>" class="btn btn-warning">Editar</a>
          <a href="<?php echo $url_alias;?>/jogo/delete/<?php echo $jogo['id'];?>" class="btn btn-danger" onclick="return confirm('Tem a certeza que deseja eliminar este jogo?')">Eliminar</a>
        </div>
      </li>
    <?php } ?>
  </ul>
  
  <!-- Mensagem quando a pesquisa não retorna resultados -->
  <div id="noResults" style="display: none; text-align: center; padding: 40px; color: #999;">
    <h3>🔍 Nenhum jogo encontrado</h3>
    <p>Tente pesquisar com outros termos</p>
  </div>
</div>

<!--
  Função: searchGames
  -------------------
  Filtra a listagem de jogos no cliente (front-end). Percorre cada item da
  lista, compara o título com o texto introduzido e esconde/exibe os itens
  consoante o resultado. Mostra um bloco "Nenhum jogo encontrado" quando
  apropriado.
-->
<script>
function searchGames() {
  const input = document.getElementById('searchInput');
  const filter = input.value.toLowerCase();
  const gamesList = document.getElementById('gamesList');
  const items = gamesList.getElementsByClassName('game-item');
  let visibleCount = 0;
  
  for (let i = 0; i < items.length; i++) {
    const title = items[i].getElementsByTagName('strong')[0];
    const txtValue = title.textContent || title.innerText;
    
    if (txtValue.toLowerCase().indexOf(filter) > -1) {
      // Mostrar item
      items[i].style.display = '';
      visibleCount++;
    } else {
      // Esconder item
      items[i].style.display = 'none';
    }
  }
  
  // Mostrar/esconder mensagem "nenhum resultado"
  const noResults = document.getElementById('noResults');
  if (visibleCount === 0 && filter !== '') {
    noResults.style.display = 'block';
    gamesList.style.display = 'none';
  } else {
    noResults.style.display = 'none';
    gamesList.style.display = 'block';
  }
}
</script>

<!-- Link fixo inferior direito para página 'Acerca de Nós' (botão azul) -->
<div style="position: fixed; right: 10px; bottom: 10px; z-index: 999;">
  <a href="<?php echo $url_alias;?>/home/about" class="btn" style="background: #0d6efd; color: #fff; border: 1px solid #0b5ed7; padding: 8px 12px; border-radius: 6px; text-decoration: none;">Acerca de Nós</a>
</div>