<?php require('templates/header.php'); ?>

	<!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h2>Advanced Search</h2>
        
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
              <input type="checkbox"> Yes
              </label>
            </div>
          </div>                                   
        </div>

          <p><a class="btn btn-primary btn-md" role="button">Search</a></p>  
        
      </div>
    </div>
    

<?php require('templates/footer.php');?>