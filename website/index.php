<?php
	
// Import the application classes
require_once('include/classes.php');

// Create an instance of the Application class
$app = new Application();
$app->setup();

// Declare an empty array of error messages
$errors = array();

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Chattersquawks</title>
	<meta name="description" content="Mary Kuehne's personal website for IT5236">
	<meta name="author" content="Mary Kuehne">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.grey-light_green.min.css" />
	<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	
		<style>

		.demo-layout-transparent .mdl-layout__header {
			background: url('banner.jpg') center / cover;
			repeat: no-repeat;
			min-height: 24vh;
			width: 100vw;
		}
		
		.demo-layout-transparent, .mdl-layout__header, .mdl-layout__drawer-button {
			/* This background is dark, so we set text to white. Use 87% black instead if
     		your background is light. */
			color: white;
		}

</style>
	
	
</head>
<body>
	<div class="mdl-layout mdl-js-layout">
		<?php include 'include/header.php'; ?>
		<main class="mdl-layout__content">
  			<div class="mdl-grid">
				<div class="mdl-layout-spacer"></div> <!-- SPACE -->
				<div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
					<h2 class = "mdl-color-text--light-green-700">Flock Together!</h2>
					<p>Welcome to <i class ="mdl-color-text--light-green-800">Chattersquawks</i>. In order to view and access the list, you must be logged in to your account. If you are not a member, please register a new account.</p>
				</div>
				<div class="mdl-layout-spacer"></div> <!-- SPACE -->
			</div>
			<div class="mdl-grid">
  				<div class="mdl-layout-spacer"></div> <!-- SPACE -->
  				<div class="mdl-cell mdl-cell--2-col">
					<!-- Accent-colored raised button with ripple -->
					<form>
						<a class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent mdl-color--light-green-400 mdl-color-text--grey-50" href="register.php">Register</a>
					</form>
				</div>
  				<div class="mdl-cell mdl-cell--2-col">
  					<!-- Accent-colored raised button with ripple -->
					<form>
						<a class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent mdl-color--red-400 mdl-color-text--grey-50" href="login.php">Login</a>
					</form>
  				</div>
				<div class="mdl-layout-spacer"></div> <!-- SPACE -->
			</div>  
  		</main>
  
  		<?php include 'include/footer.php'; ?>
  
  	</div>
		<script src="js/site.js"></script>
</body>
</html>
