<!--
  View: jogo/get.php
  -------------------
  Mostra os detalhes de um jogo específico.
  - O controller passa em `$data` as chaves: 'jogos', 'consoles', 'genres'.
  - Se o jogo não existir ($data['jogos'] vazio) apresenta uma mensagem de erro.
  - Mostra a imagem (se existir), metacritic, ano e as listas de consolas e géneros.
-->

<link rel="stylesheet" href="<?php echo $url_alias;?>/assets/css/main.css">

<div class="container">
  <div style="margin-bottom: 20px;">
    <a href="/jogosapp/" class="btn btn-home">🏠 Início</a>
    <a href="<?php echo $url_alias;?>/jogo" class="btn btn-secondary">← Voltar à Lista</a>
  </div>
  
  <?php
  if (count($data['jogos']) == 0) {
  ?>
    <h2>❌ Jogo não encontrado</h2>
    <p>O jogo não existe na nossa base de dados...</p>
  <?php 
  } else {
  ?>
    <h1><?php echo $data['jogos'][0]['title']; ?></h1>
    
    <div class="game-details">
      <?php if (!empty($data['jogos'][0]['game_image'])) { ?>
        <div style="text-align: center;" class="game-image-wrap">
          <img src="<?php echo $data['jogos'][0]['game_image']; ?>" alt="<?php echo $data['jogos'][0]['title']; ?>" style="max-width: 400px; width: 100%;" onerror="handleBrokenImage(this)">
        </div>
      <?php } ?>
      
      <div>
        <strong>🎯 Metacritic:</strong> <?php echo $data['jogos'][0]['metacritic_rating'] ?: 'N/A'; ?>
      </div>

      <div>
        <strong>📅 Ano de Lançamento:</strong> <?php echo $data['jogos'][0]['release_year'] ?: 'N/A'; ?>
      </div>

      <?php if (!empty($data['consoles']) && count($data['consoles']) > 0) { ?>
        <div>
          <strong>🎮 Consolas:</strong> 
          <?php
          $console_names = array_map(function($console) {
            return $console['console_name'];
          }, $data['consoles']);
          echo implode(', ', $console_names);
          ?>
        </div>
      <?php } ?>

      <?php if (!empty($data['genres']) && count($data['genres']) > 0) { ?>
        <div>
          <strong>🎬 Géneros:</strong> 
          <?php
          $genre_names = array_map(function($genre) {
            return $genre['genre'];
          }, $data['genres']);
          echo implode(', ', $genre_names);
          ?>
        </div>
      <?php } ?>
    </div>
  <?php 
  }
  ?>
  
  <div style="margin-top: 30px; text-align: center; display: flex; justify-content: center; gap: 10px;">
    <a href="/jogosapp/" class="btn btn-home">🏠 Início</a>
    <a href="<?php echo $url_alias;?>/jogo" class="btn btn-secondary">← Voltar à Lista</a>
  </div>
</div>
<script>
// Fallback: se a imagem não carregar, esconder a imagem e mostrar uma mensagem amigável
function handleBrokenImage(img) {
  try {
    // evitar múltiplas execuções
    if (img.dataset.brokenHandled) return;
    img.dataset.brokenHandled = '1';

    // esconder a imagem
    img.style.display = 'none';

    // criar mensagem de fallback
    var msg = document.createElement('div');
    msg.textContent = 'Imagem indisponível';
    msg.style.color = '#c0392b';
    msg.style.fontSize = '14px';
    msg.style.marginTop = '10px';
    msg.style.fontWeight = '600';

    // anexar após a imagem
    if (img.parentNode) {
      img.parentNode.appendChild(msg);
    }
  } catch (e) {
    // falhar silenciosamente
    console && console.warn && console.warn('handleBrokenImage error', e);
  }
}
</script>