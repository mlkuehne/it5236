<?php

// Import the application classes
require_once('include/classes.php');

// Declare an empty array of error messages
$errors = array();

// Create an instance of the Application class
$app = new Application();
$app->setup();

// Check for logged in user since this page is protected
$app->protectPage($errors);

// Declare a set of variables to hold the details for the user
$userid = "";
$username = "";
$email = "";
$isadminFlag = FALSE;

$sessionid = $_COOKIE['sessionid'];
$user = $app->getSessionUser($sessionid, $errors);
$loggedinuserid = $user["userid"];

// If someone is accessing this page for the first time, try and grab the userid from the GET request
// then pull the user's details from the database
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

	// Get the userid
	if (!isset($_GET['userid'])) {

		$userid = $loggedinuserid;

	} else {

		$userid = $_GET['userid'];
		
	}
	
	// Attempt to obtain the user information.
	$user = $app->getUser($userid, $errors);
	
	if ($user != NULL){
		$username = $user['username'];
		$email = $user['email'];
		$isadminFlag = ($user['isadmin'] == "1");
		$password = "";
	}

// If someone is attempting to edit their profile, process the request	
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Get the form values 
	$userid   = $_POST['userid'];
	$username = $_POST['username'];
	$email    = $_POST['email'];
	$password = $_POST['password'];
	if (isset($_POST['isadmin']) && $_POST['isadmin'] == "isadmin") {
		$isadminFlag = TRUE;
	} else {
		$isadminFlag = FALSE;
	}

	// Attempt to update the user information.
	$result = $app->updateUser($userid, $username, $email, $password, $isadminFlag, $errors);
	
	// Display message upon success.
	if ($result == TRUE){
		$message = "User successfully updated.";
		$user = $app->getUser($userid, $errors);
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
		<?php include 'include/header.php'; ?>

		<main class="mdl-layout__content">
  			<div class="mdl-grid">
    			<div class="mdl-layout-spacer"></div> <!-- SPACE -->
				<div class="mdl-cell mdl-cell--col-6">
					<h2 class="mdl-color-text--light-green-400">Edit Profile</h2>
					<?php include('include/messages.php'); ?>
				</div>
				<div class="mdl-layout-spacer"></div> <!-- SPACE -->
			</div>
			<div class="mdl-grid">
				<div class="mdl-layout-spacer"></div> <!-- SPACE -->
				<div class="mdl-cell mdl-cell--2-col">
					<form action="editprofile.php" method="post" id="editprofile">
  						<input type="hidden" name="userid" value="<?php echo $userid; ?>" />  						
  						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input class="mdl-textfield__input" input type="text" name="username" id="username" value="<?php echo $username; ?>">
							<label class="mdl-textfield__label mdl-color-text--red-400" for="username">Username</label>
  						</div>
  	
  						<br> <!-- BREAK -->
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input class="mdl-textfield__input" type="password" name= "password" id="password">
							<label class="mdl-textfield__label mdl-color-text--red-400" for="password">Password</label>
						</div>
						<br>
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input class="mdl-textfield__input" type="text" name="email" id="email" value="<?php echo $email; ?>">
							<label class="mdl-textfield__label mdl-color-text--red-400" for="email">Email</label>
						</div>
						<?php if ($loggedinuserid != $userid) { ?>
						<br>
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input type="checkbox" name="isadmin" id="isadmin" <?php echo ($isadminFlag ? "checked=checked" : ""); ?> value="isadmin" />
							<label class="mdl-textfield__label mdl-color-text--red-400" for="isadmin">Grant admin rights</label>
						</div>
						<?php } ?>
						<br>
						<input class ="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent mdl-color--light-green-400" type="submit" value="Update profile">
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
