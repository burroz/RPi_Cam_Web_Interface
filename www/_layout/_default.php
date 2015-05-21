<?php 

	include BASE_DIR .'/_partials/_header.php';

	if (defined('VIEW')) {
		include BASE_DIR .'/_views/_' . VIEW . '.php';
	} else {
		echo "NO VIEW ERROR!";
	}

	include BASE_DIR . '/_partials/_footer.php';

?>