DELIMITER $$

CREATE PROCEDURE `getGenres`(IN iid CHAR(9))
BEGIN
	SELECT genre FROM movies m, movie_genre mg, genres g 
	WHERE m.id = mg.movie_id and mg.genre_id = g.id and m.imdbID = iid;
END

DELIMITER $$

CREATE PROCEDURE `getMovieActors`(IN imdb_ID VARCHAR(9))
BEGIN
	SELECT name FROM actors, movies, movie_cast WHERE movies.id = movie_cast.movie_id and movie_cast.actor_id = actors.id and movies.imdbID = imdb_ID;
END

DELIMITER $$

CREATE PROCEDURE `getMovieDirectors`(IN imdb_ID VARCHAR(9))
BEGIN
	SELECT name FROM directors, movies, movie_director WHERE directors.id = movie_director.director_id and movie_director.movie_id = movies.id and movies.imdbID = imdb_ID;
END

DELIMITER $$

CREATE PROCEDURE `getMoviePlot`(IN imdb_ID VARCHAR(9))
BEGIN
	SELECT plot FROM plots, movies WHERE plots.movie_id = id and movies.imdbID = imdb_ID;

END

DELIMITER $$

CREATE PROCEDURE `getMoviePoster`(IN imdb_ID VARCHAR(9))
BEGIN
	SELECT url FROM posters, movies WHERE posters.movie_id = movies.id and movies.imdbID = imdb_ID  ;
END

DELIMITER $$

CREATE PROCEDURE `getMovieStats`(IN imdb_ID VARCHAR(9))
BEGIN
	SELECT imdb_rating, imdb_votes, imdb_metascore FROM stats,movies WHERE stats.movie_id = movies.id and movies.imdbID = imdb_ID;
END

DELIMITER $$

CREATE PROCEDURE `getMovieWriters`(IN imdb_ID VARCHAR(9))
BEGIN
	SELECT name FROM writers, movie_writer, movies WHERE movies.id = movie_writer.movie_id and movie_writer.writer_id=writers.id and movies.imdbID = imdb_ID;
END

DELIMITER $$

CREATE PROCEDURE `getMovieCountries`(IN imdb_ID VARCHAR(9))
BEGIN
	SELECT country FROM countries, movies, movie_country WHERE movies.id = movie_country.movie_id and movie_country.country_id = countries.id and movies.imdbID = imdb_ID;
END
