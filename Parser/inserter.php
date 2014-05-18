<?php
	require("../core/DB.php");
	require("parser.php");

	//connect to db
	$db = DB::getInstance()->getPDO();

	$p = new Parser("data.json");
	$movies = $p->getMovies(); //get elements of 'movies' array in data.json

	//loop 
	foreach ($movies as $movie) {
		//parse attributes for each movie
		$p->initAttributes($movie);
		//Add movies table
		$sql = "call insertMovie(?, ?, ?, ?, ?)";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(1, $p->title, PDO::PARAM_STR);
		$stmt->bindParam(2, $p->year, PDO::PARAM_INT);
		$stmt->bindParam(3, $p->released, PDO::PARAM_STR);
		$stmt->bindParam(4, $p->runtime, PDO::PARAM_INT);
		$stmt->bindParam(5, $p->id, PDO::PARAM_STR);
		$stmt->execute();

		//get inserted movie id
		$sql = "select id from movies where imdbID = '" .$p->id ."'";
		$stmt = $db->query($sql); 
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$movieid = $row['id'];

		//Add genres
		foreach ($p->genres as $genre) {
			$sql = "call insertGenre(?)";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(1, $genre);
			$stmt->execute();
		}

		//Add director
		$sql = "call insertDirector(?)";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(1, $p->director);
		$stmt->execute();

		//Add writers
		foreach ($p->writers as $writer) {
			$sql = "call insertWriter(?)";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(1, $writer);
			$stmt->execute();
		}

		//Add actors
		foreach ($p->actors as $actor) {
			$sql = "call insertActor(?)";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(1, $actor);
			$stmt->execute();
		}

		//Add languages
		foreach ($p->languages as $lan) {
			$sql = "call insertLanguage(?)";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(1, $lan);
			$stmt->execute();
		}

		//Add countries
		foreach ($p->countries as $coun) {
			$sql = "call insertCountry(?)";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(1, $coun);
			$stmt->execute();
		}

		//Add plot
		$sql = "call insertPlot(?, ?)";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(1, $movieid);
		$stmt->bindParam(2, $p->plot);
		$stmt->execute();
		
		//Add poster
		$sql = "call insertPoster(?, ?)";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(1, $movieid);
		$stmt->bindParam(2, $p->poster);
		$stmt->execute();

		//Add stats
		$sql = "call insertStat(?, ?, ?, ?)";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(1, $movieid);
		$stmt->bindParam(2, $p->rating);
		$stmt->bindParam(3, $p->metascore);
		$stmt->bindParam(4, $p->vote);
		$stmt->execute();

		//Add movie_genre
		foreach ($p->genres as $genre) {
			//get genre id
			$sql = "select id from genres where genre = :genre";
			$stmt = $db->prepare($sql); 
			$stmt->execute(array(':genre' => $genre)); 
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$gid = $row['id'];

			$sql = "call insertMovieGenre(?, ?)";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(1, $movieid);
			$stmt->bindParam(2, $gid);
			$stmt->execute();
		}

		//Add movie_cast
		foreach ($p->actors as $actor) {
			//get actor idsomething = :comparison'
			$sql = "select id from actors where name = :actor";
			$stmt = $db->prepare($sql); 
			$stmt->execute(array(':actor' => $actor));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$aid = $row['id'];

			$sql = "call insertMovieCast(?, ?)";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(1, $movieid);
			$stmt->bindParam(2, $aid);
			$stmt->execute();
		}

		//Add movie_director
		//get director id
		$sql = "select id from directors where name = :director";
		$stmt = $db->prepare($sql); 
		$stmt->execute(array(':director' => $p->director));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$did = $row['id'];

		$sql = "call insertMovieDirector(?, ?)";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(1, $movieid);
		$stmt->bindParam(2, $did);
		$stmt->execute();

		//Add movie_country
		foreach ($p->countries as $country) {
			//get country id
			$sql = "select id from countries where country = :country";
			$stmt = $db->prepare($sql); 
			$stmt->execute(array(':country' => $country));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$cid = $row['id'];

			$sql = "call insertMovieCountry(?, ?)";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(1, $movieid);
			$stmt->bindParam(2, $cid);
			$stmt->execute();
		}

		//Add movie_langugae
		foreach ($p->languages as $lan) {
			//get language id
			$sql = "select id from languages where language = :lan";
			$stmt = $db->prepare($sql); 
			$stmt->execute(array(':lan' => $lan));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$lid = $row['id'];

			$sql = "call insertMovieLanguage(?, ?)";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(1, $movieid);
			$stmt->bindParam(2, $lid);
			$stmt->execute();
		}

		//Add movie_writer
		foreach ($p->writers as $writer) {
			//get writer id
			$sql = "select id from writers where name = :name";
			$stmt = $db->prepare($sql); 
			$stmt->execute(array(':name' => $writer));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$wid = $row['id'];

			$sql = "call insertMovieWriter(?, ?)";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(1, $movieid);
			$stmt->bindParam(2, $wid);
			$stmt->execute();
		}

		//add awards table
		//nope!

	}
	echo "Done!";
?>
