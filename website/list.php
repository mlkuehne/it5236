<?php
	
// Import the application classes
require_once('include/classes.php');

// Create an instance of the Application class
$app = new Application();
$app->setup();

// Declare an empty array of error messages
$errors = array();

// Check for logged in user since this page is protected
$app->protectPage($errors);

$name = "";

// Attempt to obtain the list of things
$things = $app->getThings($errors);

// Check for url flag indicating that there was a "no thing" error.
if (isset($_GET["error"]) && $_GET["error"] == "nothing") {
	$errors[] = "Things not found.";
}

// Check for url flag indicating that a new thing was created.
if (isset($_GET["newthing"]) && $_GET["newthing"] == "success") {
	$message = "Thing successfully created.";
}
	
// If someone is attempting to create a new thing, the process the request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Pull the title and thing text from the <form> POST
	$name = $_POST['name'];
	$attachment = $_FILES['attachment'];

	// Attempt to create the new thing and capture the result flag
	$result = $app->addThing($name, $attachment, $errors);

	// Check to see if the new thing attempt succeeded
	if ($result == TRUE) {

		// Redirect the user to the login page on success
	    header("Location: list.php?newthing=success");
		exit();

	}

}

?>

<!doctype html>
<html lang="en">
<head>
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.grey-light_green.min.css" />
	<title>Chattersquawks</title>
	<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
	
	
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
	2. If no errors display things -->
	
<body>
	<div class="mdl-layout mdl-js-layout">
		<?php include 'include/header.php'; ?>
  		<main class="mdl-layout__content">
		<div class="mdl-grid">
    		<div class="mdl-layout-spacer"></div> <!-- SPACE -->
  			<div class="mdl-cell mdl-cell--col-6">
  				<h2 class="mdl-color-text--light-green-400">My Things</h2>
				<?php include('include/messages.php'); ?>
  			</div>
  	
			<div class="mdl-layout-spacer"></div> <!-- SPACE -->
		</div>
  
		<div class="mdl-grid">
    		<div class="mdl-layout-spacer"></div> <!-- SPACE -->
			<div class="mdl-cell mdl-cell--col-6">
				<?php 
					if (sizeof($things) == 0) { ?>
						No things found
				?>
				<?php foreach ($things as $thing) { ?>
					<a class='mdl-color-text--red-400' href="thing.php?thingid=<?php echo $thing['thingid']; ?>"><?php echo $thing['thingname']; ?></a> &nbsp; &nbsp; &nbsp; <?php echo $thing['thingcreated']; ?> <br>
				<?php } ?>
			</div>
			<div class="mdl-layout-spacer"></div> <!-- SPACE -->
		</div>

		<div class="newthing">
			<form enctype="multipart/form-data" method="post" action="list.php">
				<input type="text" name="name" id="name" size="81" placeholder="Enter a thing name" value="<?php echo $name; ?>" />
				<br/>
				<label for="attachment">Add an image, PDF, etc.</label>
				<input id="attachment" name="attachment" type="file">
				<br/>
				<input type="submit" name="start" value="Create Thing" />
				<input type="submit" name="cancel" value="Cancel" />
			</form>
		</div>
	</main>
	<?php include 'include/footer.php'; ?>
</div>
	<script src="js/site.js"></script>
</body>	
</html>
