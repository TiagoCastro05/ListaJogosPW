<link rel="stylesheet" href="<?php echo $url_alias;?>/assets/css/main.css">

<div class="container">
  <h1>🎮 Lista de Jogos</h1>
  
  <div class="top-actions">
    <a href="/jogosapp/" class="btn btn-home">🏠 Início</a>
    <a href="<?php echo $url_alias;?>/movie/create" class="btn btn-success">➕ Adicionar Novo Jogo</a>
  </div>

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

  <ul id="gamesList">
    <?php foreach ($data['movies'] as $movie) { ?>
      <li class="game-item">
        <strong><?php echo $movie['title']; ?></strong>
        <div>
          <a href="<?php echo $url_alias;?>/movie/get/<?php echo $movie['id'];?>" class="btn btn-info">Ver +</a>
          <a href="<?php echo $url_alias;?>/movie/update/<?php echo $movie['id'];?>" class="btn btn-warning">Editar</a>
          <a href="<?php echo $url_alias;?>/movie/delete/<?php echo $movie['id'];?>" class="btn btn-danger" onclick="return confirm('Tem a certeza que deseja eliminar este jogo?')">Eliminar</a>
        </div>
      </li>
    <?php } ?>
  </ul>
  
  <div id="noResults" style="display: none; text-align: center; padding: 40px; color: #999;">
    <h3>🔍 Nenhum jogo encontrado</h3>
    <p>Tente pesquisar com outros termos</p>
  </div>
</div>

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
      items[i].style.display = '';
      visibleCount++;
    } else {
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