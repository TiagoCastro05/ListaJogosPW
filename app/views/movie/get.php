<link rel="stylesheet" href="<?php echo $url_alias;?>/assets/css/main.css">

<div class="container">
  <div style="margin-bottom: 20px;">
    <a href="/jogosapp/" class="btn btn-home">🏠 Início</a>
    <a href="<?php echo $url_alias;?>/movie" class="btn btn-secondary">← Voltar à Lista</a>
  </div>
  
  <?php
  if (count($data['movies']) == 0) {
  ?>
    <h2>❌ Jogo não encontrado</h2>
    <p>O jogo não existe na nossa base de dados...</p>
  <?php 
  } else {
  ?>
    <h1><?php echo $data['movies'][0]['title']; ?></h1>
    
    <div class="game-details">
      <?php if (!empty($data['movies'][0]['game_image'])) { ?>
        <div style="text-align: center;">
          <img src="<?php echo $data['movies'][0]['game_image']; ?>" alt="<?php echo $data['movies'][0]['title']; ?>" style="max-width: 400px; width: 100%;">
        </div>
      <?php } ?>
      
      <div>
        <strong>🎯 Metacritic:</strong> <?php echo $data['movies'][0]['metacritic_rating'] ?: 'N/A'; ?>
      </div>

      <div>
        <strong>📅 Ano de Lançamento:</strong> <?php echo $data['movies'][0]['release_year'] ?: 'N/A'; ?>
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
    <a href="<?php echo $url_alias;?>/movie" class="btn btn-secondary">← Voltar à Lista</a>
  </div>
</div>