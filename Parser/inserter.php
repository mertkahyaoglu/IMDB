<?php
	//This file insert into database from data.json
	require("../core/init.php");

	//connect to db
	$db = DB::getInstance()->getPDO();

	$p = new Parser();
	//read data.json file
	$file = file_get_contents("data.json");  
	//make it parseble
	$json = json_decode($file, true);
	//load 'movies' array in data.json into $this->movies array
	$movies = $json['movies'];

	//loop 
	foreach ($movies as $movie) {
		addToDb($movie);
	}
	echo "Done!";
?>
