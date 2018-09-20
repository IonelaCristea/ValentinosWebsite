<?php
    // Deny access to user's that are NOT logged in
    if (!$_SESSION['loggedin']) {
        //User is not logged in
        echo "<h1>Access Denied</h1>";
        header("Location: /valentinos/index.php?p=login");
        exit;
    }

    require_once('includes/db.php');

    //if the get request is called &recipe request is in the url then
    if(isset($_GET['recipe'])) {
        $recipeid = $_GET['recipe'];
    } else if(isset($_GET['recipe_id'])) { //if get request is called &id then get the id from the url get request
        $recipeid = $_GET['recipe_id'];
    }
    // fetch the recipe datails including its image
    $query = "SELECT recipes.recipe_id, recipes.recipe_name, recipes.recipe, recipes.recipe_price, recipe_image.filename
              FROM recipes INNER JOIN recipe_image ON recipes.recipe_id = recipe_image.recipe_id
              WHERE recipes.recipe_id = :recipeid";
    $pdo = $DBH->prepare($query);
    $pdo->bindParam(':recipeid', $recipeid);
    $pdo->execute();
    $recipe = $pdo->fetch(PDO::FETCH_OBJ);

    //Fetch all the reviews and name and mesage of the person that left the review
    $query = "SELECT users.user_id, users.user_name, review.message FROM users
              INNER JOIN review ON users.user_id = review.user_id
              WHERE review.recipe_id = :recipeID";
    $pdo = $DBH->prepare($query);
    $pdo->bindParam(':recipeID', $recipeid);
    $pdo->execute();
    $reviews = $pdo->fetchAll(PDO::FETCH_OBJ);

  //  var_dump($reviews);

  //Write a review
  if(isset($_POST['submit'])) {
      $message = '';
      if(isset($_POST['message'])){
        $query = "INSERT INTO review (message, user_id, recipe_id) VALUES (:message, :userid, :recipeid)";
        $insertRecipe = $DBH->prepare($query);
        $insertRecipe->bindParam(':message', $_POST['message']);
        $insertRecipe->bindParam(':userid', $_SESSION['userData']['user_id']);
        $insertRecipe->bindParam(':recipeid', $_GET['recipe_id']);
        $insertRecipe->execute();
      }
  }
?>

<link rel="stylesheet" type="text/css" href="/css/style.css">
<link type="text/css" rel="stylesheet" href="style.css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>


 <!-- View details of the selected recipe  -->
<div class="container">

<section>
<div class="container py-2">
  <div class="card text-center">
    <h2 class="m-4">Menu</h2>
    <?php if($recipe): ?>
      <div class="my-3">
        <div class="row">
          <div class="col-md-4">
              <div class="ml-2">
              <img  class="img-thumbnail"  src="img/uploads/<?php echo $recipe->filename  ?>"/>
              </div>
            </div>
          <div class="col-md-8 px-3">
            <div class="card-block px-3">
              <h4 class="card-title mb-2"><?php echo $recipe->recipe_name; ?></h4>
              <p class="card-text"><?php echo $recipe->recipe; ?> </p>
              <h6 class="card-text text-center"> £ <?php echo $recipe->recipe_price; ?></h6>
              <div class="box-result">
              	<?php
                //SELECT recipes.recipe_id, recipes.recipe_name, recipes.recipe, recipes.recipe_price, recipe_image.filename FROM recipes INNER JOIN recipe_image ON recipes.recipe_id = recipe_image.recipe_id WHERE recipes.recipe_id = :recipeid";
                $query = "SELECT star.id, star.ip, star.rate, star.dt_rated, users.user_id, recipes.recipe_id
                          FROM star
                          INNER JOIN users
                          ON users.user_id = star.user_id
                          INNER JOIN recipes
                          ON recipes.recipe_id = star.recipe_id
                          WHERE star.recipe_id = :recipeID";
                    $pdo = $DBH->prepare($query);
                    $pdo->bindParam(':recipeID', $recipeid);
                    $pdo->execute();
                      	while($data = $pdo->fetchAll(PDO::FETCH_ASSOC)){
                              $rate_db[] = $data;
                              $sum_rates[] = $data['rate'];
                          }
                          if(@count($rate_db)){
                              $rate_times = count($rate_db);
                              $sum_rates = array_sum($sum_rates);
                              $rate_value = $sum_rates/$rate_times;
                              $rate_bg = (($rate_value)/5)*100;
                          }else{
                              $rate_times = 0;
                              $rate_value = 0;
                              $rate_bg = 0;
                          }
                  ?>
                    <div class="result-container">
                    	<div class="rate-bg" style="width:<?php echo $rate_bg; ?>%"></div>
                        <div class="rate-stars"></div>
                    </div>
                    <p style="margin:5px 0px; font-size:16px; text-align:center">Rated <strong><?php echo substr($rate_value,0,3); ?></strong> out of <?php echo $rate_times; ?> Review(s)</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php endif; ?>
    </div>

    <!-- Review stars rating -->
    <p style="text-align:center; color:#fff;font-size:20px; margin:0px">Including Update Rating</p>
    <?php
        $post_id = '1'; // yor page ID or Article ID
    ?>
    <div class="container">
    	<div class="rate">
    		<div id="1" class="btn-1 rate-btn"></div>
        <div id="2" class="btn-2 rate-btn"></div>
        <div id="3" class="btn-3 rate-btn"></div>
        <div id="4" class="btn-4 rate-btn"></div>
        <div id="5" class="btn-5 rate-btn"></div>
    	</div>
    </div>
    <br><br><br>
    <!-- Review message form -->
    <div class="container">
      <form class="" action="" method="post">
        <div class="form-group">
          <input type="text" class="form-control" name="message" placeholder="Message">
        </div>
        <input class="btn btn-secondary btn-sm" type="submit" name="submit" value="submit">
      </form>
    </div>
    <br><br>
    <!-- Display the name of the person that left a message and its message -->
    <div class="container">
      <h3>Reviews</h3>
      <br>
      <?php foreach ($reviews as $review): ?>
      <dl>
        <dd>by:<strong> <?php echo $review->user_name ?></strong></dd>
        <dd><?php echo $review->message ?> </dd>
        <?php endforeach; ?>
      </dl>
      <br>
    </div>
</section>
</div>
