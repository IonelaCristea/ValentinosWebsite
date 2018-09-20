<?php
    // if the user is not an admin
    if(!$_SESSION['userData']['user_type'] == 1){
      //Denied access and redirected to the view Menus page
      echo "<h1>Access Denied</h1>";
      header("Location: /valentinos/index.php?p=menus");
        exit;
      }

    require_once('includes/db.php');

    //if the get request is called & recipe request is in the url then
    if(isset($_GET['recipe'])) {
        $recipeid = $_GET['recipe'];
    } else if(isset($_GET['id'])) { //if get request is called &id then get the id from the url get request
        $recipeid = $_GET['id'];
    }
    // edit the recepie depending on the recipe id
    // join the recipes and recipe_image tables
    $query = "SELECT recipes.recipe_id, recipes.recipe_name, recipes.recipe, recipes.recipe_price, recipe_image.filename FROM recipes INNER JOIN recipe_image ON recipes.recipe_id = recipe_image.recipe_id WHERE recipes.recipe_id = :recipeid";
    $pdo = $DBH->prepare($query);
    $pdo->bindParam(':recipeid', $recipeid);
    $pdo->execute();
    $recipe = $pdo->fetch(PDO::FETCH_OBJ);

    // if recipe dedatils set
    if(isset($_POST['recipeName']) && isset($_POST['recipe_info'])&& isset($_POST['price'])){
      //Example: https://www.w3schools.com/php/php_file_upload.asp
      //Upload the image to img/uploads directory
      $target_dir = "img/uploads/";
      //Get the name of the uploaded file with the tag directory
      $target_file = $target_dir . basename($_FILES["image"]["name"]);
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      //if a file hasnt been uplodaed then ignore this stuff - it caused an error
      if (!$_FILES['image']['name'] == "") {
        //Get the extetion of the file
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
          echo "File is an image - " . $check["mime"] . ".";
          $uploadOk = 1;
        } else {
          echo "File is not an image.";
        $uploadOk = 0;
        }

        // Check if file already exists in the directory
        if (file_exists($target_file)) {
          echo "This image was used for an other dish!";
        }
      }



      // Check file size
      if ($_FILES["image"]["size"] > 50000000) {
      echo "Sorry, your file is too large.";
      }
      // Allow jpg, png jpeg file formats
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      }
      //If everithing is ok. If so upload the image and the recepie details to the DB
      if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)  || isset($_POST['recipeName'])) {
      /*$query = "UPDATE recipe_image SET  filename = :fileName, recipe_id = :recipeID WHERE recipe_image_id = :recipe_image_id";
      $res = $DBH->prepare($query);
      $res->bindParam(':fileName', $_FILES["image"]["name"]);
      $res->bindParam(':recipeID', $recipe_last_id);
      $res->bindParam(':recipe_image_id', $_GET['recipe_image_id']);
      // If the data was inserted successfully alert confirmation
      if($res->execute()) {
        $message = 'The image successfully updated!';
      } else {
        $message =  "Sorry, there was an error updating your file.";
      } */

      $recipeName = $_POST['recipeName'];
      $recipe     = $_POST['recipe_info'];
      $price  = $_POST['price'];
      $filename =  $_FILES["image"]["name"];
      //update
      $query = "UPDATE recipes INNER JOIN recipe_image
                                    ON recipes.recipe_id = recipe_image.recipe_id
                                    SET recipes.recipe_name=:recipeName,
                                    recipes.recipe=:recipe,
                                    recipes.recipe_price=:price,
                                    recipe_image.filename=:filename
                                    WHERE recipes.recipe_id = :recipeid";
      $result = $DBH->prepare($query);
      $result->bindParam(':recipeName', $recipeName);
      $result->bindParam(':recipe', $recipe);
      $result->bindParam(':price', $price);
      $result->bindParam(':recipeid', $recipeid);
      $result->bindParam(':filename', $filename);
      // If the data was updated successfully alert confirmation
      if ($result->execute()) {

        echo "Recipe updated";
        echo "<script> window.location.assign('index.php?p=addedMenus'); </script>";
      //Else alert
      } else {
        echo "Failed to update recipe.";
      }
      $res->bindParam(':recipeID', $recipe_last_id);
      $res->bindParam(':fileName', $_FILES["image"]["name"]);
      //var_dump('post info'. $recipe_last_id .$_FILES["image"]["name"]);

      // If the data was inserted successfully alert confirmation
      if($res->execute()) {
          $message = 'The image and recipe information was inserted successfully!';
      }
      } else {
        $message =  "Sorry, there was an error uploading your file.";
      }
    }

?>

<!-- Container that display the recipe details that is edit it: name, ingredience,  -->
<div class="container">
  <div class="card mt-5">
    <div class="card-header">
      <h1>Update menu</h1>
    </div>
    <div class="card-body">
      <!-- If success -->
      <?php if(!empty($message)): ?>
        <div class="alert alert-success">
          <?php echo $message; ?>
        </div>
        <?php endif; ?>
      <form method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="recipeName">Recipe Name</label>
          <input value="<?php echo $recipe->recipe_name; ?>" type="text" name="recipeName" id="recipeName" class="form-control">
        </div>
        <div class="form-group">
          <label for="recipe">Recipe</label>
          <input value="<?php echo $recipe->recipe; ?>" type="text" name="recipe_info" id="recipe" class="form-control" placeholder="enter the ingredients">
        </div>
        <div class="form-group">
          <label for="price">Recipe Price</label>
          <input value="<? echo $recipe->recipe_price; ?>" type="number" step="any" name="price" id="price" class="form-control" placeholder="0.00">
        </div>
          <div class="form-group">
            <div class="col-md-3">
                <div class="ml-3">
                <img  class="img-thumbnail"  src="img/uploads/<?php echo $recipe->filename  ?>"/>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="img-recipe">Select image to replace:</label>
              <input value="<? echo $recipe->recipe_price; ?>" type="file" name="image" id="img-recipe" class="form-control">
            </div>
            <br><br><br>
        <div class="form-group">
          <button type="submit" class="btn btn-info">Update recipe</button>
        </div>
      </form>
    </div>
  </card>
</div>
