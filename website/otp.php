<?php

// Import the application classes
require_once('include/classes.php');

// Create an instance of the Application class
$app = new Application();
$app->setup();

// Declare a set of variables to hold the username and password for the user
$username = "";
$password = "";

// Declare an empty array of error messages
$errors = array();

// If someone has clicked their email validation link, then process the request
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

	if (isset($_GET['id'])) {
		
		$success = $app->processEmailValidation($_GET['id'], $errors);
		if ($success) {
			$message = "Email address validated. You may login.";
		}

	}

}

// If someone is attempting to login, process their request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Pull the username and password from the <form> POST
	$username = $_POST['username'];
	$password = $_POST['password'];

	// Attempt to login the user and capture the result flag
	$result = $app->login($username, $password, $errors);

	// Check to see if the login attempt succeeded
	if ($result == TRUE) {

		// Redirect the user to the topics page on success
		header("Location: otp.php");
		exit();

	}

}

if (isset($_GET['register']) && $_GET['register']== 'success') {
	$message = "Registration successful. Please check your email. A message has been sent to validate your address.";
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


<body>
	<div class="mdl-layout mdl-js-layout">
		<?php include 'include/header.php'; ?>

		<main class="mdl-layout__content">
  			<div class="mdl-grid">
    			<div class="mdl-layout-spacer"></div> 
				<div class="mdl-cell mdl-cell--col-6">
					<h2 class="mdl-color-text--light-green-400">Multifactor Authentication</h2>
					<p>Please check the email associated with this account to input your one time password. If you cannot find it in your inbox, please check your spam folder.</p>
					<?php include('include/messages.php'); ?>
				</div>
				<div class="mdl-layout-spacer"></div> 
			</div>
			<div class="mdl-grid">
				<div class="mdl-layout-spacer"></div> 
				<div class="mdl-cell mdl-cell--2-col">
					<form action="otp.php" method="POST">
  						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input class="mdl-textfield__input" type="text" name= "otp" id="otp">
							<label class="mdl-textfield__label mdl-color-text--red-400" for="otp">One Time Password</label>
  						</div>

						<input class ="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent mdl-color--light-green-400" type="submit" value="Submit">
					</form>
				</div>
				<div class="mdl-layout-spacer"></div>
			</div>
		</main>
  		<?php include 'include/footer.php'; ?>
	</div>
	<script src="js/site.js"></script>
</body>
</html> 
