<?php require('templates/header.php'); require('core/init.php'); load();?>

    <div class="jumbotron">
      <div class="container">
        <h2>Advanced Search</h2>
        <form name="asearch" action="search.php" method="post" role="form">
            <div class="form-group">
                
              <div class="row">
                <div class="col-sm-2">
                  <h4>Year</h4>
                  <select name="year" class="form-control">
                    <option value="" disabled selected>Year</option>
                    <?php
                      foreach (getFields("getYears", "") as $year) {
                        echo "<option value='{$year['year']}'>{$year['year']}</option>";  
                      }
                    ?>
                  </select>
                </div>

                <div class="col-sm-2">
                  <h4>Genre</h4>
                  <select name="genre" class="form-control">
                    <option value="" disabled selected>Genre</option>
                    <?php
                      foreach (getFields("getGenres", "") as $genre) {
                        echo "<option value='{$genre['genre']}'>{$genre['genre']}</option>";  
                      }
                    ?>
                  </select>
                </div>

                <div class="col-sm-2">
                  <h4>Country</h4>
                  <select name="country" class="form-control">
                    <option value="" disabled selected>Country</option>
                    <?php
                      foreach (getFields("getCountries", "") as $con) {
                        echo "<option value='{$con['country']}'>{$con['country']}</option>";  
                      }
                    ?>
                  </select>
                </div> 

                <div class="col-sm-2">
                  <h4>Language</h4>
                  <select name="language" class="form-control">
                    <option value="" disabled selected>Language</option>
                    <?php
                      foreach (getFields("getLanguages", "") as $lan) {
                        echo "<option value='{$lan['language']}'>{$lan['language']}</option>";  
                      }
                    ?>
                  </select>
                </div> 

              </div>
                <button name="btn_asearch" type="submit" class="btn btn-primary">Search</button>
            </div>
            
        </form>
        
      </div>
    </div>
    
<?php require('templates/footer.php');?>