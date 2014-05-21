<?php
require('core/init.php');

$page = (isset($_GET['page'])) ? $_GET['page']: 1;

$results = [];

if (isset($_POST['btn_search'])){
	$search = $_POST['movie'];
	$results = searchByTitle($search);
}

if (isset($_POST['btn_searchsql'])){
	$sql = $_POST['sql'];
	$results = sqlsearch($sql);
}

?>
<?php require('templates/header.php'); ?>
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>Results:</h1>
			<div class="list-group">

			<? if (!empty($results)): ?>
				<?php
					foreach ($results as $result) {
						if(isset($result['title']))
		 					echo "<a href='details.php?imdbID=".$result['imdbID']."' class='list-group-item'>".$result['title']."</a>";
					}
				?>
			<? else: ?>
   				No result
			<? endif; ?>
			</div>
		</div>
	</div>
<?php require('templates/footer.php'); ?>