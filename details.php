<?php require('core/init.php');

if($_GET) {

	$imdbID = $_GET['imdbID'];
	$row = getMovie($imdbID);

}else {
	$errors[] = "Nothing to show.";
}

?>

<?php include('templates/header.php'); ?>
      
    <div class="row crow">
		<div class="col-md-4">
			<img src="<?= $row['url']?>" width="80%" height="60%"></img>
		</div>
		<div class="col-md-8">
			<?php echo "<h2>" .$row['title']. " <small>(".$row['year'].")</small></h2>"?>
			<p><?= $row['runtime'] ?> min</p>
		</div>
		<div class="col-md-8">
			
		</div>
		<div class="col-md-8">
			
		</div>
	</div>
      	
<?php include('templates/footer.php'); ?>