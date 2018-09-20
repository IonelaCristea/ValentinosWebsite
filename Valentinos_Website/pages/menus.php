<!-- Public menu page -->

<script src="js/recipe.js"></script>
<script src="js/index.js"></script>

<div id="pageContainer" class="container">
    <?php
    //Fetch the receipe details and its image
      $query = "SELECT recipes.recipe_id, recipes.recipe_name, recipes.recipe, recipes.recipe_price, recipe_image.filename FROM recipes INNER JOIN recipe_image ON recipes.recipe_id = recipe_image.recipe_id"; // WHERE recipe_id = :recipeid
      $pdo = $DBH->prepare($query);
      $pdo->execute();

      $recipes = $pdo->fetchAll(PDO::FETCH_OBJ);
      //var_dump($recipes);
    ?>
    <!-- Display each receipe details: image, name, info, price-->
    <section>
    <div class="container py-2">
      <div class="card text-center">
        <h1 class="m-4">Menu</h1>
        <?php foreach($recipes as $recipe): ?>
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
                  <a class="editButton btn btn-secondary btn-sm" data-href="index.php?p=viewRecipe&recipe_id=<?php echo $recipe->recipe_id; ?>" >View</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
        </div>
      </div>
    </section>
</div>
