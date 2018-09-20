<?php
  require_once('../includes/db.php');
var_dump ($_GET['recipe_id']);

    if($_POST['act'] == 'rate'){
    	$ip = $_SERVER["REMOTE_ADDR"];
    	$therate = $_POST['rate'];
    	$thepost = $_POST['id_post'];

      $query = "SELECT * FROM star WHERE ip = :ip";
      $result = $DBH->prepare($query);
      $result->bindParam(':ip', $ip);
      $result->execute();
      $row = $result->fetch(PDO::FETCH_ASSOC);
    	while($data = $result->fetch(PDO::FETCH_ASSOC)){
    		$rate_db[] = $data;
    	}

    	if(@count($rate_db) == 0 ){
        $query = "INSERT INTO star (id_post, ip, rate, dt_rated, recipe_id, user_id)
                            VALUES (:id_post, :ip, :rate, :dt_rated, :recipe_id, :user_id)";
                            $result->bindParam(':id_post', $thepost);
                            $result->bindParam(':ip', $ip);
                            $result->bindParam(':dt_rated', $dt_rated);
                            $result->bindParam(':recipe_id', $_GET['recipe_id']);
                            $result->bindParam(':user_id', $_SESSION['userData']['user_id'])
                            $result->execute();
    	}else{
        // $query = "UPDATE star SET rate = :rate WHERE ip = :ip";
        $query = "UPDATE star SET rate = :rate, dt_rated = :dt_rated
        WHERE ip = :ip, recipe_id = :recipe_id, user_id = :user_id";
    	}
      $result = $DBH->prepare($query);
      if(@count($rate_db) == 0 ){
        $result->bindParam(':id_post', $thepost);
        $result->bindParam(':ip', $ip);
        $result->bindParam(':dt_rated', $dt_rated);
        $result->bindParam(':recipe_id', $_GET['recipe_id']);
        $result->bindParam(':user_id', $_SESSION['userData']['user_id'])
        $result->execute();
      }
    }
?>
