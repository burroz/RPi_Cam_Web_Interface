<?php
	include BASE_DIR .'/_partials/_header.php';
	echo '<div class="container">';
		if (defined('VIEW')) {
			include BASE_DIR .'/_views/_' . VIEW . '.php';
		} else {
			echo "NO VIEW ERROR!";
		}
	echo '</div>';
	include BASE_DIR . '/_partials/_footer.php';
?>
