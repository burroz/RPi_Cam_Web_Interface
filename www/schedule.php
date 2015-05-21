<?php
	define('BASE_DIR', dirname(__FILE__));
	define('NAV_POS','schedule');
	include BASE_DIR . '/_includes/_applicationhelper.php';
	include BASE_DIR . '/_handlers/_schedule.php';
	include BASE_DIR .'/_partials/_schedule.php';
?>
<?php
   #define('BASE_DIR', dirname(__FILE__));
   #require_once(BASE_DIR.'/config.php');

   
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
   
   if (!$cliCall) {
      mainHTML();
   } else {
      mainCLI();
   }
?>
