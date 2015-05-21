<?php
	define('BASE_DIR', dirname(__FILE__));
	define('NAV_POS','camera');
	define('VIEW','camera');
	include BASE_DIR . '/_includes/_applicationhelper.php';
	include BASE_DIR . '/_handlers/_camera.php';
	include BASE_DIR .'/_layout/_default.php';
?>