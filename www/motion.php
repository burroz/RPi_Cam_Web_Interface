<?php
	define('BASE_DIR', dirname(__FILE__));
	define('NAV_POS','motion');
	define('VIEW','motion');
	include BASE_DIR . '/_includes/_applicationhelper.php';
	include BASE_DIR . '/_handlers/_motion.php';
	include BASE_DIR .'/_layout/_default.php';
?>