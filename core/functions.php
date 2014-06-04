<?php
$path = dirname(__FILE__);

function load() {
	global $path;	
	$p = new Parser();
	$file = file_get_contents("{$path}/../Parser/data.json");  
	$json = json_decode($file, true);
	$movies = $json['movies'];

	foreach ($movies as $movie) {
		addToDb($movie); //parse and insert
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

function getNumOfMovies() {
	$sql = "select count(*) as total from movies";
	$stmt = DB::getInstance()->getPDO()->prepare($sql); 
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	return $row['total'];
}

function getID($table, $field, $by) {
	$sql = "select id from ".$table." where ".$field." = :by";
	$stmt = DB::getInstance()->getPDO()->prepare($sql); 
	$stmt->execute(array(':by' => $by));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	return $row['id'];
}

function insert($spname, $fields = array()) {
	for ($i=0; $i < count($fields) ; $i++) { 
		$qmarks[] = "?"; 
	}
	$qmarks = implode(", ", $qmarks);
	$sql = "call ".$spname."(".$qmarks.")";

	$stmt = DB::getInstance()->getPDO()->prepare($sql);

	for ($i=0; $i < count($fields) ; $i++) { 
		if(is_numeric($fields[$i])) {
			$stmt->bindParam($i+1, $fields[$i], PDO::PARAM_INT);
		}else{
			$stmt->bindParam($i+1, $fields[$i], PDO::PARAM_STR);
		}
	}
	$stmt->execute();
}

function addToDb($movie) {
	$p = new Parser();
	$p->parse($movie);

	insert("insertMovie", array($p->title, $p->year, $p->released, $p->runtime, $p->id));
	$movieid = getID("movies", "imdbID", $p->id);

	//Add genres
	foreach ($p->genres as $genre) {
		insert("insertGenre", array($genre));
	}
	//Add director
	foreach ($p->directors as $director) {
		insert("insertDirector", array($director));
	}
	//Add writers
	foreach ($p->writers as $writer) {
		insert("insertWriter", array($writer));
	}
	//Add actors
	foreach ($p->actors as $actor) {	
		insert("insertActor", array($actor));
	}
	//Add languages
	foreach ($p->languages as $lan) {
		insert("insertLanguage", array($lan));
	}
	//Add countries
	foreach ($p->countries as $coun) {
		insert("insertCountry", array($coun));
	}
	//Add plot
	insert("insertPlot", array($movieid, $p->plot));
	//Add poster
	insert("insertPoster", array($movieid, $p->poster));
	//Add stats
	insert("insertStat", array($movieid, $p->rating, $p->metascore, $p->vote));
	//Add awards
	insert("insertAwards", array($movieid, $p->awards['Oscar'], $p->awards['Win'], $p->awards['Another']));
	//Add movie_genre
	foreach ($p->genres as $genre) {
		$gid = getID("genres", "genre", "$genre");
		insert("insertMovieGenre", array($movieid, $gid));
	}
	//Add movie_cast
	foreach ($p->actors as $actor) {
		$aid = getID("actors", "name", $actor);
		insert("insertMovieCast", array($movieid, $aid));
	}
	//Add movie_director
	foreach ($p->directors as $director) {
		$did = getID("directors", "name", $director);
		insert("insertMovieDirector", array($movieid, $did));
	}
	//Add movie_country
	foreach ($p->countries as $country) {
		$cid = getID("countries", "country", $country);
		insert("insertMovieCountry", array($movieid, $cid));
	}
	//Add movie_langugae
	foreach ($p->languages as $lan) {
		$lid = getID("languages", "language", $lan);
		insert("insertMovieLanguage", array($movieid, $lid));
	}
	//Add movie_writer
	foreach ($p->writers as $writer) {
		$wid = getID("writers", "name", $writer);
		insert("insertMovieWriter", array($movieid, $wid));
	}
}

?>