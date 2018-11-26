<?php
	
// Import the application classes
require_once('include/classes.php');

// Create an instance of the Application class
$app = new Application();
$app->setup();

// Declare an empty array of error messages
$errors = array();

// Check for logged in admin user since this page is "isadmin" protected
// NOTE: passing optional parameter TRUE which indicates the user must be an admin
$app->protectPage($errors, TRUE);

// Attempt to obtain the list of users
$users = $app->getUsers($errors);


// If someone is adding a new attachment type
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if ($_POST['attachmenttype'] == "add") {
		
		$name = $_POST['name'];;
		$extension = $_POST['extension'];;
	
		$attachmenttypeid = $app->newAttachmentType($name, $extension, $errors);
		
		if ($attachmenttypeid != NULL) {
			$messages[] = "New attachment type added";
		}

	}

}

// Attempt to obtain the list of users
$attachmentTypes = $app->getAttachmentTypes($errors);

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
					<h2 class="mdl-color-text--light-green-400">Admin Functions</h2>
					<?php include('include/messages.php'); ?>
					<h3 class="mdl-color-text--light-green-400">User List</h3>
						<ul class="users">
							<?php foreach($users as $user) { ?>
								<li><a href="editprofile.php?userid=<?php echo $user['userid']; ?>"><?php echo $user['username']; ?></a></li>
							<?php } ?>
						</ul>
						
					<h3>Valid Attachment Types</h3>
						<ul class="attachmenttypes">
							<?php foreach($attachmentTypes as $attachmentType) { ?>
								<li><?php echo $attachmentType['name']; ?> [<?php echo $attachmentType['extension']; ?>]</li>
							<?php } ?>
							<?php if (sizeof($attachmentTypes) == 0) { ?>
								<li>No attachment types found in the database</li>
							<?php } ?>
						</ul>
						
					<h4>Add Attachment Type</h4>
						<form enctype="multipart/form-data" method="post" action="admin.php">
							<label for="name">Name</label>
							<input id="name" name="name" type="text">
							<br/>
							<label for="extension">Extension</label>
							<input id="extension" name="extension" type="text">
							<br/>
							<input type="hidden" name="attachmenttype" value="add" />
							<input type="submit" name="addattachmenttype" value="Add type" />
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
