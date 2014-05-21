<?php require('core/init.php');

if(isset($_GET['imdbID'])) {
	$imdbID = $_GET['imdbID'];
	$movie = getMovie($imdbID);
	$poster = getMoviePoster($imdbID);
	$mgenres = getMovieGenres($imdbID);
	$genres = "";
	$i = 0;
	foreach ($mgenres as $genre) {
		$i++;
		if($i < count($mgenres))
			$genres .= $genre['genre']. " | ";
		else
			$genres .= $genre['genre'];
	}
	$plot = getMoviePlot($imdbID);

	$mcountries = getMovieCountries($imdbID);
	$countries = "";
	$i = 0;
	foreach ($mcountries as $country) {
		$i++;
		if($i < count($mcountries))
			$countries .= $country['country']. ", ";
		else
			$countries .= $country['country'];
	}
	$director = getMovieDirector($imdbID);
}

?>

<?php include('templates/header.php'); ?>

    <? if (isset($movie)): ?>
		<div class="row crow">
			<div class="col-md-4 col-md-offset-1">
				<img class="poster" src="<?= $poster['url']?>" width="80%" height="60%"></img>
			</div>
			<div class="col-md-5">
				<?php echo "<h2>" .$movie['title']. " <small>(".$movie['year'].")</small></h2>"?>
				<p><?= $movie['runtime'] ?> min - <small style="color: #6999e0"> <?= $genres ?> </small> - <?= $movie['released'] ?> (<small style="color: #6999e0"> <?= $countries ?> </small>) </p>
				<hr>
			</div>
			<div class="col-md-5">
				<p><?= $plot['plot'] ?></p>
				<hr>
			</div>
			<div class="col-md-5">
				<p><strong>Director: </strong><?= $director['name'] ?></p>
			</div>
		</div>  	  
	<? else: ?>
    	Nothing to show!
	<? endif; ?>
      	
<?php include('templates/footer.php'); ?>