<?php

function getMovie($imdbID) {
	$sql = "select * from movies, posters where posters.movie_id = movies.id and imdbID = :id";
	$stmt = DB::getInstance()->getPDO()->prepare($sql); 
	$stmt->execute(array(':id' => $imdbID));
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getMovieGenres($imdbID){
	$results = [];
	$sql = "";
	//$stmt = DB::getInstance()->getPDO()->prepare($sql); 
}

?>