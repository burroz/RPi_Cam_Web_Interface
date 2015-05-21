<?php
	define('BASE_DIR', dirname(__FILE__));
	define('NAV_POS','schedule');
	define('VIEW','schedule');
	include BASE_DIR . '/_includes/_applicationhelper.php';
	include BASE_DIR . '/_handlers/_schedule.php';
	include BASE_DIR .'/_layout/_default.php';
?>
