<?php

	include BASE_DIR . '/_models/_schedule.php';

	//Text labels here
	define('BTN_START', 'Start');
	define('BTN_STOP', 'Stop');
	define('BTN_SAVE', 'Save Settings');
	define('BTN_BACKUP', 'Backup');
	define('BTN_RESTORE', 'Restore');
	define('BTN_SHOWLOG', 'Show Log');
	define('BTN_DOWNLOADLOG', 'Download Log');
	define('BTN_CLEARLOG', 'Clear Log');
	define('LBL_PERIODS', 'AllDay;Night;Dawn;Day;Dusk');
	define('LBL_COLUMNS', 'Period;Motion Start;Motion Stop;Period Start');
	define('LBL_PARAMETERS', 'Parameter;Value');
	define('LBL_DAYMODES', 'Sun based;All Day;Fixed Times');
	define('LBL_PURGESPACEMODES', 'Off;Min Space %;Max Usage %;Min Space GB;Max Usage GB');
	define('LBL_DAWN', 'Dawn');
	define('LBL_DAY', 'Day');
	define('LBL_DUSK', 'Dusk');
	
	define('SCHEDULE_CONFIG', 'schedule.json');
	define('SCHEDULE_CONFIGBACKUP', 'scheduleBackup.json');
	
	define('SCHEDULE_START', '1');
	define('SCHEDULE_STOP', '0');
	define('SCHEDULE_RESET', '9');
	 
	define('SCHEDULE_ZENITH', '90.8');
	
	define('SCHEDULE_FIFOIN', 'Fifo_In');
	define('SCHEDULE_FIFOOUT', 'Fifo_Out');
	define('SCHEDULE_CMDPOLL', 'Cmd_Poll');
	define('SCHEDULE_MODEPOLL', 'Mode_Poll');
	define('SCHEDULE_MAXCAPTURE', 'Max_Capture');
	define('SCHEDULE_LATITUDE', 'Latitude');
	define('SCHEDULE_LONGTITUDE', 'Longtitude');
	define('SCHEDULE_GMTOFFSET', 'GMTOffset');
	define('SCHEDULE_DAWNSTARTMINUTES', 'DawnStart_Minutes');
	define('SCHEDULE_DAYSTARTMINUTES', 'DayStart_Minutes');
	define('SCHEDULE_DAYENDMINUTES', 'DayEnd_Minutes');
	define('SCHEDULE_DUSKENDMINUTES', 'DuskEnd_Minutes');
	define('SCHEDULE_ALLDAY', 'AllDay');
	define('SCHEDULE_DAYMODE', 'DayMode');
	define('SCHEDULE_FIXEDTIMES', 'FixedTimes');
	define('SCHEDULE_MANAGEMENTINTERVAL', 'Management_Interval');
	define('SCHEDULE_MANAGEMENTCOMMAND', 'Management_Command');
	define('SCHEDULE_PURGEVIDEOHOURS', 'PurgeVideo_Hours');
	define('SCHEDULE_PURGEIMAGEHOURS', 'PurgeImage_Hours');
	define('SCHEDULE_PURGELAPSEHOURS', 'PurgeLapse_Hours');
	define('SCHEDULE_PURGESPACEMODE', 'PurgeSpace_ModeEx');
	define('SCHEDULE_PURGESPACELEVEL', 'PurgeSpace_Level');
	define('SCHEDULE_COMMANDSON', 'Commands_On');
	define('SCHEDULE_COMMANDSOFF', 'Commands_Off');
	define('SCHEDULE_MODES', 'Modes');
	define('SCHEDULE_TIMES', 'Times');

	$debugString = "";
	$schedulePars = array();
	$schedulePars = loadPars(BASE_DIR . '/' . SCHEDULE_CONFIG);
	 
	$cliCall = isCli();
	$showLog = false;
	$schedulePID = getSchedulePID();
	if (!$cliCall && isset($_POST['action'])) {
		//Process any POST data
		switch($_POST['action']) {
			case 'start':
				startSchedule();
				$schedulePID = getSchedulePID();
				break;
			case 'stop':
				stopSchedule($schedulePID);
				$schedulePID = getSchedulePID();
				break;
			case 'save':
				writeLog('Saved schedule settings');
				$fp = fopen(BASE_DIR . '/' . SCHEDULE_CONFIG, 'w');
				$saveData = $_POST;
				unset($saveData['action']);
				fwrite($fp, json_encode($saveData));
				fclose($fp);
				$schedulePars = loadPars(BASE_DIR . '/' . SCHEDULE_CONFIG);
				sendReset();
				break;
			case 'backup':
				writeLog('Backed up schedule settings');
				$fp = fopen(BASE_DIR . '/' . SCHEDULE_CONFIGBACKUP, 'w');
				fwrite($fp, json_encode($schedulePars));
				fclose($fp);
				break;
			case 'restore':
				writeLog('Restored up schedule settings');
				$schedulePars = loadPars(BASE_DIR . '/' . SCHEDULE_CONFIGBACKUP);
				break;
			case 'showlog':
				$showLog = true;
				break;
			case 'downloadlog':
				if (file_exists(BASE_DIR . '/' . LOGFILE_SCHEDULE)) {
					header("Content-Type: text/plain");
					header("Content-Disposition: attachment; filename=\"" . date('Ymd-His-') . LOGFILE_SCHEDULE . "\"");
					readfile(BASE_DIR . '/' . LOGFILE_SCHEDULE);
					return;
				}
			case 'clearlog':
				if (file_exists(BASE_DIR . '/' . LOGFILE_SCHEDULE)) {
					unlink(BASE_DIR . '/' . LOGFILE_SCHEDULE);
				}
				break;
		}
	}

?>