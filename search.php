<?php
<<<<<<< HEAD
require('core/init.php');

$page = (isset($_GET['page'])) ? $_GET['page']: 1;

=======

require('core/init.php');

$pdo = DB::getInstance()->getPDO();
>>>>>>> 643f952987283411bd64130b8b80da6d677dffe1
$results = [];

if (isset($_POST['btn_search'])){
	$search = $_POST['movie'];
	$results = searchByTitle($search);
<<<<<<< HEAD
=======
}else {
	
>>>>>>> 643f952987283411bd64130b8b80da6d677dffe1
}

if (isset($_POST['btn_searchsql'])){
	$sql = $_POST['sql'];
	$results = sqlsearch($sql);
<<<<<<< HEAD
=======
}else {
	
>>>>>>> 643f952987283411bd64130b8b80da6d677dffe1
}

?>
<?php require('templates/header.php'); ?>
	<div class="row">
<<<<<<< HEAD
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
=======
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

>>>>>>> 643f952987283411bd64130b8b80da6d677dffe1
		</div>
	</div>
<?php require('templates/footer.php'); ?>