-- --------------------------------------------------------------------------------
-- getGenres
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE PROCEDURE `getGenres`(IN iid CHAR(9))
BEGIN
	SELECT genre FROM movies m, movie_genre mg, genres g 
	WHERE m.id = mg.movie_id and mg.genre_id = g.id and m.imdbID = iid;
END

DELIMITER $$

CREATE PROCEDURE `getActors`(IN imdb_ID VARCHAR(9))
BEGIN
	SELECT name FROM actors, movies, movie_cast WHERE movies.id = movie_cast.movie_id and movie_cast.actor_id = actors.id and movies.imdbID = imdb_ID;
END

DELIMITER $$

CREATE PROCEDURE `getDirectors`(IN imdb_ID VARCHAR(9))
BEGIN
	SELECT name FROM directors, movies, movie_director WHERE directors.id = movie_director.director_id and movie_director.movie_id = movies.id and movies.imdbID = imdb_ID;
END

DELIMITER $$

CREATE PROCEDURE `getPlot`(IN imdb_ID VARCHAR(9))
BEGIN
	SELECT plot FROM plots, movies WHERE plots.movie_id = id and movies.imdbID = imdb_ID;

END

DELIMITER $$

CREATE PROCEDURE `getPoster`(IN imdb_ID VARCHAR(9))
BEGIN
	SELECT url FROM posters, movies WHERE posters.movie_id = movies.id and movies.imdbID = imdb_ID  ;
END

DELIMITER $$

CREATE PROCEDURE `getRating`(IN imdb_ID VARCHAR(9))
BEGIN
	SELECT imdb_rating FROM stats,movies WHERE stats.movie_id = movies.id and movies.imdbID = imdb_ID;
END

DELIMITER $$

CREATE PROCEDURE `getWriters`(IN imdb_ID VARCHAR(9))
BEGIN
	SELECT name FROM writers, movie_writer, movies WHERE movies.id = movie_writer.movie_id and movie_writer.writer_id=writers.id and movies.imdbID = imdb_ID;
END
