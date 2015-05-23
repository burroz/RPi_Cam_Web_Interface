<?php

	# configuration

	include BASE_DIR . '/config.php';

	$config = array();

	$config = readConfig($config, CONFIG_FILE1);
	$config = readConfig($config, CONFIG_FILE2);

	# others

	function makeInput($id, $size, $selKey='', $css='') {
		global $config, $debugString;
		if ($selKey == '') $selKey = $id;
		switch ($selKey) {
			case 'tl_interval':
				if (array_key_exists($selKey, $config)) {
					$value = $config[$selKey] / 10;
				} else {
					$value = 3;
				}
				break;
			case 'watchdog_interval':
				if (array_key_exists($selKey, $config)) {
					$value = $config[$selKey] / 10;
				} else {
					$value = 0;
				}
				break;
			default: $value = $config[$selKey]; break;
		}
		echo "<input type='text' class='form-control input-xs $css' size=$size id='$id' value='$value'>";
	}
	
	function makeOptions($options, $selKey) {
		global $config;
		switch ($selKey) {
			case 'flip':
				$cvalue = (($config['vflip'] == 'true') ? 2:0);
				$cvalue += (($config['hflip'] == 'true') ? 1:0);
				break;
			case 'MP4Box':
				$cvalue = $config[$selKey];
				if ($cvalue == 'background') $cvalue = 2;
				break;
			default: $cvalue = $config[$selKey]; break;
		}
		if ($cvalue == 'false') $cvalue = 0;
		else if ($cvalue == 'true') $cvalue = 1;
		foreach($options as $name => $value) {
			if ($cvalue != $value) {
				$selected = '';
			} else {
				$selected = ' selected';
			}
			echo "<option value='$value'$selected>$name</option>";
		}
	}
	
?>