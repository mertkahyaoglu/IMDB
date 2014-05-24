<?php require('templates/header.php'); require('core/init.php');?>

	<!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h2>Advanced Search</h2>
        
        <div class="row">
          <div class="col-sm-2">
            <h4>Year</h4>
            <select name="year" class="form-control">
              <option selected="selected">Year</option>
              <?php
                foreach (getFields("getYears", "") as $year) {
                  echo "<option value='{$year['year']}'>{$year['year']}</option>";  
                }
              ?>
            </select>
          </div>
          <div class="col-sm-2">
            <h4>Genre</h4>
            <select class="form-control">
              <option selected="selected">Genre</option>
              <?php
                foreach (getFields("getGenres", "") as $genre) {
                  echo "<option value='{$genre['genre']}'>{$genre['genre']}</option>";  
                }
              ?>
            </select>
          </div>
          <div class="col-sm-2">
            <h4>Country</h4>
            <select class="form-control">
              <option selected="selected">Country</option>
              <?php
                foreach (getFields("getCountries", "") as $con) {
                  echo "<option value='{$con['country']}'>{$con['country']}</option>";  
                }
              ?>
            </select>
          </div> 
          <div class="col-sm-2">
            <h4>Language</h4>
            <select class="form-control">
              <option selected="selected">Language</option>
              <?php
                foreach (getFields("getLanguages", "") as $lan) {
                  echo "<option value='{$lan['language']}'>{$lan['language']}</option>";  
                }
              ?>
            </select>
          </div> 
          <div class="col-sm-2">
            <h4>Oscar</h4>
            <div class="checkbox">
              <label>
              <input type="checkbox"> Yes
              </label>
            </div>
          </div>                                   
        </div>

          <p><a class="btn btn-primary btn-md" role="button">Search</a></p>  
        
      </div>
    </div>
    

<?php require('templates/footer.php');?>