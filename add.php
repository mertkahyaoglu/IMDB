<?php

require('core/init.php');

$notifier = "";

$pdo = DB::getInstance()->getPDO();
$parser = new Parser();

if (isset($_POST['btn_add'])){
	$id = $_POST['imdbID'];
	$movie = getJSON($id);
	if(is_string($movie)){
		$notifier = "No result!";
	}else {
		$parser->parse($movie);
		if(!exists($parser->id)) {
			addToDb($movie);
			$notifier = "<a href='details.php?imdbID=".$parser->id."' class='list-group-item'>".$parser->title."</a>";
		}else {
			$notifier = $parser->title." is already in database";
		}
	}
}

?>
<?php require('templates/header.php'); ?>
	
	<div class="row">
		<div class="col-md-12">
			<h1>Results:</h1>
			<div class="list-group">
				 <?= $notifier ?>
			</div>
		</div>
	</div>

<?php require('templates/footer.php'); ?>