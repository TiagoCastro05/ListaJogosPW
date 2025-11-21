<h2>Criar Novo Jogo</h2>

<style>
.custom-dropdown {
  position: relative;
  width: 300px;
  margin-bottom: 20px;
}

.dropdown-button {
  width: 100%;
  padding: 8px 12px;
  border: 1px solid #ccc;
  background: white;
  text-align: left;
  cursor: pointer;
  border-radius: 4px;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: white;
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  max-height: 200px;
  overflow-y: auto;
  z-index: 1000;
  box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

.dropdown-content.show {
  display: block;
}

.dropdown-item {
  padding: 8px 12px;
  cursor: pointer;
}

.dropdown-item:hover {
  background-color: #f0f0f0;
}

.dropdown-item input[type="checkbox"] {
  margin-right: 8px;
}
</style>

<form action="<?php echo $url_alias;?>/movie/create" method="POST">
  <label for="title">Título:</label>
  <input type="text" id="title" name="title" required><br>

  <label for="metacritic_rating">Metacritic Rating:</label>
  <input type="text" id="metacritic_rating" name="metacritic_rating"><br>

  <label for="release_year">Ano de Lançamento:</label>
  <input type="text" id="release_year" name="release_year"><br>

  <label for="game_image">URL da Imagem:</label>
  <input type="text" id="game_image" name="game_image"><br>

  <label>Consolas:</label>
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

  <label>Géneros:</label>
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

  <button type="submit">Criar Jogo</button>
</form>

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

// Fechar dropdown ao clicar fora
window.onclick = function(event) {
  if (!event.target.matches('.dropdown-button') && !event.target.closest('.dropdown-content')) {
    var dropdowns = document.getElementsByClassName('dropdown-content');
    for (var i = 0; i < dropdowns.length; i++) {
      dropdowns[i].classList.remove('show');
    }
  }
}
</script>
<a href="<?php echo $url_alias;?>/movie">Voltar</a>


