<?php

	include BASE_DIR . '/_models/_preview.php';

   #define('BASE_DIR', dirname(__FILE__));
   #require_once(BASE_DIR.'/config.php');
  
   //Text labels here
   define('BTN_DOWNLOAD', 'Download');
   define('BTN_DELETE', 'Delete');
   define('BTN_CONVERT', 'Start Convert');
   define('BTN_DELETEALL', 'Delete All');
   define('BTN_DELETESEL', 'Delete Sel');
   define('BTN_SELECTALL', 'Select All');
   define('BTN_SELECTNONE', 'Select None');
   define('BTN_GETZIP', 'Get Zip');
   define('BTN_UPDATESIZES', 'Update Sizes');
   define('TXT_PREVIEW', 'Preview');
   define('TXT_THUMB', 'Thumb');
   define('TXT_FILES', 'Files');
   
   define('CONVERT_CMD', 'convertCmd.txt');
   
   //Set size defaults and try to get from cookies
   $previewSize = 5; // 5 regular, 4 small, 3 smaller, 2 smallest, 6 big, 7 bigger, 8 biggest
   $thumbSize = 5; // 5 regular, 4 small, 3 smaller, 2 smallest, 6 big, 7 bigger, 8 biggest

   #if(isset($_COOKIE["previewSize"])) {
   #   $previewSize = $_COOKIE["previewSize"];
   #}
   if(isset($_COOKIE["thumbSize"])) {
      $thumbSize = $_COOKIE["thumbSize"];
   }
   
   
   
   
   $dSelect = "";
   $pFile = "";
   $tFile = "";
   $debugString = "";
   
   if(isset($_GET['preview'])) {
      $tFile = $_GET['preview'];
      $pFile = dataFilename($tFile);
   }

   if (isset($_GET['zipprogress'])) {
      $zipname = $_GET['zipprogress'];
      $ret = @file_get_contents("$zipname.count");
      if ($ret) {
         echo $ret;
      }
      else {
         echo "complete";
      }
      return;
   }

   $zipname = false;
  
   //Process any POST data
   // 1 file based commands
   if (isset($_POST['zipdownload'])) {
      $zipname = $_POST['zipdownload'];
      header("Content-Type: application/zip");
      header("Content-Disposition: attachment; filename=\"".substr($zipname,strlen(MEDIA_PATH)+1)."\"");
      readfile("$zipname");
      if(file_exists($zipname)){
          unlink($zipname);
      }                  
      return;
   } else if (isset($_POST['delete1'])) {
      deleteFile($_POST['delete1']);
      maintainFolders(MEDIA_PATH, false, false);
   } else if (isset($_POST['convert'])) {
      $tFile = $_POST['convert'];
      startVideoConvert($tFile);
      $tFile = "";
   } else if (isset($_POST['download1'])) {
      $dFile = $_POST['download1'];
      if(getFileType($dFile) != 't') {
         $dxFile = dataFilename($dFile);
         if(dataFileext($dFile) == "jpg") {
            header("Content-Type: image/jpeg");
         } else {
            header("Content-Type: video/mp4");
         }
         header("Content-Disposition: attachment; filename=\"" . dataFilename($dFile) . "\"");
         readfile(MEDIA_PATH . "/$dxFile");
         return;
      } else {
         $zipname = getZip(array($dFile));
      }
   } else if (isset($_POST['action'])){
      //global commands
      switch($_POST['action']) {
         case 'deleteAll':
            maintainFolders(MEDIA_PATH, true, true);
            break;
         case 'selectAll':
            $dSelect = "checked";
            break;
         case 'selectNone':
            $dSelect = "";
            break;
         case 'deleteSel':
            if(!empty($_POST['check_list'])) {
               foreach($_POST['check_list'] as $check) {
                  deleteFile($check);
               }
            }        
            maintainFolders(MEDIA_PATH, false, false);
            break;
		 case 'resizeThSizeMinus':
		 	if ($thumbSize > 3) {
			 	$thumbSize = $thumbSize-1;
			 	setcookie("thumbSize", $thumbSize, time() + (86400 * 365), "/");
		 	}
		 	break;
		 case 'resizeThSizeReset':
		 	$thumbSize = 5;
		 	setcookie("thumbSize", $thumbSize, time() + (86400 * 365), "/");
		 	break;
		 case 'resizeThSizePlus':
		 	if ($thumbSize < 8) {
			 	$thumbSize = $thumbSize+1;
			 	setcookie("thumbSize", $thumbSize, time() + (86400 * 365), "/");
		 	}
		 	break;
         case 'updateSizes':
            #if(!empty($_POST['previewSize'])) {
            #   $previewSize = $_POST['previewSize'];
            #   if ($previewSize < 100 || $previewSize > 1920) $previewSize = 640;
            #   setcookie("previewSize", $previewSize, time() + (86400 * 365), "/");
            #}        
            #if(!empty($_POST['thumbSize'])) {
            #   $thumbSize = $_POST['thumbSize'];
            #   if ($thumbSize < 32 || $thumbSize > 320) $thumbSize = 96;
            #   setcookie("thumbSize", $thumbSize, time() + (86400 * 365), "/");
            #}        
            break;
         case 'zipSel':
            if (!empty($_POST['check_list'])) {
               $zipname = getZip($_POST['check_list']);
            }
            break;
      }
   }

   $thumbnails = getThumbnails();

   $imagesAvailable = true;
   
   if (count($thumbnails) == 0) {
	   $imagesAvailable = false;
   }

   # ---------------- funcs

   function ZZZ_drawFile($f, $ts, $sel) {
		
		$fType = getFileType($f);
		$rFile = dataFilename($f);
		$fNumber = getFileIndex($f);
		$lapseCount = "";
		switch ($fType) {
			case 'v': $fIcon = '<span class="fa-stack"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-video-camera fa-stack-1x"></i></span>'; break;
			case 't': 
				$fIcon = '<span class="fa-stack"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-video-camera fa-stack-1x fa-inverse"></i></span>';
				$lapseCount = '(' . count(findLapseFiles($f)). ')';
				break;
			case 'i': $fIcon = '<span class="fa-stack"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-camera fa-stack-1x"></i></span>'; break;
			default : $fIcon = '<span class="fa-stack"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-camera fa-stack-1x"></i></span>'; break;
		}
		$duration ='';
		if (file_exists(MEDIA_PATH . "/$rFile")) {
			$fsz = filesize(MEDIA_PATH . "/$rFile");
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

	    $returnMe = '';

		switch ($ts) {
			case '3': $returnMe .= '<div class="col-sm-6 col-md-1">'; break;
			case '4': $returnMe .= '<div class="col-sm-6 col-md-2">'; break;
			case '5': $returnMe .= '<div class="col-sm-6 col-md-3">'; break;
			case '6': $returnMe .= '<div class="col-sm-6 col-md-4">'; break;
			case '7': $returnMe .= '<div class="col-sm-6 col-md-5">'; break;
			case '8': $returnMe .= '<div class="col-sm-6 col-md-6">'; break;
			default : $returnMe .= '<div class="col-sm-6 col-md-3">'; break;
		}

			$returnMe .= '<div class="thumbnail">';
				$returnMe .= '<img src="' . MEDIA_PATH . '/' . $f . '">';
				$returnMe .= '<div class="caption">';
					$returnMe .= '<h4>' . $fIcon . ' ' . $fNumber . '</h4>';
					$returnMe .= '<h5><small><i class="fa fa-calendar-o "></i> ' . $fDate . ' <i class="fa fa-clock-o"></i> ' . $fTime . '</small></h5>';

					if ($fsz > 0) {
						$doBRs = 0;
						if ($fsz > 0) {
							$returnMe .= '<i class="fa fa-floppy-o"></i> ' . FileSizeConvert($fsz) . '<br>';
						} else {
							$doBRs++;
						}			
						if (strlen($lapseCount) > 0) {
							$returnMe .= '<i class="fa fa-picture-o"></i> ' . $lapseCount . '<br>';	
						} else {
							$doBRs++;
						}
						if (strlen($duration) > 0) {
							$returnMe .= '<i class="fa fa-clock-o"></i> ' . secondsToTime($duration) . '<br>';
						} else {
							$doBRs++;
						}
						for ($i = 0; $i < $doBRs; $i++) {
							$returnMe .= '<br>';
						}
					} else {
						$returnMe .= '<i class="fa fa-square-o"></i> Busy<br><br><br>';
					}

					$returnMe .= '<p>';
						$returnMe .= '<a href="preview.php?preview=' . $f . '" name="delete1" class="btn btn-default btn-xs" role="button" ';
							if (!($fsz > 0)) {
								$returnMe .= 'disabled="disabled"';
							}
						$returnMe .= '><i class="fa fa-eye"></i> View</a>';
						$returnMe .= ' ';
						$returnMe .= '<button type="submit" name="delete1" value="' . $f . '" class="btn btn-danger btn-xs" role="button"><i class="fa fa-trash-o"></i> Delete</button>';
						$returnMe .= ' ';
						$returnMe .= "<input type='checkbox' name='check_list[]' $sel value='$f' style='float:right;'/>";
					$returnMe .= '</p>';
				$returnMe .= '</div>';
			$returnMe .= '</div>';
		$returnMe .= '</div>';

		return $returnMe;
		
		#echo "<fieldset class='fileicon' style='width:" . $fWidth . "px;'>";
		#echo "<legend class='fileicon'>";
		#echo "<button type='submit' name='delete1' value='$f' class='fileicondelete' style='background-image:url(delete.png);'></button>";
		#echo "&nbsp;&nbsp;$fNumber&nbsp;";
		#echo "<img src='$fIcon' style='width:24px'/>";
		#echo "<input type='checkbox' name='check_list[]' $sel value='$f' style='float:right;'/>";
		#echo "</legend>";
		#if ($fsz > 0) echo "$fsz Kb $lapseCount $duration"; else echo 'Busy';
		#echo "<br>$fDate<br>$fTime<br>";
		#if ($fsz > 0) echo "<a title='$rFile' href='preview.php?preview=$f'>";
		#echo "<img src='" . MEDIA_PATH . "/$f' style='width:" . $ts . "px'/>";
		#if ($fsz > 0) echo "</a>";
		#echo "</fieldset> ";



   }

?>