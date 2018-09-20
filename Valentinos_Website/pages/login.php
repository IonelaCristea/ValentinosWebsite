<?php
// if the user is loggedin redirect him to the menus page
if($_SESSION['loggedin'] == true){
    header("Location: /valentinos/index.php?p=menus");
}
// if email/pasword not set:error message
if (isset($_POST['email']) || isset($_POST['password'])) {
    if (!$_POST['email'] || !$_POST['password']) {
        $error = "Please enter an email and password";
    }

    if (!$error) {
        //No errors - lets get the users account
        // Select the user based on the provided email address.
        $query = "SELECT * FROM users WHERE user_email = :email";
        $result = $DBH->prepare($query);
        $result->bindParam(':email', $_POST['email']);
        $result->execute();

        $row = $result->fetch(PDO::FETCH_ASSOC);

        if ($row) {
                //If the user exists - let’s check the password
            if(password_verify($_POST['password'], $row['user_password'])) {
                $_SESSION['loggedin'] = true;
                $_SESSION['userData'] = $row;

                echo "<script> window.location.assign('index.php?p=dashboard'); </script>";
            } else {
                $error = "Username/Password Incorrect";
            }

        } else {
            $error = "debug Username/Password Incorrect";
        }
    }
}
?>
<!-- Create the login form -->
<div class="card container mt-5">
    <div class="card-body">
        <h3 class="mb-3">Login to your account</h3>
        	<!-- The action of the form is in the same page -->
        <form action="index.php?p=login" method="post">
            <?php if($error){
            echo '<div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>
            '.$error.'
            </div>';
            } ?>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="password">
            </div>
            <button type="submit" class="btn btn-default">Login</button>
        </form>
    </div>
</div>
