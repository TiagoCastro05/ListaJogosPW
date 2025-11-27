<!doctype html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Lista de Jogos</title>
    <link rel="stylesheet" href="<?php echo $url_alias;?>/assets/css/main.css">
</head>
<body>

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

  <!-- Filtros (dropdowns): consola, género, ano e metacritic -->
  <?php
    // construir lista de anos disponíveis a partir dos jogos (apenas para referência)
    $years = [];
    if (isset($data['jogos'])) {
      foreach ($data['jogos'] as $jj) {
        if (!empty($jj['release_year'])) $years[] = (int)$jj['release_year'];
      }
    }
    $years = array_values(array_unique($years));
    sort($years);
    // metacritic options (0,10,...,100)
    $metOptions = range(0,100,10);
    // build year options: decades up to 1990s, then year-by-year from 2000 to 2026
    $yearOptions = [];
    // determine decade start: use earliest year if available, else 1900
    $minYear = count($years) ? min($years) : 1900;
    $startDec = floor($minYear/10)*10;
    if ($startDec < 1900) $startDec = 1900;
    // cap the decade range to end at 1990
    for ($dec = $startDec; $dec <= 1990; $dec += 10) {
      $yearOptions[] = ['type' => 'decade', 'value' => $dec, 'label' => $dec . 's'];
    }
    // years from 2000 to 2026
    for ($y = 2000; $y <= 2026; $y++) {
      $yearOptions[] = ['type' => 'year', 'value' => $y, 'label' => (string)$y];
    }
  ?>
  <div class="search-bar" style="display:flex; gap:10px; align-items:center; flex-wrap:wrap; margin-bottom:12px;">
    <input type="text" id="searchInput" placeholder="🔍 Pesquisar jogos..." onkeyup="searchGames()" style="flex:1; min-width:200px;">
    <select id="filterConsole" onchange="searchGames()">
      <option value="">Todas as Consolas</option>
      <?php if (isset($data['consoles'])) { foreach ($data['consoles'] as $c) { echo '<option value="'.$c['id'].'">'.htmlspecialchars($c['console_name']).'</option>'; } } ?>
    </select>
    <select id="filterGenre" onchange="searchGames()">
      <option value="">Todos os Géneros</option>
      <?php if (isset($data['genres'])) { foreach ($data['genres'] as $g) { echo '<option value="'.$g['id'].'">'.htmlspecialchars($g['genre']).'</option>'; } } ?>
    </select>
    <!-- Metacritic single dropdown (acts as minimum threshold) -->
    <select id="filterMet" onchange="searchGames()">
      <option value="">Todos Metacritic</option>
      <?php foreach ($metOptions as $m) { echo '<option value="'.$m.'">'.$m.'</option>'; } ?>
    </select>
    <!-- Year single dropdown (exact match) -->
    <select id="filterYear" onchange="searchGames()">
      <option value="">Todos Anos</option>
      <?php foreach ($yearOptions as $opt) {
        if ($opt['type'] === 'decade') {
          echo '<option value="decade_'.$opt['value'].'">'.htmlspecialchars($opt['label']).'</option>';
        } else {
          echo '<option value="'.$opt['value'].'">'.htmlspecialchars($opt['label']).'</option>';
        }
      } ?>
    </select>
    <button class="btn btn-secondary" onclick="resetFilters(); return false;">Limpar</button>
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
    <?php foreach ($data['jogos'] as $jogo) { 
      // preparar atributos de dados para filtrar no cliente: consoles e genres ids como CSV
      $consoleIds = isset($jogo['consoles']) ? implode(',', array_map(function($c){return $c['id'];}, $jogo['consoles'])) : '';
      $genreIds = isset($jogo['genres']) ? implode(',', array_map(function($g){return $g['id'];}, $jogo['genres'])) : '';
      $met = isset($jogo['metacritic_rating']) ? $jogo['metacritic_rating'] : '';
      $year = isset($jogo['release_year']) ? $jogo['release_year'] : '';
    ?>
      <li class="game-item" data-console-ids="<?php echo $consoleIds;?>" data-genre-ids="<?php echo $genreIds;?>" data-metacritic="<?php echo $met;?>" data-year="<?php echo $year;?>">
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
  const gamesList = document.getElementById('gamesList');
  const items = gamesList.getElementsByClassName('game-item');
  const filterConsole = document.getElementById('filterConsole').value;
  const filterGenre = document.getElementById('filterGenre').value;
  const filterMet = document.getElementById('filterMet').value;
  const filterYear = document.getElementById('filterYear').value;
  const input = document.getElementById('searchInput');
  const searchFilter = input ? input.value.toLowerCase() : '';
  let visibleCount = 0;
  
  for (let i = 0; i < items.length; i++) {
    const title = items[i].getElementsByTagName('strong')[0];
    const txtValue = title.textContent || title.innerText;
    // texto (uses the search input)
    let matchesText = (searchFilter === '' || txtValue.toLowerCase().indexOf(searchFilter) > -1);

    // filtros por console/genre
    let matchesConsole = true;
    if (filterConsole) {
      const consoles = items[i].dataset.consoleIds ? items[i].dataset.consoleIds.split(',') : [];
      matchesConsole = consoles.indexOf(filterConsole) > -1;
    }
    let matchesGenre = true;
    if (filterGenre) {
      const genres = items[i].dataset.genreIds ? items[i].dataset.genreIds.split(',') : [];
      matchesGenre = genres.indexOf(filterGenre) > -1;
    }
    // metacritic single value (acts as minimum threshold)
    let matchesMet = true;
    const itemMet = items[i].dataset.metacritic !== undefined ? items[i].dataset.metacritic : '';
    if (filterMet !== '') {
      let metVal = itemMet === '' ? null : parseFloat(itemMet);
      if (metVal === null) {
        matchesMet = false;
      } else {
        if (metVal < parseFloat(filterMet)) matchesMet = false;
      }
    }

    // year: support decade selection (value like 'decade_1980') or specific year
    let matchesYear = true;
    const itemYear = items[i].dataset.year !== undefined ? items[i].dataset.year : '';
    if (filterYear !== '') {
      let yVal = itemYear === '' ? null : parseInt(itemYear,10);
      if (yVal === null) {
        matchesYear = false;
      } else {
        if (filterYear.indexOf('decade_') === 0) {
          const dec = parseInt(filterYear.split('_')[1], 10);
          if (!(yVal >= dec && yVal <= dec + 9)) matchesYear = false;
        } else {
          if (yVal !== parseInt(filterYear,10)) matchesYear = false;
        }
      }
    }

    if (matchesText && matchesConsole && matchesGenre && matchesMet && matchesYear) {
      items[i].style.display = '';
      visibleCount++;
    } else {
      items[i].style.display = 'none';
    }
  }
  
  // Mostrar/esconder mensagem "nenhum resultado"
  const noResults = document.getElementById('noResults');
  if (visibleCount === 0) {
    noResults.style.display = 'block';
    gamesList.style.display = 'none';
  } else {
    noResults.style.display = 'none';
    gamesList.style.display = 'block';
  }
}

function resetFilters() {
  document.getElementById('filterConsole').value = '';
  document.getElementById('filterGenre').value = '';
    var s = document.getElementById('searchInput'); if (s) s.value = '';
    document.getElementById('filterMet').value = '';
    document.getElementById('filterYear').value = '';
  searchGames();
}
</script>

<!-- Link fixo inferior direito para página 'Acerca de Nós' (botão azul) -->
<div style="position: fixed; right: 10px; bottom: 10px; z-index: 999;">
  <a href="<?php echo $url_alias;?>/home/about" class="btn" style="background: #0d6efd; color: #fff; border: 1px solid #0b5ed7; padding: 8px 12px; border-radius: 6px; text-decoration: none;">Acerca de Nós</a>
</div>
</body>
</html>