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

// If the page/thing is being loaded for display
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

	// Get the topic id from the URL
	$thingid = $_GET['thingid'];
	
	// Attempt to obtain the topic
	$thing = $app->getThing($thingid, $errors);
	
	// If there were no errors getting the topic, try to get the comments
	if (sizeof($errors) == 0) {
	
		// Attempt to obtain the comments for this topic
		$thing = $app->getThing($thingid, $errors);
		
		// If the thing loaded successfully, load the associated comments
		if (isset($thing)) {
			$comments = $app->getComments($thing['thingid'], $errors);
		}
	
	} else {
		// Redirect the user to the things page on error
		header("Location: list.php?error=nothing");
		exit();
	}
	
	// Check for url flag indicating that a new comment was created.
	if (isset($_GET["newcomment"]) && $_GET["newcomment"] == "success") {
		$message = "New comment successfully created.";
	}
}
// If someone is attempting to create a new comment, process their request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Pull the comment text from the <form> POST
	$text = $_POST['comment'];

	// Pull the thing ID from the form
	$thingid = $_POST['thingid'];
	$attachment = $_FILES['attachment'];

	// Get the details of the thing from the database
	$thing = $app->getThing($thingid, $errors);

	// Attempt to create the new comment and capture the result flag
	$result = $app->addComment($text, $thingid, $attachment, $errors);

	// Check to see if the new comment attempt succeeded
	if ($result == TRUE) {

		// Redirect the user to the login page on success
	    header("Location: thing.php?newcomment=success&thingid=" . $thingid);
		exit();

	} else {
		if (isset($thing)) {
			$comments = $app->getComments($thing['thingid'], $errors);
		}
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
					<?php include('include/messages.php'); ?>
					<h2 class="mdl-color-text--light-green-400"><?php echo $thing['thingname']; ?></h2>
					<?php echo "&nbsp; &nbsp; &mdash; &nbsp; &nbsp;". $thing['username']." posted on ". $thing['thingcreated'];
						
			if ($thing['filename'] != NULL) {
				echo "<br><a class = 'mdl-color-text--red-400' href ='attachments/". $thing['thingattachmentid'] ."-".$thing['filename']." >".$thing['filename']."</a><br>";
			}
				 	?>				
				 </div>
				<div class="mdl-layout-spacer"></div> <!-- SPACE -->
			</div>
			
			<?php 
				if(!empty($comments)){		
					foreach ($comments as $comment){
						echo "<div class='mdl-grid'><div class='mdl-layout-spacer'></div> <!-- SPACE --><div class='mdl-cell mdl-cell--col-6'>";
						echo $comment['commenttext']." <br> &nbsp; &nbsp; &mdash; &nbsp; &nbsp;".$comment['username']." posted on ". $comment['commentposted'];
						
						if ($thing['filename'] != NULL) {
							echo "<br><a class = 'mdl-color-text--red-400' href ='attachments/". $comment['attachmentid']."-".$comment['filename']." >".$comment['filename']."</a><br>";
			}
						
						echo "</div><div class='mdl-layout-spacer'></div> <!-- SPACE --></div>";
					}
				}
			?>
			
			<form enctype="multipart/form-data" method="post" action="thing.php">
			<textarea name="comment" id="comment" rows="4" cols="50" placeholder="Add a comment"></textarea>
			<br/>
			<label for="attachment">Add an image, PDF, etc.</label>
			<input id="attachment" name="attachment" type="file">
			<br/>
			<input type="hidden" name="thingid" value="<?php echo $thingid; ?>" />
			<input type="submit" name="start" value="Add comment" />
		</form>
		</main>
		<?php include 'include/footer.php'; ?>
	</div>
	<script src="js/site.js"></script>
</body>
</html>
