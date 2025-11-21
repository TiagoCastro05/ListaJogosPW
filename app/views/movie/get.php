<pre>
<?php 
// debug
// print_r($data);
?>
</pre>

<?php
if (count($data['movies']) == 0) {
?>
  <h1>O jogo não existe na nossa base de dados...</h1>
<?php 
} else {
?>

  <div>
  <?php
  echo "Nome: " . $data['movies'][0]['title'];
  ?>
  </div>

  <div>
  <?php
  echo "Metacritic: " . $data['movies'][0]['metacritic_rating'];
  ?>
  </div>

  <div>
  <?php
  echo "Ano: " . $data['movies'][0]['release_year'];
  ?>
  </div>

  <div>
  <?php
  if (!empty($data['movies'][0]['game_image'])) {
    echo '<img src="' . $data['movies'][0]['game_image'] . '" alt="' . $data['movies'][0]['title'] . '" style="max-width: 300px;">';
  }
  ?>
  </div>

  <div>
  <?php
  if (!empty($data['consoles']) && count($data['consoles']) > 0) {
    echo "<strong>Consolas:</strong> ";
    $console_names = array_map(function($console) {
      return $console['console_name'];
    }, $data['consoles']);
    echo implode(', ', $console_names);
  }
  ?>
  </div>

  <div>
  <?php
  if (!empty($data['genres']) && count($data['genres']) > 0) {
    echo "<strong>Géneros:</strong> ";
    $genre_names = array_map(function($genre) {
      return $genre['genre'];
    }, $data['genres']);
    echo implode(', ', $genre_names);
  }
  ?>
  </div>
<?php 
}
?>
<a href="<?php echo $url_alias;?>/movie">Voltar</a>