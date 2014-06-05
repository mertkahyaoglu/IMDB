<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/jquery.bxslider.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
	<title>IMDB</title>
</head>
<body>
    <div class="navbar navbar-inverse navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">IMDB Database Project</a>
        </div>
        <div class="navbar-collapse collapse">
          <form name="search" action="search.php" method="post" class="navbar-form navbar-right" role="form" onsubmit="return validateForm('search', 'movie')">
            <div class="form-group">
              <input type="text" placeholder="Search a movie" class="form-control" name="movie">
            </div>
            <button name="btn_search" type="submit" class="btn btn-success"><span class="glyphicon glyphicon-search"></span></button>
          </form>
          <form name="add" action="add.php" method="post" class="navbar-form navbar-right" role="form" onsubmit="return validateForm('add', 'imdbID')">
            <div class="form-group">
              <input type="text" placeholder="Add a movie by imdbID" class="form-control" name="imdbID">
            </div>
            <button name="btn_add" type="submit" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></button>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </div>
    <div class="container ccontainer">