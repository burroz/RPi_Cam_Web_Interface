<?php
	define('BASE_DIR', dirname(__FILE__));
	define('NAV_POS','index');
	define('VIEW','index');
	include BASE_DIR . '/_includes/_applicationhelper.php';
	include BASE_DIR . '/_handlers/_index.php';
	include BASE_DIR .'/_layout/_default.php';
?>