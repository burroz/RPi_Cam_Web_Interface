<?php
	#define('BASE_DIR', dirname(__FILE__));
	#include BASE_DIR . '/_includes/_applicationhelper.php';
	#define('BASE_DIR', dirname(__FILE__));
	#require_once(BASE_DIR.'/config.php');
	$pipe = fopen("FIFO","w");
	fwrite($pipe, $_GET["cmd"]);
	fclose($pipe);
?>
