<?php
$path = dirname(__FILE__);

function load() {
	global $path;
	if(!exists("tt1375666")) {
		$p = new Parser();
		$file = file_get_contents("{$path}/../Parser/data.json");  
		$json = json_decode($file, true);
		$movies = $json['movies'];

		foreach ($movies as $movie) {
			addToDb($movie); //parse and insert
		}
	}
}

//return json file which is collected from omdbapi.com by id
function getJSON($imdbID) {
	$url = "http://www.omdbapi.com/?i={$imdbID}";
	$json = file_get_contents($url);
	$movie = json_decode($json, true);
	if($movie['Response'] === "True") return $movie;
	else return "";
}

function advancedSearch($year, $genre, $con, $lan) {
	$count = [];
	$results = [];
	if(isset($year)) $count['year'] = "m.year = {$year}";
	if(isset($genre)) $count['genre'] = "g.genre = '{$genre}'";
	if(isset($con)) $count['country'] = "c.country = '{$con}'";
	if(isset($lan)) $count['language'] = "l.language = '{$lan}'";
	if(count($count) < 1) return null;

	$sql = "SELECT DISTINCT imdbID, title 
			FROM movies m, movie_genre mg, genres g, movie_country mc, 
				 countries c, movie_language ml, languages l
			WHERE m.id = mg.movie_id and mg.genre_id = g.id and
				  m.id = mc.movie_id and mc.country_id = c.id and
				  m.id = ml.movie_id and ml.language_id = l.id ";
	
	if(count($count) > 1) {
		$count = implode(" and ", $count);
		$sql .= " and ".$count;
	}else {
		$sql .= " and ".array_values($count)[0];
	}
	
	$stmt = DB::getInstance()->getPDO()->prepare($sql); 
	$stmt->execute();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	    $results[] = $row;
	}
	return $results;
}

function searchByTitle($movie) {
	$results = [];
	try{	
		$sql = "select imdbID, title from movies where title like '%".$movie."%' order by title";
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

function getFields($sp, $by) {
	if($by === "") {
		$sql = "call ".$sp."()";
		$stmt = DB::getInstance()->getPDO()->prepare($sql); 
		$stmt->execute();
	}else {
		$sql = "call ".$sp."(:id)";
		$stmt = DB::getInstance()->getPDO()->prepare($sql); 
		$stmt->execute(array(':id' => $by));
	}
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	    	$results[] = $row;
	}
	return $results;
}

function getField($sp, $by) {
	if($by === ""){
		$sql = "call ".$sp."()";
		$stmt = DB::getInstance()->getPDO()->prepare($sql); 
		$stmt->execute();
	}else {
		$sql = "call ".$sp."(:by)";
		$stmt = DB::getInstance()->getPDO()->prepare($sql); 
		$stmt->execute(array(':by' => $by));
	}
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function implodeFields($values, $key, $with) {
	$result = "";
	$i = 0;
	foreach ($values as $value) {
		$i++;
		if($i < count($values)) $result .= $value[$key]. $with;
		else $result .= $value[$key];
	}
	return $result;
}

//check whether a movie with given imdbID is in database
function exists($imdbID){
	$sql = "select * from movies where imdbID = :id";
	$stmt = DB::getInstance()->getPDO()->prepare($sql); 
	$stmt->execute(array(':id' => $imdbID));
	return ($stmt->rowCount() > 0) ? true: false;
}

function getID($table, $field, $by) {
	$sql = "select id from ".$table." where ".$field." = :by";
	$stmt = DB::getInstance()->getPDO()->prepare($sql); 
	$stmt->execute(array(':by' => $by));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	return $row['id'];
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

	$movieid = getID("movies", "imdbID", $p->id);

	//Add genres
	foreach ($p->genres as $genre) {
		$sql = "call insertGenre(?)";
		$stmt = DB::getInstance()->getPDO()->prepare($sql);
		$stmt->bindParam(1, $genre);
		$stmt->execute();
	}

	//Add director
	foreach ($p->directors as $director) {
		$sql = "call insertDirector(?)";
		$stmt = DB::getInstance()->getPDO()->prepare($sql);
		$stmt->bindParam(1, $director);
		$stmt->execute();
	}

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

	//Add awards
	$sql = "call insertAwards(?, ?, ?, ?)";
	$stmt = DB::getInstance()->getPDO()->prepare($sql);
	$stmt->bindParam(1, $movieid);
	$stmt->bindParam(2, $p->awards['Oscar']);
	$stmt->bindParam(3, $p->awards['Wins']);
	$stmt->bindParam(4, $p->awards['Another']);
	$stmt->execute();

	//Add movie_genre
	foreach ($p->genres as $genre) {
		$gid = getID("genres", "genre", "$genre");

		$sql = "call insertMovieGenre(?, ?)";
		$stmt = DB::getInstance()->getPDO()->prepare($sql);
		$stmt->bindParam(1, $movieid);
		$stmt->bindParam(2, $gid);
		$stmt->execute();
	}

	//Add movie_cast
	foreach ($p->actors as $actor) {
		$aid = getID("actors", "name", $actor);

		$sql = "call insertMovieCast(?, ?)";
		$stmt = DB::getInstance()->getPDO()->prepare($sql);
		$stmt->bindParam(1, $movieid);
		$stmt->bindParam(2, $aid);
		$stmt->execute();
	}

	//Add movie_director
	//get director id
	foreach ($p->directors as $director) {
		$did = getID("directors", "name", $director);

		$sql = "call insertMovieDirector(?, ?)";
		$stmt = DB::getInstance()->getPDO()->prepare($sql);
		$stmt->bindParam(1, $movieid);
		$stmt->bindParam(2, $did);
		$stmt->execute();
	}

	//Add movie_country
	foreach ($p->countries as $country) {
		$cid = getID("countries", "country", $country);

		$sql = "call insertMovieCountry(?, ?)";
		$stmt = DB::getInstance()->getPDO()->prepare($sql);
		$stmt->bindParam(1, $movieid);
		$stmt->bindParam(2, $cid);
		$stmt->execute();
	}

	//Add movie_langugae
	foreach ($p->languages as $lan) {
		$lid = getID("languages", "language", $lan);

		$sql = "call insertMovieLanguage(?, ?)";
		$stmt = DB::getInstance()->getPDO()->prepare($sql);
		$stmt->bindParam(1, $movieid);
		$stmt->bindParam(2, $lid);
		$stmt->execute();
	}

	//Add movie_writer
	foreach ($p->writers as $writer) {
		$wid = getID("writers", "name", $writer);

		$sql = "call insertMovieWriter(?, ?)";
		$stmt = DB::getInstance()->getPDO()->prepare($sql);
		$stmt->bindParam(1, $movieid);
		$stmt->bindParam(2, $wid);
		$stmt->execute();
	}
	
}

?>