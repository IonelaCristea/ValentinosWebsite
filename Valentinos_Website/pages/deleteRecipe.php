<?php
    require_once('includes/db.php');

    // delete a recepie
    if(isset($_GET['recipe'])){
        $id =  $_GET['recipe'];
        $query = "DELETE FROM recipes WHERE recipe_id = :recipeid";
        $result = $DBH->prepare($query);
        $result->bindParam(':recipeid', $id);
        $result->execute();

        //if no errors a successful message
        if($result) {
          echo "Recipe Delted";
        } else {
          //else an error message
          echo "Sorry, failed to delte recipe, please try again";
        }
    }
?>
