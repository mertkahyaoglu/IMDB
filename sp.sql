-- --------------------------------------------------------------------------------
-- getGenres
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE PROCEDURE `getGenres`(IN iid CHAR(9))
BEGIN
	SELECT genre FROM movies m, movie_genre mg, genres g 
	WHERE m.id = mg.movie_id and mg.genre_id = g.id and m.imdbID = iid;
END