<?php

require('core/init.php');

$pdo = DB::getInstance()->getPDO();
$results = [];

if($_POST) {
	$movie = $_POST['movie'];
	$sql = "select * from movies where title like '%".$movie."%'";
	$stmt = $pdo->prepare($sql); 
	$stmt->execute();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    	$results[] = $row;
	}
	
}

?>
<?php require('templates/header.php'); ?>
	<div class="row">
		<div class="col-md-6">
			<h1>Results:</h1>
			<div class="list-group">
			<?php
		 		foreach ($results as $result) {
		 			echo "<a href='details.php?imdbID=".$result['imdbID']."' class='list-group-item'>".$result['title']."</a>";
				}
	 		?>
			</div>

		</div>
	</div>
<?php require('templates/footer.php'); ?>