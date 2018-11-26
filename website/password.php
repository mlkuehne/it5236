<?php

// Import the application classes
require_once('include/classes.php');

// Create an instance of the Application class
$app = new Application();
$app->setup();

$errors = array();
$messages = array();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

	$passwordrequestid = $_GET['id'];

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Grab or initialize the input values
	$password = $_POST['password'];
	$passwordrequestid = $_POST['passwordrequestid'];

	// Request a password reset email message
	$app->updatePassword($password, $passwordrequestid, $errors);
	
	if (sizeof($errors) == 0) {
		$message = "Password updated";
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
<body>
	<div class="mdl-layout mdl-js-layout">
		<script src="js/site.js"></script>
		<?php include 'include/header.php'; ?>
		<main class="mdl-layout__content">
  			<div class="mdl-grid">
    			<div class="mdl-layout-spacer"></div> <!-- SPACE -->
				<div class="mdl-cell mdl-cell--col-6">
					<h2 class="mdl-color-text--light-green-400">Reset Password</h2>
					<?php include('include/messages.php'); ?>
				</div>
				<div class="mdl-layout-spacer"></div> <!-- SPACE -->
			</div>
			<div class="mdl-grid">
				<div class="mdl-layout-spacer"></div> <!-- SPACE -->
				<div class="mdl-cell mdl-cell--2-col">
					<form method="post" action="password.php" id="password">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input class="mdl-textfield__input" type="password" name= "password" id="password" required="required">
							<label class="mdl-textfield__label mdl-color-text--red-400"  for="password">Password</label>
						</div>
						<input class ="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent mdl-color--light-green-400" type="submit" value="Submit">
						<input type="hidden" name="passwordrequestid" id="passwordrequestid" value="<?php echo $passwordrequestid; ?>" />
					</form>
				</div>
				<div class="mdl-layout-spacer"></div> <!-- SPACE -->
			</div>
		</main>
	<?php include 'include/footer.php'; ?>
</body>
</html>
