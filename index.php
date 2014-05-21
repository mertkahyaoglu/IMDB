<?php require('templates/header.php'); ?>

	<!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h2>Advanced Search</h2>
        
<<<<<<< HEAD
        <div class="row">
          <div class="col-sm-2">
            <h4>Year</h4>
            <select class="form-control">
              <option value="one">One</option>
              <option value="two">Two</option>
              <option value="three">Three</option>
              <option value="four">Four</option>
              <option value="five">Five</option>
            </select>
          </div>
          <div class="col-sm-2">
            <h4>Genre</h4>
            <select class="form-control">
              <option value="one">One</option>
              <option value="two">Two</option>
              <option value="three">Three</option>
              <option value="four">Four</option>
              <option value="five">Five</option>
            </select>
          </div>
          <div class="col-sm-2">
            <h4>Runtime</h4>
            <select class="form-control">
              <option value="one">One</option>
              <option value="two">Two</option>
              <option value="three">Three</option>
              <option value="four">Four</option>
              <option value="five">Five</option>
            </select>
          </div> 
          <div class="col-sm-2">
            <h4>Oscar</h4>
            <div class="checkbox">
              <label>
              <input type="checkbox"> Yes</input>
              </label>
            </div>
          </div>                                   
        </div>

        <div>
          <p><a class="btn btn-primary btn-md pull-right" role="button">Search</a></p>  
        </div>
  
=======
     
        <p><a class="btn btn-primary btn-md" role="button">Search</a></p>
>>>>>>> 643f952987283411bd64130b8b80da6d677dffe1
        <h2>Search by SQL</h2>
        <form name="searchsql" action="search.php" method="post" class="form-group" role="form" onsubmit="return validateForm('searchsql', 'sql')">
            <div class="row">
              <div class="col-lg-11">
<<<<<<< HEAD
              	<input type="text" placeholder="Search a movie by SQL command" class="form-control" name="sql">	
=======
              	<input type="text" placeholder="Search by SQL command" class="form-control" name="sql">	
>>>>>>> 643f952987283411bd64130b8b80da6d677dffe1
              </div>
              <div class="col-lg-1">
              	<button name="btn_searchsql" type="submit" class="btn btn-success"><span class="glyphicon glyphicon-search"></span></button>	
              </div>
            </div>
        </form>
      </div>
    </div>
    

<?php require('templates/footer.php');?>