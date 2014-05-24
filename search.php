<?php require('core/init.php');

$pdo = DB::getInstance()->getPDO();

if (isset($_POST['btn_search'])){
	$search = $_POST['movie'];
	$results = searchByTitle($search);
}

if (isset($_POST['btn_asearch'])){
	$year = @$_POST['year'];
	$genre = @$_POST['genre'];
	$language = @$_POST['language'];
	$country = @$_POST['country'];

	$aresults = advancedSearch($year, $genre, $country, $language);
	
}

?>

<?php require('templates/header.php'); ?>

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>Results:</h1>
			<div class="list-group">

				<?php
					if (!empty($results)){
						foreach ($results as $result) {
							if(isset($result['title']))
								echo "<a href='details.php?imdbID=".$result['imdbID']."' class='list-group-item'>".$result['title']."</a>";
						}
					}else if (!empty($aresults)) {
						foreach ($aresults as $result) {
							if(isset($result['title']))
								echo "<a href='details.php?imdbID=".$result['imdbID']."' class='list-group-item'>".$result['title']."</a>";
						}
					}
					else echo "Nothing to show!";
				?>
	
			</div>
		</div>
	</div>

<?php require('templates/footer.php'); ?>
