<?php

   function getZip($files) {
      $zipname = MEDIA_PATH . '/cam_' . date("Ymd_His") . '.zip';
      writeLog("Making zip $zipname");
      $zipfiles = fopen($zipname.".files", "w");
      foreach ($files as $file) {
         if (getFileType($file) == 't') {
            $lapses = findLapseFiles($file);
            if (!empty($lapses)) {
               foreach($lapses as $lapse) {
                  fprintf($zipfiles, "$lapse\n");
               }
            }
         } else {
            $base = dataFilename($file);
            if (file_exists(MEDIA_PATH . "/$base")) {
               fprintf($zipfiles, MEDIA_PATH . "/$base\n");
            }
         }
      }
      fclose($zipfiles);
      file_put_contents("$zipname.count", "0/100");
      exec("./raspizip.sh $zipname $zipname.files > /dev/null &");
      return $zipname;
   }

   function startVideoConvert($bFile) {
      global $debugString;
      $tFiles = findLapseFiles($bFile);
      $tmp = BASE_DIR . '/' . MEDIA_PATH . '/' . getFileType($bFile) . getFileIndex($bFile);
      if (!file_exists($tmp)) {
         mkdir($tmp, 0777, true);
      }
      $i= 1;
      foreach($tFiles as $tFile) {
         copy($tFile, $tmp . '/' . sprintf('i_%05d', $i) . '.jpg');
         $i++;
      }
      $vFile = substr(dataFilename($bFile), 0, -3) . 'mp4';
      $cmd = $_POST['convertCmd'];
      $fp = fopen(BASE_DIR . '/' . CONVERT_CMD, 'w');
      fwrite($fp, $cmd);
      fclose($fp);
      $cmd = "(" . str_replace("i_%05d", "$tmp/i_%05d", $cmd) . ' ' . BASE_DIR . '/' . MEDIA_PATH . "/$vFile ; rm -rf $tmp;) >/dev/null 2>&1 &";
      writeLog("start lapse convert:$cmd");
      system($cmd);
      copy(MEDIA_PATH . "/$bFile", MEDIA_PATH . '/' . $vFile . '.v' . getFileIndex($bFile) .THUMBNAIL_EXT);
      writeLog("Convert finished");
   }


   // function to deletes files and folders recursively
   // $deleteMainFiles true r false to delete files from the top level folder
   // $deleteSubFiles true or false to delete files from subfolders
   // Empty subfolders get removed.
   // $root true or false. If true (default) then top dir not removed
   function maintainFolders($path, $deleteMainFiles, $deleteSubFiles, $root = true) {
      $empty=true;
      foreach (glob("$path/*") as $file) {
         if (is_dir($file)) {
            if (!maintainFolders($file, $deleteMainFiles, $deleteSubFiles, false)) $empty=false;
         }  else {
            if (($deleteSubFiles && !$root) || ($deleteMainFiles && $root)) {
              unlink($file);
            } else {
               $empty=false;
            }
         }
      }
      return $empty && !$root && rmdir($path);
   }
   
   //function to draw 1 file on the page
   function OLD_drawFile($f, $ts, $sel) {
      $fType = getFileType($f);
      $rFile = dataFilename($f);
      $fNumber = getFileIndex($f);
      $lapseCount = "";
      switch ($fType) {
         case 'v': $fIcon = 'video.png'; break;
         case 't': 
            $fIcon = 'timelapse.png';
            $lapseCount = '(' . count(findLapseFiles($f)). ')';
            break;
         case 'i': $fIcon = 'image.png'; break;
         default : $fIcon = 'image.png'; break;
      }
      $duration ='';
      if (file_exists(MEDIA_PATH . "/$rFile")) {
         $fsz = round ((filesize(MEDIA_PATH . "/$rFile")) / 1024);
         $fModTime = filemtime(MEDIA_PATH . "/$rFile");
         if ($fType == 'v') {
            $duration = ($fModTime - filemtime(MEDIA_PATH . "/$f")) . 's';
         }
      } else {
         $fsz = 0;
         $fModTime = filemtime(MEDIA_PATH . "/$f");
      }
      $fDate = @date('Y-m-d', $fModTime);
      $fTime = @date('H:i:s', $fModTime);
      $fWidth = max($ts + 4, 140);
      echo "<fieldset class='fileicon' style='width:" . $fWidth . "px;'>";
      echo "<legend class='fileicon'>";
      echo "<button type='submit' name='delete1' value='$f' class='fileicondelete' style='background-image:url(delete.png);'></button>";
      echo "&nbsp;&nbsp;$fNumber&nbsp;";
      echo "<img src='$fIcon' style='width:24px'/>";
      echo "<input type='checkbox' name='check_list[]' $sel value='$f' style='float:right;'/>";
      echo "</legend>";
      if ($fsz > 0) echo "$fsz Kb $lapseCount $duration"; else echo 'Busy';
      echo "<br>$fDate<br>$fTime<br>";
      if ($fsz > 0) echo "<a title='$rFile' href='preview.php?preview=$f'>";
      echo "<img src='" . MEDIA_PATH . "/$f' style='width:" . $ts . "px'/>";
      if ($fsz > 0) echo "</a>";
      echo "</fieldset> ";
   }
   
   function getThumbnails() {
      $files = scandir(MEDIA_PATH);
      $thumbnails = array();
      foreach($files as $file) {
         if($file != '.' && $file != '..' && isThumbnail($file)) {
            $thumbnails[] = $file;
         } 
      }
      return $thumbnails;   
   }
   
   function diskUsage() {
      $returnMe = ['total'=>0,'currentAvailable'=>0,'used'=>0,'usedPercent'=>0,'currentAvailablePercent'=>0];
      $returnMe['total'] = disk_total_space(BASE_DIR . '/' . MEDIA_PATH);
      $returnMe['currentAvailable'] = disk_free_space(BASE_DIR . '/' . MEDIA_PATH);
      $returnMe['used'] = $returnMe['total'] - $returnMe['currentAvailable'];
      $returnMe['usedPercent'] = ($returnMe['total'] - $returnMe['currentAvailable'])/$returnMe['total'] * 100;
      $returnMe['currentAvailablePercent'] = 100 - (($returnMe['total'] - $returnMe['currentAvailable'])/$returnMe['total'] * 100);
      return $returnMe;
   }

   function OLD_diskUsage() {
      // Return percent used
      $totalSize = round(disk_total_space(BASE_DIR . '/' . MEDIA_PATH) / 1048576); //MB
      $currentAvailable = round(disk_free_space(BASE_DIR . '/' . MEDIA_PATH) / 1048576); //MB
      $percentUsed = round(($totalSize - $currentAvailable)/$totalSize * 100, 1);
      if ($percentUsed > 98)
         $colour = 'Red';
      else if ($percentUsed > 90)
         $colour = 'Orange';
      else
         $colour = 'LightGreen';
      echo '<div style="margin-left:5px;position:relative;width:300px;border:1px solid #ccc;">';
         echo "<span>Used:$percentUsed%  Total:$totalSize(MB)</span>";
         echo "<div style='z-index:-1;position:absolute;top:0px;width:$percentUsed%;background-color:$colour;'>&nbsp;</div>";
      echo '</div>';
   }

	/** 
	* Converts bytes into human readable file size. 
	* 
	* @param string $bytes 
	* @return string human readable file size (2,87 Мб)
	* @author Mogilev Arseny 
	*/ 
	function FileSizeConvert($bytes) {
		$bytes = floatval($bytes);
		$arBytes = array(
			0 => array("UNIT" => "TB","VALUE" => pow(1024, 4)),
			1 => array("UNIT" => "GB", "VALUE" => pow(1024, 3)),
			2 => array("UNIT" => "MB","VALUE" => pow(1024, 2)),
			3 => array("UNIT" => "KB","VALUE" => 1024),
			4 => array("UNIT" => "B","VALUE" => 1),
		);
		foreach($arBytes as $arItem) {
			if($bytes >= $arItem["VALUE"]) {
				$result = $bytes / $arItem["VALUE"];
				$result = str_replace(".", "," , strval(round($result, 2)))." ".$arItem["UNIT"];
				break;
			}
		}
		return $result;
	}

	function secondsToTime($seconds) {

		$days = floor($seconds / 86400);
		$hours = floor(($seconds - $days * 86400) / 3600);
		$minutes = floor(($seconds - $days * 86400 - $hours * 3600) / 60);
		$seconds = floor($seconds - $days * 86400 - $hours * 3600 - $minutes * 60);

		$returnMe = '';
		$showCero = false;
		$unit2use = '';
		
		if ($days > 0) {
			$returnMe .= $days . 'd';
			$showCero = true;
			$unit2use = 'd';
		}
		if ($hours > 0 || $showCero) {
			if ($hours < 10) {
				$returnMe .= '0' . $hours . ':';
			} else {
				$returnMe .= $hours . ':';
			}
			if (!$showCero) { $unit2use = 'h'; }
			$showCero = true;
		}
		if ($minutes > 0 || $showCero) {
			if ($minutes < 10) {
				$returnMe .= '0' . $minutes . ':';
			} else {
				$returnMe .= $minutes . ':';
			}
			if (!$showCero) { $unit2use = 'm'; }
			$showCero = true;
		}
		if ($seconds > 0 || $showCero) {
			if ($seconds < 10) {
				$returnMe .= '0' . $seconds . '';
			} else {
				$returnMe .= $seconds . '';				
			}
			if (!$showCero) { $unit2use = 's'; }
			$showCero = true;
		}
		
		return $returnMe . " " . $unit2use;


		#echo "{$days} days {$hours} hours {$minutes} minutes {$seconds} seconds";
		#$dtF = new DateTime("@0");
		#$dtT = new DateTime("@$seconds");
		#return $dtF->diff($dtT)->format('%a d, %h h, %i m and %s s');

	}

?>