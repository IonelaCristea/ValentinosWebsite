<?php
  require_once('includes/db.php');

    if($_POST['act'] == 'rate'){
    	$ip = $_SERVER["REMOTE_ADDR"];
    	$therate = $_POST['rate'];
    	$thepost = $_POST['post_id'];

      $query = "SELECT * FROM star WHERE ip= ':ip' ";
      $pdo = $DBH->prepare($query);
      $result->bindParam(':ip', $_POST['ip']);
      $pdo->execute();
          while($data = $pdo->fetch(PDO::FETCH_ASSOC)){
                $rate_db[] = $data;


    	if(@count($_POST['rate_db']== 0 ){
    	     $query = "INSERT INTO star (id_post, ip, rate) VALUES (:thepost, :ip, :therate)";
           $result = $DBH->prepare($query);
           $result->bindParam(':thepost', $_POST['thepost']);
           $result->bindParam(':ip', $_POST['ip']);
           $result->bindParam(':therate', $_POST['therate']);
           $result->execute();

    	}else{
    		$query = "UPDATE star SET rate= :thepost WHERE ip = ':ip'";
    	}
    }


?>
