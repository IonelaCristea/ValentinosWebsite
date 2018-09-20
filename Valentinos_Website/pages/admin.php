<?php
  require_once('includes/db.php');

 // if the uer is not an admin redirect it to Menu page
 if(!$_SESSION['userData']['user_type'] == 1) {
       header("Location: /valentinos/index.php?p=menus");
 }

 ?>
 <div class="header text-center">
 <h1 class="m-4">Welcome Admin! </h1>
 </div>
