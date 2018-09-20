<?php
  // Check if any values were entered in email and password field
	if(isset($_POST['email']) || isset($_POST['password'])){

		//If inputs left blank
		if(!$_POST['email'] || !$_POST['password']){
			$error = "Please enter an email and password";
		}

		// if the name is something else than Leters
		if (!preg_match('/^[A-Za-z]+$/', $_POST['name'])){
					$error = "Please enter a name starting with a capital later!";
		}

		//if the surname is something else than letters
	 if (!preg_match('/^[A-Za-z]+$/', $_POST['surname'])){
			$error = "Please enter a valid surname";
		}

		//validate the email address
		$email = ($_POST['email']);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		  $error = "Invalid email format";
		}
		//if the pasword lenght is less than characters
		if (strlen($_POST['password']) < 6) {
			$error = "The password length must be more than 6 characters";
		}

		if(!$error){
    //No errors - let’s create the account
    //Encrypt the password with a salt
    $encryptedPass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    //Insert DB
    $query = "INSERT INTO users (user_email, user_password, user_name, user_surname, user_address, user_city, user_phone) VALUES (:email, :password, :name, :surname, :address, :city, :mobile)";
    $result = $DBH->prepare($query);
    $result->bindParam(':email', $_POST['email']);
    $result->bindParam(':password', $encryptedPass);
		$result->bindParam(':name', $_POST['name']);
		$result->bindParam(':surname', $_POST['surname']);
		$result->bindParam(':address', $_POST['placesSearch']);
		$result->bindParam(':city', $_POST['citySearch']);
		$result->bindParam(':mobile', $_POST['mobile']);
    $result->execute();

    // $to = $_POST['email'];
    // $subject = "Welcome to Valentinos Restaurant";
		//
    // $message = "
    // <html>
    // <head>
    // <title>Welcome to Valentinos Restaurant</title>
    // </head>
    // <body>
    // <p>Welcome to Valentinos Restaurant Application!</p>
    // </body>
    // </html>";

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // // More headers
    $headers .= 'From: <crii1_15@uni.worc.ac.uk>' . "\r\n";

    mail($to,$subject,$message,$headers);

    // // Textlocal account details
    // $username = 'sean.preston@worc.ac.uk';
    // $hash = '2578a4c767fbea1519b176fb9e748ff3f574a0952efbac43d7a151598ba30923';
		//
		// Message details
		// $numbers = $_POST['mobile'];
		// $sender = urlencode('Valentinos Restaurant');
		// $message = rawurlencode('Welcome to Valentinos Restaurant App!');
		//
		// // Prepare data for POST request
		// $data = array('username' => $username, 'hash' => $hash, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
		//
		// // Send the POST request with cURL
		// $ch = curl_init('http://api.txtlocal.com/send/');
		// curl_setopt($ch, CURLOPT_POST, true);
		// curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// $response = curl_exec($ch);
		// curl_close($ch);


    echo "<script> window.location.assign('index.php?p=registersuccess'); </script>";
  }

	}

?>
<!-- Registration form -->
<div class="container">
<h3>Register</h3>
	<!-- Submit to the register.php -->
	<form action="index.php?p=register" method="post">

		<?php if($error){
			echo '<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>' . $error . '</div>';
		} ?>
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" class="form-control" id="name" name="name" placeholder="e.g. John">
		</div>
		<div class="form-group">
			<label for="name">Surname</label>
			<input type="text" class="form-control" id="surname" name="surname" placeholder="e.g. Brown">
		</div>
		<div class="form-group">
			<label for="email">Email address</label>
			<input type="email" class="form-control" id="email" name="email" placeholder="email">
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" class="form-control" id="password" name="password" placeholder="password">
		</div>

		<div class="form-group">
			<label for="text">Mobile Number</label>
			<input type="text" class="form-control" id="mobile" name="mobile" placeholder="01234123123">
		</div>

		<div class="form-group">
            <label for="text">Address</label>
            <input type="text" class="form-control" id="placesSearch" name="placesSearch">
    </div>
		<div class="form-group">
            <label for="text">City</label>
            <input type="text" class="form-control" id="citySearch" name="citySearch">
    </div>
		<div class="form-group">
				<label for="text">Address</label>
				<input type="text" name="adressAPI" class="form-control" id="placesSearch">
		</div>
		<div class="form-group">
		<button type="submit" class="btn btn-default">Register</button>
	</form>
</div>

<script src="js/register.js"></script>
