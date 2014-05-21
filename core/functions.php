<?php

//return json file which is collected from omdbapi.com by id
function getJSON($imdbID) {
	$url = "http://www.omdbapi.com/?i={$imdbID}";
	$json = file_get_contents($url);
	$movie = json_decode($json, true);
	if($movie['Response'] === "True") return $movie;
	else return "";
}

function sqlsearch($sql) {
	$results = [];
	try{
		$stmt = DB::getInstance()->getPDO()->prepare($sql); 
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    		$results[] = $row;
		}
	}catch(PDOException $e){ 
       echo "Something is wrong!";
    } 
	return $results;	
}

function searchByTitle($movie) {
	$results = [];
	try{	
		$sql = "select imdbID, title from movies where title like '%".$movie."%' order by title";
		$sql = "select imdbID, title from movies where title like '%".$movie."%'";
		$stmt = DB::getInstance()->getPDO()->prepare($sql); 
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	    	$results[] = $row;
		}
	}catch(PDOException $e) {
		echo "Something is wrong!";
	}
	return $results;	
}

function getMovie($imdbID) {
	$sql = "call getMovie(:id)";
	$stmt = DB::getInstance()->getPDO()->prepare($sql); 
	$stmt->execute(array(':id' => $imdbID));
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getMoviePlot($imdbID) {
	$sql = "call getMoviePlot(:id)";
	$stmt = DB::getInstance()->getPDO()->prepare($sql); 
	$stmt->execute(array(':id' => $imdbID));
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getMoviePoster($imdbID) {
	$sql = "call getMoviePoster(:id)";
	$stmt = DB::getInstance()->getPDO()->prepare($sql); 
	$stmt->execute(array(':id' => $imdbID));
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getMovieGenres($imdbID) {
	$sql = "call getMovieGenres(:id)";
	$stmt = DB::getInstance()->getPDO()->prepare($sql); 
	$stmt->execute(array(':id' => $imdbID));
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	    	$results[] = $row;
	}
	return $results;
}

function getMovieCountries($imdbID) {
	$sql = "call getMovieCountries(:id)";
	$stmt = DB::getInstance()->getPDO()->prepare($sql); 
	$stmt->execute(array(':id' => $imdbID));
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	    	$results[] = $row;
	}
	return $results;
}

function countMovies() {
	$sql = "select count(id) as total from movies";
	$stmt = DB::getInstance()->getPDO()->prepare($sql); 
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	return $row['total'];
}

//check whether a movie with given imdbID is in database
function exists($imdbID){
	$sql = "select * from movies where imdbID = :id";
	$stmt = DB::getInstance()->getPDO()->prepare($sql); 
	$stmt->execute(array(':id' => $imdbID));
	return ($stmt->rowCount() > 0) ? true: false;

}

function addToDb($movie) {
	$p = new Parser();
	$p->parse($movie);

	$sql = "call insertMovie(?, ?, ?, ?, ?)";
	$stmt = DB::getInstance()->getPDO()->prepare($sql);
	$stmt->bindParam(1, $p->title, PDO::PARAM_STR);
	$stmt->bindParam(2, $p->year, PDO::PARAM_INT);
	$stmt->bindParam(3, $p->released, PDO::PARAM_STR);
	$stmt->bindParam(4, $p->runtime, PDO::PARAM_INT);
	$stmt->bindParam(5, $p->id, PDO::PARAM_STR);
	$stmt->execute();

	//get inserted movie id
	$sql = "select id from movies where imdbID = '" .$p->id ."'";
	$stmt = DB::getInstance()->getPDO()->query($sql); 
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$movieid = $row['id'];

	//Add genres
	foreach ($p->genres as $genre) {
		$sql = "call insertGenre(?)";
		$stmt = DB::getInstance()->getPDO()->prepare($sql);
		$stmt->bindParam(1, $genre);
		$stmt->execute();
	}

	//Add director
	$sql = "call insertDirector(?)";
	$stmt = DB::getInstance()->getPDO()->prepare($sql);
	$stmt->bindParam(1, $p->director);
	$stmt->execute();

	//Add writers
	foreach ($p->writers as $writer) {
		$sql = "call insertWriter(?)";
		$stmt = DB::getInstance()->getPDO()->prepare($sql);
		$stmt->bindParam(1, $writer);
		$stmt->execute();
	}

	//Add actors
	foreach ($p->actors as $actor) {
		$sql = "call insertActor(?)";
		$stmt = DB::getInstance()->getPDO()->prepare($sql);
		$stmt->bindParam(1, $actor);
		$stmt->execute();
	}

	//Add languages
	foreach ($p->languages as $lan) {
		$sql = "call insertLanguage(?)";
		$stmt = DB::getInstance()->getPDO()->prepare($sql);
		$stmt->bindParam(1, $lan);
		$stmt->execute();
	}

	//Add countries
	foreach ($p->countries as $coun) {
		$sql = "call insertCountry(?)";
		$stmt = DB::getInstance()->getPDO()->prepare($sql);
		$stmt->bindParam(1, $coun);
		$stmt->execute();
	}

	//Add plot
	$sql = "call insertPlot(?, ?)";
	$stmt = DB::getInstance()->getPDO()->prepare($sql);
	$stmt->bindParam(1, $movieid);
	$stmt->bindParam(2, $p->plot);
	$stmt->execute();
	
	//Add poster
	$sql = "call insertPoster(?, ?)";
	$stmt = DB::getInstance()->getPDO()->prepare($sql);
	$stmt->bindParam(1, $movieid);
	$stmt->bindParam(2, $p->poster);
	$stmt->execute();

	//Add stats
	$sql = "call insertStat(?, ?, ?, ?)";
	$stmt = DB::getInstance()->getPDO()->prepare($sql);
	$stmt->bindParam(1, $movieid);
	$stmt->bindParam(2, $p->rating);
	$stmt->bindParam(3, $p->metascore);
	$stmt->bindParam(4, $p->vote);
	$stmt->execute();

	//Add movie_genre
	foreach ($p->genres as $genre) {
		//get genre id
		$sql = "select id from genres where genre = :genre";
		$stmt = DB::getInstance()->getPDO()->prepare($sql); 
		$stmt->execute(array(':genre' => $genre)); 
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$gid = $row['id'];

		$sql = "call insertMovieGenre(?, ?)";
		$stmt = DB::getInstance()->getPDO()->prepare($sql);
		$stmt->bindParam(1, $movieid);
		$stmt->bindParam(2, $gid);
		$stmt->execute();
	}

	//Add movie_cast
	foreach ($p->actors as $actor) {
		//get actor idsomething = :comparison'
		$sql = "select id from actors where name = :actor";
		$stmt = DB::getInstance()->getPDO()->prepare($sql); 
		$stmt->execute(array(':actor' => $actor));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$aid = $row['id'];

		$sql = "call insertMovieCast(?, ?)";
		$stmt = DB::getInstance()->getPDO()->prepare($sql);
		$stmt->bindParam(1, $movieid);
		$stmt->bindParam(2, $aid);
		$stmt->execute();
	}

	//Add movie_director
	//get director id
	$sql = "select id from directors where name = :director";
	$stmt = DB::getInstance()->getPDO()->prepare($sql); 
	$stmt->execute(array(':director' => $p->director));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$did = $row['id'];

	$sql = "call insertMovieDirector(?, ?)";
	$stmt = DB::getInstance()->getPDO()->prepare($sql);
	$stmt->bindParam(1, $movieid);
	$stmt->bindParam(2, $did);
	$stmt->execute();

	//Add movie_country
	foreach ($p->countries as $country) {
		//get country id
		$sql = "select id from countries where country = :country";
		$stmt = DB::getInstance()->getPDO()->prepare($sql); 
		$stmt->execute(array(':country' => $country));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$cid = $row['id'];

		$sql = "call insertMovieCountry(?, ?)";
		$stmt = DB::getInstance()->getPDO()->prepare($sql);
		$stmt->bindParam(1, $movieid);
		$stmt->bindParam(2, $cid);
		$stmt->execute();
	}

	//Add movie_langugae
	foreach ($p->languages as $lan) {
		//get language id
		$sql = "select id from languages where language = :lan";
		$stmt = DB::getInstance()->getPDO()->prepare($sql); 
		$stmt->execute(array(':lan' => $lan));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$lid = $row['id'];

		$sql = "call insertMovieLanguage(?, ?)";
		$stmt = DB::getInstance()->getPDO()->prepare($sql);
		$stmt->bindParam(1, $movieid);
		$stmt->bindParam(2, $lid);
		$stmt->execute();
	}

	//Add movie_writer
	foreach ($p->writers as $writer) {
		//get writer id
		$sql = "select id from writers where name = :name";
		$stmt = DB::getInstance()->getPDO()->prepare($sql); 
		$stmt->execute(array(':name' => $writer));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$wid = $row['id'];

		$sql = "call insertMovieWriter(?, ?)";
		$stmt = DB::getInstance()->getPDO()->prepare($sql);
		$stmt->bindParam(1, $movieid);
		$stmt->bindParam(2, $wid);
		$stmt->execute();
	}

}

?>