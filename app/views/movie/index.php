<link rel="stylesheet" href="<?php echo $url_alias;?>/assets/css/main.css">

<div class="container">
  <h1>🎮 Lista de Jogos</h1>
  
  <div style="text-align: center; margin-bottom: 30px;">
    <a href="<?php echo $url_alias;?>/movie/create" class="btn">➕ Adicionar Novo Jogo</a>
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

  <ul>
    <?php foreach ($data['movies'] as $movie) { ?>
      <li>
        <strong><?php echo $movie['title']; ?></strong>
        <div>
          <a href="<?php echo $url_alias;?>/movie/get/<?php echo $movie['id'];?>">Ver +</a>
          <a href="<?php echo $url_alias;?>/movie/update/<?php echo $movie['id'];?>">Editar</a>
          <a href="<?php echo $url_alias;?>/movie/delete/<?php echo $movie['id'];?>" onclick="return confirm('Tem a certeza que deseja eliminar este jogo?')">Eliminar</a>
        </div>
      </li>
    <?php } ?>
  </ul>
</div>