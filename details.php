<?php require('core/init.php');

if(isset($_GET['imdbID'])) {
	$imdbID = $_GET['imdbID'];
	$movie = getMovie($imdbID);
	$poster = getPoster($imdbID);
}

?>

<?php include('templates/header.php'); ?>

    <? if (isset($movie)): ?>
		<div class="movie cmovie">
		<div class="col-md-4">
			<img src="<?= $poster['url']?>" width="80%" height="60%"></img>
		</div>
		<div class="col-md-8">
			<?php echo "<h2>" .$movie['title']. " <small>(".$movie['year'].")</small></h2>"?>
			<p><?= $movie['runtime'] ?> min</p>
		</div>
		<div class="col-md-8">
			
		</div>
		<div class="col-md-8">
			
		</div>
		</div>  	  
	<? else: ?>
    	Nothing to show!
	<? endif; ?>
      	
<?php include('templates/footer.php'); ?>