<!-- Admin Page for edit/delete a menu -->

<?php
// if the user is not an admin
  if(!$_SESSION['userData']['user_type'] == 1){
    //Denied access and redirected to the view Menus page
    echo "<h1>Access Denied</h1>";
    header("Location: /valentinos/index.php?p=menus");
    exit;
  }
?>
<script src="js/recipe.js"></script>
<script src="js/index.js"></script>

<div id="pageContainer" class="container">
  <ul id="ValentinosApp">
    <!-- Join the Image file from the recipe_image table to the recepies table -->
    <?php
      //$pdo = "SELECT recipes.*, recipe_images.* LEFT JOIN recipe_images ON recipes.recipe_id = recipe_images.recipe_id WHERE recipes.recipe_id = :recipe_id;"
      $query = "SELECT recipes.recipe_id, recipes.recipe_name, recipes.recipe, recipes.recipe_price, recipe_image.recipe_image_id, recipe_image.filename
      FROM recipes INNER JOIN recipe_image
      ON recipes.recipe_id = recipe_image.recipe_id";
      $pdo = $DBH->prepare($query);
      $pdo->execute();
      $recipes = $pdo->fetchAll(PDO::FETCH_OBJ);
    ?>

    <!-- Section that contain the Menu -->
    <!-- This section echo the data reciepe details: image, name, recepie, price -->
    <div class="header text-center">
    <h1 class="m-4">Edit and Delete a recipe here!</h1>
    </div>
    <section>
      <div class="container py-2">
        <div class="card text-center">
          <h2 class="m-4">Menu</h2>
          <?php foreach($recipes as $recipe): ?>
              <div class="my-3">
                <div class="row">
                  <div class="col-md-4">
                      <div class="ml-2">
                        <img  class="img-thumbnail"  src="img/uploads/<?php echo $recipe->filename ?>"/>
                      </div>
                    </div>
                    <div class="col-md-8 px-3">
                      <div class="card-block px-3">
                        <h4 class="card-title mb-2"><?php echo $recipe->recipe_name; ?></h4>
                        <p class="card-text"><?php echo $recipe->recipe; ?> </p>
                        <h6 class="card-text text-center"> £ <?php echo $recipe->recipe_price; ?></h6>
                        <!-- Edit/Delete buttons redirects the edit/delete the recepie depending on its id
                        The buttons'action is redireced to edit/delete page  -->
                        <a class="editButton btn btn-secondary btn-sm" data-href="index.php?p=editRecipe&id=<?php echo $recipe->recipe_id; ?>" >Edit</a>
                        <a class="deleteButton btn btn-secondary btn-sm" data-href="index.php?p=deleteRecipe&recipe=<?php echo $recipe->recipe_id; ?>">Delete</a>
                      </div>
                    </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
    </section>
  </ul>
</div>
