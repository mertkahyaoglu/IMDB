<?php require('templates/header.php'); ?>

	<!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h2>Advanced Search</h2>
        
     
        <p><a class="btn btn-primary btn-md" role="button">Search</a></p>
        <h2>Search by SQL</h2>
        <form name="searchsql" action="search.php" method="post" class="form-group" role="form" onsubmit="return validateForm('searchsql', 'sql')">
            <div class="row">
              <div class="col-lg-11">
              	<input type="text" placeholder="Search by SQL command" class="form-control" name="sql">	
              </div>
              <div class="col-lg-1">
              	<button name="btn_searchsql" type="submit" class="btn btn-success"><span class="glyphicon glyphicon-search"></span></button>	
              </div>
            </div>
        </form>
      </div>
    </div>
    

<?php require('templates/footer.php');?>