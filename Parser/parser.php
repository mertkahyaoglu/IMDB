<?php

class Parser {

	private $json,
			$movies;

	public  $id,
			$title,
			$year,
			$released,
			$runtime,

			$genres,
			$directors,
			$writers,
			$actors,
			$languages,
			$countries,

			$plot,
			$awards,
			$poster,
			$metascore,
			$rating,
			$vote;

	public function __construct(){
		
    }

    public function parse($movie) {
    	$this->id = $movie['imdbID'];
    	$this->title = $movie['Title'];
    	$this->year = substr(filter_var($movie['Year'], FILTER_SANITIZE_NUMBER_INT), 0, 4); // take first 4 numeric
    	$this->released = $movie['Released'];
    	$this->runtime = filter_var($movie['Runtime'], FILTER_SANITIZE_NUMBER_INT); // remove 'min'
		$this->genres = explode(', ', $movie['Genre']); 
		$this->directors = explode(", ", $movie['Director']);
		$this->writers = explode(', ', $movie['Writer']);

		$i = 0;
		foreach ($this->writers as $writer) {	
			$writer = preg_replace('/\(.*\)/', '', $writer);
			
			$this->writers[$i] = $writer;
			$i++;
		}

		/*
		
		*/
		$this->actors = explode(', ', $movie['Actors']);
		$this->plot = $movie['Plot'];
		$this->languages = explode(', ', $movie['Language']);
		$this->countries = explode(', ', $movie['Country']);
		$this->poster = $movie['Poster'];
		$this->metascore = $movie['Metascore'];
		$this->rating = $movie['imdbRating'];
		$this->vote = str_replace(',', '', $movie['imdbVotes']); // e.g convert 1,299 to 1299. otherwise db error occurs.
    }

}

?>