<?php

// Import the application classes
require_once('include/classes.php');

// Create an instance of the Application class
$app = new Application();
$app->setup();

// Declare a set of variables to hold the username, password, question, and answer for the new user
$username = "";
$password = "";
$email = "";
$registrationcode = "";

// Declare a list to hold error messages that need to be displayed
$errors = array();

// If someone is attempting to register, process their request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Pull the username, password, question, and answer from the <form> POST
	$username = $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];
	$registrationcode = $_POST['registrationcode'];

	// Attempt to register the new user and capture the result flag
	$result = $app->register($username, $password, $email, $registrationcode, $errors);

	// Check to see if the register attempt succeeded
	if ($result == TRUE) {

		// Redirect the user to the login page on success
	    header("Location: login.php?register=success");
		exit();

	}

}

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
<!--1. Display Errors if any exists 
	2. Display Registration form (sticky):  Username, Password, Question, and Answer -->
<body>
	
	<div class="mdl-layout mdl-js-layout">
		<?php include 'include/header.php'; ?>
		
		<main class="mdl-layout__content">
  			<div class="mdl-grid">
    			<div class="mdl-layout-spacer"></div> <!-- SPACE -->
				<div class="mdl-cell mdl-cell--col-6">
					<h2 class="mdl-color-text--light-green-400">Register Account</h2>
					<?php include('include/messages.php'); ?>
				</div>
				<div class="mdl-layout-spacer"></div> <!-- SPACE -->
			</div>
			<div class="mdl-grid">
				<div class="mdl-layout-spacer"></div> <!-- SPACE -->
				<div class="mdl-cell mdl-cell--2-col">
					<form action="register.php" method="POST">
  						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input class="mdl-textfield__input" type="text" name= "username" id="username" value="<?php echo $username; ?>">
							<label class="mdl-textfield__label mdl-color-text--red-400" for="username">Username</label>
  						</div>
  	
  						<br> <!-- BREAK -->
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input class="mdl-textfield__input" type="password" name= "password" id="password">
							<label class="mdl-textfield__label mdl-color-text--red-400" for="password">Password</label>
						</div>
						
						<br> <!-- BREAK -->
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input class="mdl-textfield__input" type="text" name="email" id="email" value="<?php echo $email; ?>">
							<label class="mdl-textfield__label mdl-color-text--red-400" for="email">Email</label>
						</div>
						
						<br> <!-- BREAK -->
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input class="mdl-textfield__input" type="text" name= "registrationcode" id="registrationcode">
							<label class="mdl-textfield__label mdl-color-text--red-400" for="registrationcode">Registration Code</label>
						</div>
						<input class ="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent mdl-color--light-green-400" type="submit" value="Register">
					</form>
				</div>
				<div class="mdl-layout-spacer"></div> <!-- SPACE -->
			</div>
  			<div class = "mdl-grid">
				<div class="mdl-layout-spacer"></div> <!-- SPACE -->
				<div class="mdl-cell mdl-cell--2-col">
					<p>
						<a href="reset.php" class = "mdl-color-text--red-400">Forgot your password?</a>
						<br>
						Need to create an account? <a href="register.php" class = "mdl-color-text--light-green-400">Sign up!</a>
					</p>
				</div>
				<div class="mdl-layout-spacer"></div> <!-- SPACE -->
			</div>
		</main>
  		<?php include 'include/footer.php'; ?>
	</div>
	<script src="js/site.js"></script>
</body>
</html>
