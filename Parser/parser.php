<?php

class Parser {

	private $json,
			$movies;

	public  $id, $title, $year, $released, $runtime,
			$genres, $directors, $writers, $actors, $languages, $countries,
			$plot, $awards, $poster, $metascore, $rating, $vote, $stats;

    public function parse($movie) {
    	$this->id = $movie['imdbID'];
    	$this->title = $movie['Title'];
    	$this->year = substr(filter_var($movie['Year'], FILTER_SANITIZE_NUMBER_INT), 0, 4); // take first 4 numeric
    	$this->released[] = date_parse($movie['Released'])['year'];
    	$this->released[] = date_parse($movie['Released'])['month'];
    	$this->released[] = date_parse($movie['Released'])['day'];
    	$this->released = implode("-", $this->released);
    	$this->runtime = filter_var($movie['Runtime'], FILTER_SANITIZE_NUMBER_INT); // remove 'min'
		$this->genres = explode(', ', $movie['Genre']); // split by comma and make it array
		$this->directors = explode(", ", $movie['Director']); //split by comma and make it array
		$this->writers = explode(', ', $movie['Writer']); //split by comma and make it array

		$i = 0;
		foreach ($this->writers as $writer) {	
			$writer = preg_replace('/\(.*\)/', '', $writer); //some writers have explanation like (screenplay, etc.) remove them
			$this->writers[$i] = $writer;
			$i++;
		}

		$this->awards = substr($movie['Awards'], 0, -1); //remove dot at the end
		$mawards = [];
		$this->awards = explode(".", $this->awards); //split by dot
		if(count($this->awards) > 1) {
			foreach ($this->awards as $sentence) {
				if (preg_match('/Won/',$sentence)) {
					 preg_match_all('/Won ([\d]+)/',$sentence,$matches); //if sentence has Won,it means has Oscar, take numeric value
					 $mawards['Oscar'] = $matches[1][0];
				}
				if (preg_match('/&/',$sentence)) {
					$sentence = explode("&", $sentence);
					preg_match_all('/Another ([\d]+)/',$sentence[0],$matches);
					$mawards['Win'] = $matches[1][0];
				    preg_match_all('/([\d]+) nomination/',$sentence[1],$matches);
					$mawards['Another'] = $matches[1][0];
				}
			}
		}else {
			if (preg_match('/&/',$this->awards[0])) {
					$sentence = explode("&", $this->awards[0]);
					preg_match_all('/([\d]+) win/',$sentence[0],$matches);
					$mawards['Win'] = $matches[1][0];
				    preg_match_all('/([\d]+) nomination/',$sentence[1],$matches);
				    $mawards['Another'] = $matches[1][0];
			}
		}

		$this->awards['Oscar'] = isset($mawards['Oscar']) ? $mawards['Oscar'] : 0;
		$this->awards['Win'] = isset($mawards['Win']) ? $mawards['Win'] : 0;
		$this->awards['Another'] = isset($mawards['Another']) ? $mawards['Another'] : 0;

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