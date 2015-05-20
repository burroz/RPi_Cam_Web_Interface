<?php

	# configuration

	include BASE_DIR . '/config.php';

	$config = array();

	$config = readConfig($config, CONFIG_FILE1);
	$config = readConfig($config, CONFIG_FILE2);

	# others

?>