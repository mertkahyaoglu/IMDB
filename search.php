<?php

require('core/init.php');

$pdo = DB::getInstance()->getPDO();
$results = [];

if (isset($_POST['btn_search'])){
	$search = $_POST['movie'];
	$results = searchByTitle($search);
}else {
	
}

if (isset($_POST['btn_searchsql'])){
	$sql = $_POST['sql'];
	$results = sqlsearch($sql);
}else {
	
}

?>
<?php require('templates/header.php'); ?>
	<div class="row">
		<div class="col-md-6">
			<h1>Results:</h1>
			<div class="list-group">
			<?php
				if(!empty($results)) {
					foreach ($results as $result) {
		 				echo "<a href='details.php?imdbID=".$result['imdbID']."' class='list-group-item'>".$result['title']."</a>";
					}
				}else{
					echo "No result!";
				} 
	 		?>
			</div>

		</div>
	</div>
<?php require('templates/footer.php'); ?>