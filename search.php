<?php require('core/init.php');

$pdo = DB::getInstance()->getPDO();

$results = [];

if (isset($_POST['btn_search'])){
	$search = $_POST['movie'];
	$results = searchByTitle($search);
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
					}
					else echo "Nothing to show!";
				?>
	
			</div>
		</div>
	</div>

<?php require('templates/footer.php'); ?>
