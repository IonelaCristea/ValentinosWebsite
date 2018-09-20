<?php

    // Deny access to user's that are NOT logged in
    if (!$_SESSION['loggedin']) {
        //User is not logged in
        echo "<h1>Access Denied</h1>";
        echo "<script> window.location.assign('index.php?p=login'); </script>";
        exit;
    }

  // if is not admin deny Access
  include("admin.php");
  if(isset($_POST['submit']) ) {
    $message = '';
    if(isset($_POST['recipeName']) && isset($_POST['recipe'])&& isset($_POST['price'])){
      $query = "INSERT INTO recipes (recipe_name, recipe, recipe_price)
                VALUES (:recipeName, :recipe, :price)";
      $insertRecipe = $DBH->prepare($query);
      $insertRecipe->bindParam(':recipeName', $_POST['recipeName']);
      $insertRecipe->bindParam(':recipe', $_POST['recipe']);
      $insertRecipe->bindParam(':price', $_POST['price']);
      $insertRecipe->execute();
    }

      //Get the id of the recipe just inserted
      $recipe_last_id = $DBH->lastInsertId();
      //Example: https://www.w3schools.com/php/php_file_upload.asp
      //Upload the image to img/uploads directory
      $target_dir = "img/uploads/";
      //Get the name of the uploaded file with the tag directory
      $target_file = $target_dir . basename($_FILES["image"]["name"]);
      //Get the extetion of the file
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

      // Check if image file is a actual image or fake img
       if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";

        }
      }

    // Check if file already exists in the directory
    if (file_exists($target_file)) {
        echo "This image was used for an other dish!";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["image"]["size"] > 50000000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }
    // Allow jpg, png jpeg file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }
    //If everithing is ok. If so upload the image and the recepie details to the DB
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $query = "INSERT INTO recipe_image (recipe_id, filename) VALUES (:recipeID, :fileName)";
        $res = $DBH->prepare($query);
        $res->bindParam(':recipeID', $recipe_last_id);
        $res->bindParam(':fileName', $_FILES["image"]["name"]);

        // If the data was inserted successfully alert confirmation
        if($res->execute()) {
            $message = 'The image and recipe information was inserted successfully!';
        }
        } else {
            $message =  "Sorry, there was an error uploading your file.";
        }
    }
?>

<div class="container">
  <div class="card mt-5">
    <div class="card-header">
      <h3>Add a recipe here</h3>
    </div>
    <div class="card-body">
      <!-- <form action="index.php?p=dashboard" method="post"></form> -->
      <!-- If the data was inserted successfully alert confirmation -->
      <?php if(!empty($message)): ?>
        <div class="alert alert-success">
          <?php echo $message; ?>
        </div>
        <?php endif; ?>
      <form method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="recipeName">Recipe Name</label>
          <input type="text" name="recipeName" id="recipeName" class="form-control">
        </div>
        <div class="form-group">
          <label for="recipe">Recipe</label>
          <input type="text" name="recipe" id="recipe" class="form-control" placeholder="enter the ingredients">
        </div>
        <div class="form-group">
          <label for="price">Recipe Price</label>
          <input type="number" step="any" name="price" id="price" class="form-control" placeholder="0.00">
        </div>
          Select image to upload:
        <input type="file" name="image">
        <br><br>
        <div class="form-group">
          <button type="submit" name="submit" class="btn btn-info">Create recipe</button>
        </div>
      </form>
    </div>
  </card>
</div>
