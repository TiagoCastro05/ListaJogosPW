<link rel="stylesheet" href="<?php echo $url_alias;?>/assets/css/main.css">

<div class="container">
  <div style="margin-bottom: 20px;">
    <a href="/jogosapp/" class="btn btn-home">🏠 Início</a>
    <a href="<?php echo $url_alias;?>/movie" class="btn btn-secondary">← Voltar à Lista</a>
  </div>
  
  <h2>➕ Criar Novo Jogo</h2>

  <form action="<?php echo $url_alias;?>/movie/create" method="POST">
    <label for="title">Título: *</label>
    <input type="text" id="title" name="title" required placeholder="Ex: The Legend of Zelda">

    <label for="metacritic_rating">Metacritic Rating:</label>
    <input type="text" id="metacritic_rating" name="metacritic_rating" placeholder="Ex: 95">

    <label for="release_year">Ano de Lançamento:</label>
    <input type="text" id="release_year" name="release_year" placeholder="Ex: 2023">

    <label for="game_image">URL da Imagem:</label>
    <input type="text" id="game_image" name="game_image" placeholder="https://exemplo.com/imagem.jpg">

    <label>Consolas: <span style="color: red;">*</span></label>
    <div class="custom-dropdown">
      <div class="dropdown-button" onclick="toggleDropdown('consoles-dropdown')">
        <span id="consoles-selected">Selecione as consolas</span>
      </div>
      <div id="consoles-dropdown" class="dropdown-content">
        <?php foreach ($data['consoles'] as $console) { ?>
          <div class="dropdown-item">
            <input type="checkbox" name="consoles[]" value="<?php echo $console['id']; ?>" id="console_<?php echo $console['id']; ?>" onchange="updateSelectedText('consoles')">
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
        <?php foreach ($data['genres'] as $genre) { ?>
          <div class="dropdown-item">
            <input type="checkbox" name="genres[]" value="<?php echo $genre['id']; ?>" id="genre_<?php echo $genre['id']; ?>" onchange="updateSelectedText('genres')">
            <label for="genre_<?php echo $genre['id']; ?>"><?php echo $genre['genre']; ?></label>
          </div>
        <?php } ?>
      </div>
    </div>
    <div id="genres-error" style="color: red; font-size: 12px; margin-bottom: 15px; display: none;">Selecione pelo menos um género</div>

    <div style="display: flex; gap: 10px; margin-top: 20px;">
      <button type="submit" class="btn btn-success" onclick="return validateForm()">✅ Criar Jogo</button>
      <a href="<?php echo $url_alias;?>/movie" class="btn btn-secondary">❌ Cancelar</a>
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
  
  // Esconder mensagem de erro se selecionado
  if (selected.length > 0) {
    document.getElementById(type + '-error').style.display = 'none';
  }
}

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
  
  return isValid;
}

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


