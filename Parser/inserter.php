<?php
	//This file insert into database from data.json
	require("../core/init.php");

	//connect to db
	$db = DB::getInstance()->getPDO();

	$p = new Parser();
	$file = file_get_contents("data.json");  
	$json = json_decode($file, true);
	$movies = $json['movies'];

	foreach ($movies as $movie) {
		addToDb($movie); //parse and insert
	}
	echo "Done!";
?>
