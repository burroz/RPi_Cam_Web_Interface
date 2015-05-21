<?php
	define('BASE_DIR', dirname(__FILE__));
	define('NAV_POS','preview');
	define('VIEW','preview');
	include BASE_DIR . '/_includes/_applicationhelper.php';
	include BASE_DIR . '/_handlers/_preview.php';
	include BASE_DIR .'/_layout/_default.php';
?>