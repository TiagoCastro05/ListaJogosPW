<?php
// debug
// print_r($data);

// Criar arrays de IDs selecionados para facilitar a verificação no template
$selectedConsoleIds = array_map(function($c) { return $c['id']; }, $data['selectedConsoles']);
$selectedGenreIds = array_map(function($g) { return $g['id']; }, $data['selectedGenres']);
?>

<!--
  View: jogo/update.php
  ----------------------
  Formulário de edição de um jogo.
  - O controller (`Jogo::update`) passa em `$data`:
    - 'jogo' => dados do jogo
    - 'consoles' => lista de consolas
    - 'genres' => lista de géneros
    - 'selectedConsoles' / 'selectedGenres' => relações já associadas ao jogo
  - O template marca os checkboxes correspondentes através dos arrays de ids criados acima.
-->

<link rel="stylesheet" href="<?php echo $url_alias;?>/assets/css/main.css">

<div class="container">
  <div style="margin-bottom: 20px;">
    <a href="/jogosapp/" class="btn btn-home">🏠 Início</a>
    <a href="<?php echo $url_alias;?>/jogo" class="btn btn-secondary">← Voltar à Lista</a>
  </div>
  
  <h2>✏️ Editar Jogo</h2>
  
  <form action="<?php echo $url_alias;?>/jogo/update/<?php echo $data['jogo'][0]['id'];?>" method="POST">
    <label for="title">Título: *</label>
    <input type="text" id="title" name="title" value="<?php echo $data['jogo'][0]['title']; ?>" required>

    <label for="metacritic_rating">Metacritic Rating (0-100):</label>
    <input type="number" id="metacritic_rating" name="metacritic_rating" min="0" max="100" step="1" value="<?php echo isset($data['jogo'][0]['metacritic_rating']) ? htmlspecialchars($data['jogo'][0]['metacritic_rating']) : ''; ?>">
    <div id="metacritic-error" style="color: red; font-size:12px; display:none;">Introduza um valor entre 0 e 100</div>

    <label for="release_year">Ano de Lançamento (1900-2080):</label>
    <input type="number" id="release_year" name="release_year" min="1900" max="2080" step="1" value="<?php echo isset($data['jogo'][0]['release_year']) ? htmlspecialchars($data['jogo'][0]['release_year']) : ''; ?>">
    <div id="year-error" style="color: red; font-size:12px; display:none;">Introduza um ano entre 1900 e 2080</div>

    <label for="game_image">URL da Imagem:</label>
    <input type="text" id="game_image" name="game_image" value="<?php echo $data['jogo'][0]['game_image']; ?>">

    <label>Consolas: <span style="color: red;">*</span></label>
    <div class="custom-dropdown">
      <div class="dropdown-button" onclick="toggleDropdown('consoles-dropdown')">
        <span id="consoles-selected">Selecione as consolas</span>
      </div>
      <div id="consoles-dropdown" class="dropdown-content">
        <?php foreach ($data['consoles'] as $console) { 
          $isChecked = in_array($console['id'], $selectedConsoleIds) ? 'checked' : '';
        ?>
          <div class="dropdown-item">
            <input type="checkbox" name="consoles[]" value="<?php echo $console['id']; ?>" id="console_<?php echo $console['id']; ?>" <?php echo $isChecked; ?> onchange="updateSelectedText('consoles')">
            <label for="console_<?php echo $console['id']; ?>"><?php echo $console['console_name']; ?></label>
          </div>
        <?php } ?>
      </div>
    </div>
    <div id="consoles-error" style="color: red; font-size: 12px; margin-bottom: 15px; display: none;">Selecione pelo menos uma consola</div>

    <label>Géneros: <span style="color: red;">*</span></label>
    <div class="custom-dropdown">
      <div class="dropdown-button" onclick="toggleDropdown('genres-dropdown')">
        <span id="genres-selected">Selecione os géneros</span>
      </div>
      <div id="genres-dropdown" class="dropdown-content">
        <?php foreach ($data['genres'] as $genre) { 
          $isChecked = in_array($genre['id'], $selectedGenreIds) ? 'checked' : '';
        ?>
          <div class="dropdown-item">
            <input type="checkbox" name="genres[]" value="<?php echo $genre['id']; ?>" id="genre_<?php echo $genre['id']; ?>" <?php echo $isChecked; ?> onchange="updateSelectedText('genres')">
            <label for="genre_<?php echo $genre['id']; ?>"><?php echo $genre['genre']; ?></label>
          </div>
        <?php } ?>
      </div>
    </div>
    <div id="genres-error" style="color: red; font-size: 12px; margin-bottom: 15px; display: none;">Selecione pelo menos um género</div>

    <?php if (isset($data['errors']) && count($data['errors']) > 0) { ?>
      <div style="color: red; margin-bottom: 10px;">
        <?php foreach ($data['errors'] as $err) { echo '<div>'.$err.'</div>'; } ?>
      </div>
    <?php } ?>

    <div style="display: flex; gap: 10px; margin-top: 20px;">
      <button type="submit" class="btn btn-warning" onclick="return validateForm()">✅ Atualizar Jogo</button>
      <a href="<?php echo $url_alias;?>/jogo" class="btn btn-secondary">❌ Cancelar</a>
    </div>
  </form>
</div>

<script>
/**
 * Toggle do dropdown (consoles/genres)
 */
function toggleDropdown(id) {
  var dropdown = document.getElementById(id);
  dropdown.classList.toggle('show');
}

/**
 * updateSelectedText(type)
 * - Actualiza o texto do botão do dropdown com as opções seleccionadas.
 */
function updateSelectedText(type) {
  var checkboxes = document.querySelectorAll('input[name="' + type + '[]"]');
  var selected = [];
  checkboxes.forEach(function(checkbox) {
    if (checkbox.checked) {
      selected.push(checkbox.nextElementSibling.textContent);
    }
  });
  var text = selected.length > 0 ? selected.join(', ') : 'Selecione os ' + type;
  document.getElementById(type + '-selected').textContent = text;
  
  // Esconder mensagem de erro se seleccionado
  if (selected.length > 0) {
    document.getElementById(type + '-error').style.display = 'none';
  }
}

/**
 * validateForm()
 * - Assegura que existe pelo menos uma consola e um género antes de actualizar.
 */
function validateForm() {
  var consolesCheckboxes = document.querySelectorAll('input[name="consoles[]"]:checked');
  var genresCheckboxes = document.querySelectorAll('input[name="genres[]"]:checked');
  
  var isValid = true;
  
  // Validar consolas
  if (consolesCheckboxes.length === 0) {
    document.getElementById('consoles-error').style.display = 'block';
    isValid = false;
  } else {
    document.getElementById('consoles-error').style.display = 'none';
  }
  
  // Validar géneros
  if (genresCheckboxes.length === 0) {
    document.getElementById('genres-error').style.display = 'block';
    isValid = false;
  } else {
    document.getElementById('genres-error').style.display = 'none';
  }
  
  // Validar Metacritic
  var metField = document.getElementById('metacritic_rating');
  var metVal = metField.value.trim();
  if (metVal !== '') {
    var metNum = parseFloat(metVal);
    if (isNaN(metNum) || metNum < 0 || metNum > 100) {
      document.getElementById('metacritic-error').style.display = 'block';
      isValid = false;
    } else {
      document.getElementById('metacritic-error').style.display = 'none';
    }
  } else {
    document.getElementById('metacritic-error').style.display = 'none';
  }

  // Validar Ano
  var yearField = document.getElementById('release_year');
  var yearVal = yearField.value.trim();
  if (yearVal !== '') {
    var yearNum = parseInt(yearVal, 10);
    if (isNaN(yearNum) || yearNum < 1900 || yearNum > 2080) {
      document.getElementById('year-error').style.display = 'block';
      isValid = false;
    } else {
      document.getElementById('year-error').style.display = 'none';
    }
  } else {
    document.getElementById('year-error').style.display = 'none';
  }
  
  return isValid;
}

// Inicializar texto seleccionado ao carregar
window.onload = function() {
  updateSelectedText('consoles');
  updateSelectedText('genres');
};

// Fechar dropdown ao clicar fora
window.onclick = function(event) {
  if (!event.target.matches('.dropdown-button') && !event.target.matches('.dropdown-button span') && !event.target.closest('.dropdown-content')) {
    var dropdowns = document.getElementsByClassName('dropdown-content');
    for (var i = 0; i < dropdowns.length; i++) {
      dropdowns[i].classList.remove('show');
    }
  }
}
</script>
<a href="<?php echo $url_alias;?>/jogo">Voltar</a>
