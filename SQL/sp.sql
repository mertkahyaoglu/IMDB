-- -----------------------------------------------------
-- procedure insertMovie
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertMovie`(IN movie_title VARCHAR(100),
							  IN movie_year smallint(4),
							  IN movie_released DATE,
							  IN movie_runtime SMALLINT(3),
							  IN movie_imdbID CHAR(9))
BEGIN
   INSERT INTO movies(id, title, year, released, runtime, imdbID) 
   VALUES(null, movie_title, movie_year, movie_released, movie_runtime, movie_imdbID);
END
$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure insertGenre
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertGenre`(IN newGenre VARCHAR(45))
BEGIN
   INSERT INTO genres(id, genre) 
   VALUES(null, newGenre);
   END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure insertLanguage
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertLanguage`(IN lan VARCHAR(45))
BEGIN
   INSERT INTO languages(id, language) 
   VALUES(null, lan);
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure insertCountry
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertCountry`(IN coun VARCHAR(50))
BEGIN
   INSERT INTO countries(id, country) 
   VALUES(null, coun);
   END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure insertDirector
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertDirector`(IN dir VARCHAR(45))
BEGIN
   INSERT INTO directors(id, name) 
   VALUES(null, dir);
   END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure insertWriter
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertWriter`(IN writer VARCHAR(45))
BEGIN
   INSERT INTO writers(id, name) 
   VALUES(null, writer);
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure insertActor
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertActor`(IN actor VARCHAR(45))
BEGIN
   INSERT INTO actors(id, name) 
   VALUES(null, actor);
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure insertPoster
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertPoster`(IN mid INT,IN purl VARCHAR(128))
BEGIN
   INSERT INTO posters(movie_id, url) 
   VALUES(mid, purl);
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure insertPlot
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertPlot`(IN mid INT,IN pl VARCHAR(400))
BEGIN
   INSERT INTO plots(movie_id, plot) 
   VALUES(mid, pl);
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure insertStat
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE PROCEDURE `insertStat` (IN mid INT,
							   IN rate FLOAT(2,1),
							   IN meta TINYINT,
							   IN vote INT)
BEGIN
	INSERT INTO stats(movie_id, imdb_rating, imdb_metascore, imdb_votes)
	VALUES(mid, rate, meta, vote);
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure insertMovieGenre
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE PROCEDURE `insertMovieGenre` (IN mid INT, IN gid INT)
BEGIN
	INSERT INTO movie_genre(movie_id, genre_id) VALUES(mid,gid);
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure insertMovieCountry
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE PROCEDURE `insertMovieCountry` (IN mid INT, IN cid INT)
BEGIN
	INSERT INTO movie_country(movie_id, country_id) VALUES(mid,cid);
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure insertMovieDirector
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE PROCEDURE `insertMovieDirector` (IN mid INT, IN did INT)
BEGIN
	INSERT INTO movie_director(movie_id, director_id) VALUES(mid,did);
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure insertMovieLanguage
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE PROCEDURE `insertMovieLanguage` (IN mid INT, IN lid INT)
BEGIN
	INSERT INTO movie_language(movie_id, language_id) VALUES(mid,lid);
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure insertMovieWriter
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE PROCEDURE `insertMovieWriter` (IN mid INT, IN wid INT)
BEGIN
	INSERT INTO movie_writer(movie_id, writer_id) VALUES(mid,wid);
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure insertAwards
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE PROCEDURE `insertAwards` (IN mid INT, IN o TINYINT(3), IN w SMALLINT(4), IN n SMALLINT(4))
BEGIN
	INSERT INTO awards(movie_id, oscars, wins, nominations)
	VALUES(mid, o, w, n);
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure insertMovieCast
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE PROCEDURE `insertMovieCast` (IN mid INT, IN aid INT)
BEGIN
	INSERT INTO movie_cast(movie_id, actor_id) VALUES(mid,aid);
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure getMovie
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getMovie`(IN iid CHAR(9))
BEGIN
	SELECT title, year, DATE_FORMAT(released, '%d %b %Y') as released, runtime, imdbID FROM movies WHERE imdbID = iid;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure getMovieActors
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getMovieActors`(IN imdb_ID VARCHAR(9))
BEGIN
	SELECT name FROM actors, movies, movie_cast WHERE movies.id = movie_cast.movie_id and movie_cast.actor_id = actors.id and movies.imdbID = imdb_ID;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure getMovieCountries
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getMovieCountries`(IN imdb_ID VARCHAR(9))
BEGIN
	SELECT country FROM countries, movies, movie_country WHERE movies.id = movie_country.movie_id and movie_country.country_id = countries.id and movies.imdbID = imdb_ID;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure getMovieDirectors
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getMovieDirectors`(IN imdb_ID VARCHAR(9))
BEGIN
	SELECT name FROM directors, movies, movie_director WHERE directors.id = movie_director.director_id and movie_director.movie_id = movies.id and movies.imdbID = imdb_ID;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure getMovieGenres
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getMovieGenres`(IN iid CHAR(9))
BEGIN
	SELECT genre FROM movies m, movie_genre mg, genres g WHERE m.id = mg.movie_id and mg.genre_id = g.id and m.imdbID = iid;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure getMoviePlot
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getMoviePlot`(IN imdb_ID VARCHAR(9))
BEGIN
	SELECT plot FROM plots, movies WHERE plots.movie_id = id and movies.imdbID = imdb_ID;

END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure getMoviePoster
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getMoviePoster`(IN imdb_ID VARCHAR(9))
BEGIN
	SELECT url FROM posters, movies WHERE posters.movie_id = movies.id and movies.imdbID = imdb_ID;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure getMovieWriters
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getMovieWriters`(IN imdb_ID VARCHAR(9))
BEGIN
	SELECT name FROM writers, movie_writer, movies WHERE movies.id = movie_writer.movie_id and movie_writer.writer_id=writers.id and movies.imdbID = imdb_ID;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure getMovieStats
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getMovieStats`(IN imdb_ID VARCHAR(9))
BEGIN
	SELECT imdb_rating, imdb_votes, imdb_metascore FROM stats,movies WHERE stats.movie_id = movies.id and movies.imdbID = imdb_ID;
END
$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure getYears
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE PROCEDURE `getYears` ()
BEGIN
	select distinct year from movies order by year DESC;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure getGenres
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE PROCEDURE `getGenres` ()
BEGIN
	select genre from genres order by genre;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure getLanguages
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE PROCEDURE `getLanguages` ()
BEGIN
	select language from languages order by language;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure getCountries
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE PROCEDURE `getCountries` ()
BEGIN
	select country from countries order by country;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure deleteMovie
-- -----------------------------------------------------

DELIMITER $$
USE `imdb`$$
CREATE PROCEDURE `deleteMovie` (IN iid CHAR(9))
BEGIN
	delete from movies where imdbID = iid;
END$$

DELIMITER ;