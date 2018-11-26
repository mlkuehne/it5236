<footer class="mdl-mini-footer">
	<div class="mdl-mini-footer__left-section">
		<div class="mdl-logo">
			Chattersquawks
		</div>
	</div>
</footer>

<?php

if ($_COOKIE['debug'] == "true") {
	echo "<h3>Debug messages</h3>";
	echo "<pre>";
    foreach ($app->debugMessages as $msg) {
		var_dump($msg);
	}
	echo "</pre>";
}
	
?>