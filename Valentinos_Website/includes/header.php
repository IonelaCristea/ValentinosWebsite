<!doctype html>

<html lang="en">
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/style.css">
<head>
	<title> Valentinos Restaurant</title>
	<meta property="og:site_name" content="Page made by Valentinos" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="http://cristea.worcestercomputing.com/valentinos/" />
	<meta property="og:image" content="http://cristea.worcestercomputing.com/valentinos/img/pizza.jpg" />
	<meta property="og:description" content="Valentinos is an Italian Restaurant based in Worcester. Here you can find Pizza, Pasta, Italian Soup and much more."/>
	<meta charset="utf-8
	<meta name="description" content="Valentinos Restaurant is a Italian Restaurant located in Worcester City">
	<meta name="keywords" content="Restaurant, Worcester, Italian food, pizza, pasta, dinner">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAK1lG5571tVGsv7JgPLjwB-fEWKZhHk-M&libraries=places"></script>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<a class="navbar-brand" href="index.php?p=home">
			 <img src="img/logo_2.gif" width="90" height="80" class="d-inline-block align-top" alt="Valentinos Logo">
		 </a>
	    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="navbar-toggler-icon"></span>
	    </button>
	    <div class="collapse navbar-collapse" id="navbarSupportedContent">
	        <ul class="navbar-nav mr-auto">
	            <li class="nav-item active">
	                <a class="nav-link" href="index.php?p=home">Home <span class="sr-only">(current)</span></a>
	            </li>
							<!-- Show the Added menu page with Edit and Delete recipe only to the Admin -->
							<?php if ($_SESSION['userData']['user_type'] == 1): ?>
								<li class="nav-item">
										<a class="nav-link" href="index.php?p=addedMenus"> Added Menus </a>
								</li>
								<!-- Show the Added recipe page only to the Admin -->
								<li class="nav-item">
										<a class="nav-link" href="index.php?p=dashboard"> Add recipe </a>
								</li>
							<?php endif; ?>
							<li class="nav-item">
									<a class="nav-link" href="index.php?p=menus"> Menus </a>
							</li>
							<li class="nav-item">
									<a class="nav-link" href="index.php?p=aboutUs"> About Us </a>
							</li>
	        </ul>
					<ul class="navbar-nav navbar-right">
	  			<!-- If the user is logged in display Logout button -->
           <?php if($_SESSION['loggedin']){ ?>
               <li class="nav-item"><a class="nav-link" href="index.php?p=logout">Logout</a></li>
           <?php }else{ ?>
						   <!-- Otherwise display Login and Register button -->
               <li class="nav-item"><a class="nav-link" href="index.php?p=login">Login</a></li>
               <li class="nav-item"><a class="nav-link" href="index.php?p=register">Register</a></li>
           <?php } ?>
				 </ul>
	    </div>
	</nav>
	<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> -->
	<!-- <script type="text/javascript" src="AIzaSyAz8Rzal94h11oV9iFFLBkkGGGPotgzA-s"></script> -->
