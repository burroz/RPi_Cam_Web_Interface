
	<form action="preview.php" method="POST">
	<div class="row">
		<div class="col-md-6">
			<!-- <h3>Actions</h3> -->
			<div class="btn-group" role="group">
				<button type="submit" name="action" value="selectNone" class="btn btn-default" <?php if (!$imagesAvailable) { echo 'disabled="disabled"'; } ?>>
					<?php echo BTN_SELECTNONE; ?>
				</button>
				<button type="submit" name="action" value="selectAll" class="btn btn-default" <?php if (!$imagesAvailable) { echo 'disabled="disabled"'; } ?>>
					<?php echo BTN_SELECTALL; ?>
				</button>
			</div>
			<div class="btn-group" role="group">
				<button type="submit" name="action" value="zipSel" class="btn btn-default" <?php if (!$imagesAvailable) { echo 'disabled="disabled"'; } ?>>
					<?php echo BTN_GETZIP; ?>
				</button>
			</div>
			<div class="btn-group" role="group">
				<button type="submit" name="action" value="deleteSel" class="btn btn-danger" onclick="return confirm('Are you sure?');" <?php if (!$imagesAvailable) { echo 'disabled="disabled"'; } ?>>
					<?php echo BTN_DELETESEL; ?>
				</button>
				<button type="submit" name="action" value="deleteAll" class="btn btn-danger" onclick="return confirm('Are you sure?');" <?php if (!$imagesAvailable) { echo 'disabled="disabled"'; } ?>>
					<?php echo BTN_DELETEALL; ?>
				</button>
			</div>
		</div>
		<div class="col-md-4">
			<?php
				$diskUsage = diskUsage();
				$useColor = "success";
				if ($diskUsage['usedPercent'] >= 90) {
				   $useColor = "danger";
				} else if ($diskUsage['usedPercent'] >= 75) {
				   $useColor = "warning";
				}
				$writeRight = true;
				if ($diskUsage['usedPercent'] > 50) {
					$writeRight = false;
				}
				$usedLabel = round($diskUsage['usedPercent']) . '%';
				$freeLabel = round($diskUsage['currentAvailablePercent']) . '%';
				$writtenLabel = "Used " . FileSizeConvert($diskUsage['used']) . " of " . FileSizeConvert($diskUsage['total']);
				if ($diskUsage['usedPercent'] >= 50) {
					$usedLabel = $writtenLabel;
				} else {
					$freeLabel = $writtenLabel;					
				}
			?>
			<p>
				<div class="progress">
					<div class="progress-bar progress-bar-primary progress-bar-striped" style="width:<?php echo round($diskUsage['usedPercent']); ?>%;">
						<?php echo (round($diskUsage['usedPercent']) > 5) ? $usedLabel : ''; ?>
					</div>
					<div class="progress-bar progress-bar-<?php echo $useColor; ?> progress-bar-striped" style="width:<?php echo round($diskUsage['currentAvailablePercent']); ?>%;">
						<?php  echo $freeLabel; ?>
					</div>
				</div>
			</p>
		</div>
		<div class="col-md-2">
			<div class="btn-group" role="group">
				<button type="submit" name="action" value="resizeThSizeMinus" class="btn btn-default">
					<i class="fa fa-minus-square"></i>
				</button>
				<button type="submit" name="action" value="resizeThSizeReset" class="btn btn-default">
					<i class="fa fa-picture-o"></i>
				</button>
				<button type="submit" name="action" value="resizeThSizePlus" class="btn btn-default">
					<i class="fa fa-plus-square"></i>
				</button>
			</div>
		</div>
	</div>
	<div class="row">
		<!-- preview -->
		<?php
			#if ($pFile != "") {
			#	$pIndex = array_search($tFile, $thumbnails);
			#	echo "<h1>" . TXT_PREVIEW . ":  " . getFileType($tFile) . getFileIndex($tFile);
			#	if ($pIndex > 0) {
			#		$attr = 'onclick="location.href=\'preview.php?preview=' . $thumbnails[$pIndex-1] . '\'"';
			#	} else {
			#		$attr = 'disabled';
			#	}
			#	echo "&nbsp;&nbsp;<input type='button' value='&larr;' class='btn btn-primary' name='prev' $attr >";
			#	if (($pIndex+1) < count($thumbnails)) {
			#		$attr = 'onclick="location.href=\'preview.php?preview=' . $thumbnails[$pIndex+1] . '\'"';
			#	} else {
			#		$attr = 'disabled';
			#	}
			#	echo "&nbsp;&nbsp;<input type='button' value='&rarr;' class='btn btn-primary' name='next' $attr>";
			#	echo "&nbsp;&nbsp;<button class='btn btn-primary' type='submit' name='download1' value='$tFile'>" . BTN_DOWNLOAD . "</button>";
			#	echo "&nbsp;<button class='btn btn-danger' type='submit' name='delete1' value='$tFile'>" . BTN_DELETE . "</button>";
			#	if(getFileType($tFile) == "t") {
			#		$convertCmd = file_get_contents(BASE_DIR . '/' . CONVERT_CMD);
			#		echo "&nbsp;<button class='btn btn-primary' type='submit' name='convert' value='$tFile'>" . BTN_CONVERT . "</button>";
			#		echo "<br></h1>Convert using: <input type='text' size=72 name = 'convertCmd' id='convertCmd' value='$convertCmd'><br><br>";
			#	} else {
			#		echo "<br></h1>";
			#	}
			#	if(substr($pFile, -3) == "jpg") {
			#		echo "<a href='" . MEDIA_PATH . "/$tFile' target='_blank'><img src='" . MEDIA_PATH . "/$pFile' width='" . $previewSize . "px'></a>";
			#	} else {
			#		echo "<video width='" . $previewSize . "px' controls><source src='" . MEDIA_PATH . "/$pFile' type='video/mp4'>Your browser does not support the video tag.</video>";
			#	}
			#}
			#if ($debugString !="") {
			#	echo "$debugString<br>";
			#}
		?>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?php
				if ($imagesAvailable) {
					foreach($thumbnails as $file) {

						$fType = getFileType($file);
						$rFile = dataFilename($file);
						$fNumber = getFileIndex($file);
						$lapseCount = "";

						switch ($fType) {
							case 'v': $fIcon = '<i class="fa fa-video-camera"></i>'; break;
							case 't': 
								$fIcon = '<i class="fa fa-file-video-o"></i>';
								$lapseCount = '(' . count(findLapseFiles($file)). ')';
								break;
							case 'i': $fIcon = '<i class="fa fa-camera"></i>'; break;
							default : $fIcon = '<i class="fa fa-camera"></i>'; break;
						}

						$duration ='';

						if (file_exists(MEDIA_PATH . "/$rFile")) {
							$fsz = filesize(MEDIA_PATH . "/$rFile");
							$fModTime = filemtime(MEDIA_PATH . "/$rFile");
							if ($fType == 'v') {
								$duration = ($fModTime - filemtime(MEDIA_PATH . "/$file")) . 's';
							}
						} else {
							$fsz = 0;
							$fModTime = filemtime(MEDIA_PATH . "/$file");
						}

						$fDate = @date('Y-m-d', $fModTime);
						$fTime = @date('H:i:s', $fModTime);

						switch ($thumbSize) {
							case '3': $grid = 'col-sm-6 col-md-1'; break;
							case '4': $grid = 'col-sm-6 col-md-2'; break;
							case '5': $grid = 'col-sm-6 col-md-3'; break;
							case '6': $grid = 'col-sm-6 col-md-4'; break;
							case '7': $grid = 'col-sm-6 col-md-5'; break;
							case '8': $grid = 'col-sm-6 col-md-6'; break;
							default : $grid = 'col-sm-6 col-md-3'; break;
						}

						echo '<div class="' . $grid . '">';
							echo '<div class="panel panel-default">';
								echo '<div class="panel-heading">';
									echo '<h5 class="media-heading">' . $fIcon . ' ' . $fNumber . '</h5>';
								echo '</div>';
								echo '<div class="panel-body">';
									echo '<div class="media">';
										echo '<div class="media-left">';
											#echo '<a href="#">';
												echo '<img class="media-object" src="' .  MEDIA_PATH . '/' . $file . '" style="height:75px;">';
											#echo '</a>';
										echo '</div>';
										echo '<div class="media-body">';
											
											echo '<h5><small><i class="fa fa-calendar-o "></i> ' . $fDate . ' <i class="fa fa-clock-o"></i> ' . $fTime . '</small></h5>';
											if ($fsz > 0) {
												$doBRs = 0;
												if ($fsz > 0) {
													echo '<i class="fa fa-floppy-o"></i> ' . FileSizeConvert($fsz) . '<br>';
												} else {
													$doBRs++;
												}			
												if (strlen($lapseCount) > 0) {
													echo '<i class="fa fa-picture-o"></i> ' . $lapseCount . '<br>';	
												} else {
													$doBRs++;
												}
												if (strlen($duration) > 0) {
													echo '<i class="fa fa-clock-o"></i> ' . secondsToTime($duration) . '<br>';
												} else {
													$doBRs++;
												}
												for ($i = 0; $i < $doBRs; $i++) {
													echo '<br>';
												}
											} else {
												echo '<i class="fa fa-square-o"></i> Busy<br><br><br>';
											}
											#echo '<p>';
											#	echo '<a href="preview.php?preview=' . $file . '" name="delete1" class="btn btn-default btn-xs" role="button"' . ((!($fsz > 0)) ? ' disabled="disabled"' : '') . '><i class="fa fa-eye"></i> View</a>';
											#	echo ' ';
											#	echo '<button type="submit" name="delete1" value="' . $file . '" class="btn btn-danger btn-xs" role="button"><i class="fa fa-trash-o"></i> Delete</button>';
											#	echo ' ';
											#	echo '<input type="checkbox" name="check_list[]" ' . $dSelect . 'value="' . $file . '" style="float:right;">';
											#echo '</p>';
										echo '</div>';
									echo '</div>';
								echo '</div>';
								echo '<div class="panel-footer">';
									echo '<a href="preview.php?preview=' . $file . '" name="delete1" class="btn btn-default btn-xs" role="button"' . ((!($fsz > 0)) ? ' disabled="disabled"' : '') . '><i class="fa fa-eye"></i> View</a>';
									echo ' ';
									echo '<button type="submit" name="delete1" value="' . $file . '" class="btn btn-danger btn-xs" role="button"><i class="fa fa-trash-o"></i> Delete</button>';
									echo ' ';
									echo '<input type="checkbox" name="check_list[]" ' . $dSelect . 'value="' . $file . '" style="float:right;">';
								echo '</div>';
							echo '</div>';
						echo '</div>';

						#echo '<div class="' . $grid . '">';
						#	echo '<div class="thumbnail">';
						#		echo '<img src="' .  MEDIA_PATH . '/' . $file . '">';
						#		echo '<div class="caption">';
						#			echo '<h4>' . $fIcon . ' ' . $fNumber . '</h4>';
						#			echo '<h5><small><i class="fa fa-calendar-o "></i> ' . $fDate . ' <i class="fa fa-clock-o"></i> ' . $fTime . '</small></h5>';
						#			if ($fsz > 0) {
						#				$doBRs = 0;
						#				if ($fsz > 0) {
						#					echo '<i class="fa fa-floppy-o"></i> ' . FileSizeConvert($fsz) . '<br>';
						#				} else {
						#					$doBRs++;
						#				}			
						#				if (strlen($lapseCount) > 0) {
						#					echo '<i class="fa fa-picture-o"></i> ' . $lapseCount . '<br>';	
						#				} else {
						#					$doBRs++;
						#				}
						#				if (strlen($duration) > 0) {
						#					echo '<i class="fa fa-clock-o"></i> ' . secondsToTime($duration) . '<br>';
						#				} else {
						#					$doBRs++;
						#				}
						#				for ($i = 0; $i < $doBRs; $i++) {
						#					echo '<br>';
						#				}
						#			} else {
						#				echo '<i class="fa fa-square-o"></i> Busy<br><br><br>';
						#			}
						#			echo '<p>';
						#				echo '<a href="preview.php?preview=' . $file . '" name="delete1" class="btn btn-default btn-xs" role="button"' . ((!($fsz > 0)) ? ' disabled="disabled"' : '') . '><i class="fa fa-eye"></i> View</a>';
						#				echo ' ';
						#				echo '<button type="submit" name="delete1" value="' . $file . '" class="btn btn-danger btn-xs" role="button"><i class="fa fa-trash-o"></i> Delete</button>';
						#				echo ' ';
						#				echo '<input type="checkbox" name="check_list[]" ' . $dSelect . 'value="' . $file . '" style="float:right;">';
						#			echo '</p>';
						#		echo '</div>';
						#	echo '</div>';
						#echo '</div>';
						
					}
				} else {
					?>
						<div class="alert alert-danger" role="alert">
							<i class="fa fa-exclamation-circle"></i> A No videos/images available!
						</div>				
					<?php
				}
			?>
		</div>
	</div>
	<div class="row">
		<?php
			echo "<p><p>" . TXT_PREVIEW . " <input type='text' size='4' name='previewSize' value='$previewSize'>";
			echo "&nbsp;&nbsp;" . TXT_THUMB . " <input type='text' size='3' name='thumbSize' value='$thumbSize'>";
			echo "&nbsp;&nbsp;<button class='btn btn-primary' type='submit' name='action' value='updateSizes'>" . BTN_UPDATESIZES . "</button>";
		?>
	</div>
	</form>
		<form id="zipform" method="post" action="preview.php" style="display:none;">
			<input id="zipdownload" type="hidden" name="zipdownload"/>
		</form>

	<!--
    <div class="row">
		<div id="progress" style="text-align:center;margin-left:20px;width:500px;border:1px solid #ccc;">&nbsp;</div>
    </div>
    -->




			
<?php 
	if ($zipname) {
		echo '<script language="javascript">get_zip_progress("' . $zipname . '");</script>';
	} else {
		echo '<script language="javascript">document.getElementById("progress").style.display="none";</script>';
	}
?>