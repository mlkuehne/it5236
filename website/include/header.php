<?php

	// Assume the user is not logged in and not an admin
	$isadmin = FALSE;
	$loggedin = FALSE;
	
	// If we have a session ID cookie, we might have a session
	if (isset($_COOKIE['sessionid'])) {
		
		$user = $app->getSessionUser($errors); 
		$loggedinuserid = $user["userid"];

		// Check to see if the user really is logged in and really is an admin
		if ($loggedinuserid != NULL) {
			$loggedin = TRUE;
			$isadmin = $app->isAdmin($errors, $loggedinuserid);
		}

	} else {
		
		$loggedinuserid = NULL;

	}


?>
	<div class="demo-layout-transparent mdl-layout--fixed-header mdl-shadow--6dp">
  	<header class="mdl-layout__header">
    	<div class="mdl-layout__header-row">
      		<!-- Title -->
      		<span class="mdl-layout-title">Chattersquawks</span>
      		<!-- Add spacer, to align navigation to the right -->
      		<div class="mdl-layout-spacer"></div>
      		<!-- Navigation. We hide it in small screens. -->
      		<nav class="mdl-navigation mdl-layout--large-screen-only">
      		
      		<?php if (!$loggedin) { ?>
        		<a class="mdl-navigation__link mdl-color-text--white" href="register.php">Register</a>
        		<a class="mdl-navigation__link mdl-color-text--white" href="login.php">Login</a>
        	<?php } ?>
        	
        	<?php if ($loggedin) { ?>
        		<a class="mdl-navigation__link mdl-color-text--white" href="list.php">List</a>
        		<a class="mdl-navigation__link mdl-color-text--white" href="editprofile.php">Profile</a>
        		
        		<?php if ($isAdmin) { ?>
        			<a class="mdl-navigation__link mdl-color-text--white" href="admin.php">Admin</a>
        		<?php } ?>
        		
        		<a class="mdl-navigation__link mdl-color-text--white" href="logout.php">Logout</a>
        		
        	<?php } ?>
        	
      		</nav>
    	</div>
  	</header>
</div>
  <div class="mdl-layout__drawer mdl-layout--small-screen-only">
    <span class="mdl-layout-title">Chattersquawks</span>
    <nav class="mdl-navigation">
      
      <?php if (!$loggedin) { ?>
        		<a class="mdl-navigation__link mdl-color-text--gray" href="register.php">Register</a>
        		<a class="mdl-navigation__link mdl-color-text--gray" href="login.php">Login</a>
        	<?php } ?>
        	
        	<?php if ($loggedin) { ?>
        		<a class="mdl-navigation__link mdl-color-text--gray" href="topics.php">Topics</a>
        		<a class="mdl-navigation__link mdl-color-text--gray" href="editprofile.php?userid=<?php echo $userid; ?>">Profile</a>
        		
        		<?php if ($isAdmin == "true") { ?>
        			<a class="mdl-navigation__link mdl-color-text--gray" href="admin.php">Admin</a>
        		<?php } ?>
        		
        		<a class="mdl-navigation__link mdl-color-text--gray" href="logout.php">Logout</a>
        		
        	<?php } ?>
      
    </nav>
    
    
  </div>
