<?php
// debug
// print_r($data);

// Criar arrays de IDs selecionados para facilitar a verificação
$selectedConsoleIds = array_map(function($c) { return $c['id']; }, $data['selectedConsoles']);
$selectedGenreIds = array_map(function($g) { return $g['id']; }, $data['selectedGenres']);
?>

<link rel="stylesheet" href="<?php echo $url_alias;?>/assets/css/main.css">

<div class="container">
  <h2>✏️ Editar Jogo</h2>
  
  <form action="<?php echo $url_alias;?>/movie/update/<?php echo $data['movie'][0]['id'];?>" method="POST">
    <label for="title">Título: *</label>
    <input type="text" id="title" name="title" value="<?php echo $data['movie'][0]['title']; ?>" required>

    <label for="metacritic_rating">Metacritic Rating:</label>
    <input type="text" id="metacritic_rating" name="metacritic_rating" value="<?php echo $data['movie'][0]['metacritic_rating']; ?>">

    <label for="release_year">Ano de Lançamento:</label>
    <input type="text" id="release_year" name="release_year" value="<?php echo $data['movie'][0]['release_year']; ?>">

    <label for="game_image">URL da Imagem:</label>
    <input type="text" id="game_image" name="game_image" value="<?php echo $data['movie'][0]['game_image']; ?>">

    <label>Consolas:</label>
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

    <label>Géneros:</label>
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

    <div style="display: flex; gap: 10px; margin-top: 20px;">
      <button type="submit">✅ Atualizar Jogo</button>
      <a href="<?php echo $url_alias;?>/movie" class="btn" style="background: #6c757d;">❌ Cancelar</a>
    </div>
  </form>
</div>

<script>
function toggleDropdown(id) {
  var dropdown = document.getElementById(id);
  dropdown.classList.toggle('show');
}

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
}

// Inicializar texto selecionado ao carregar
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
<a href="<?php echo $url_alias;?>/movie">Voltar</a>
