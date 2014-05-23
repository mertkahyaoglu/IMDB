<?php require('core/init.php');

if(isset($_GET['imdbID'])) {
	$imdbID = $_GET['imdbID'];
	
	$movie  = getField("getMovie", $imdbID);
	$poster = getField("getMoviePoster",$imdbID);
	$plot   = getField("getMoviePlot", $imdbID);
	$stats = getField("getMovieStats", $imdbID);

	$genres    = implodeFields(getFields("getMovieGenres", $imdbID), "genre", " | ");
	$countries = implodeFields(getFields("getMovieCountries", $imdbID), "country", ", ");
	$directors = implodeFields(getFields("getMovieDirectors", $imdbID), "name", ", ");
	$writers   = implodeFields(getFields("getMovieWriters", $imdbID), "name", ", ");
	$actors    = implodeFields(getFields("getMovieActors", $imdbID), "name", ", ");
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
			<div class="col-md-5 stat">
				<small>
					<span class="text-warning">Ratings : </span>
					<strong><?= $stats['imdb_rating'] ?></strong>
					<span class="text-muted">/10</span> 
					from <span class="text-info"><?= number_format($stats['imdb_votes'])?></span>
					votes, Metascore : <strong><?= $stats['imdb_metascore']?></strong>
				</small>
			</div>
			<div class="col-md-5">
				<hr>
				<p><?= $plot['plot'] ?></p>
				<hr>
			</div>
			<div class="col-md-5">
				<p><strong>Director: </strong><?= $directors ?></p>
			</div>
			<div class="col-md-5">
				<p><strong>Writers: </strong><?= $writers ?></p>
			</div>
			<div class="col-md-5">
				<p><strong>Stars: </strong><?= $actors ?></p>
			</div>
		</div>  	  
	<? else: ?>
    	Nothing to show!
	<? endif; ?>
      	
<?php include('templates/footer.php'); ?>