<h2>Criar Novo Jogo</h2>

<form action="<?php echo $url_alias;?>/movie/create" method="POST">
  <label for="title">Título:</label>
  <input type="text" id="title" name="title" required><br>

  <label for="metacritic_rating">Metacritic Rating:</label>
  <input type="text" id="metacritic_rating" name="metacritic_rating"><br>

  <label for="release_year">Ano de Lançamento:</label>
  <input type="text" id="release_year" name="release_year"><br>

  <label for="game_image">URL da Imagem:</label>
  <input type="text" id="game_image" name="game_image"><br>

  <button type="submit">Criar Jogo</button>
</form>
<a href="<?php echo $url_alias;?>/movie">Voltar</a>


