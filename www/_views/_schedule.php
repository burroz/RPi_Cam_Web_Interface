<?php
	if (!$cliCall) {
		echo '<div class="container-fluid">';
		echo '<form action="schedule.php" method="POST">';
		if ($debugString) echo $debugString . "<br>";
		if ($showLog) {
			echo "&nbsp&nbsp;<button class='btn btn-primary' type='submit' name='action' value='downloadlog'>" . BTN_DOWNLOADLOG . "</button>";
			echo "&nbsp&nbsp;<button class='btn btn-primary' type='submit' name='action' value='clearlog'>" . BTN_CLEARLOG . "</button><br><br>";
			displayLog();
		} else {
			echo '<div class="container-fluid text-center">';
			echo "&nbsp;&nbsp;<button class='btn btn-primary' type='submit' name='action' value='save'>" . BTN_SAVE . "</button>";
			echo "&nbsp;&nbsp;<button class='btn btn-primary' type='submit' name='action' value='backup'>" . BTN_BACKUP . "</button>";
			echo "&nbsp;&nbsp;<button class='btn btn-primary' type='submit' name='action' value='restore'>" . BTN_RESTORE . "</button>";
			echo "&nbsp;&nbsp;<button class='btn btn-primary' type='submit' name='action' value='showlog'>" . BTN_SHOWLOG . "</button>";
			echo '&nbsp;&nbsp;&nbsp;&nbsp;';
			if ($schedulePID != 0) {
				echo "<button class='btn btn-danger' type='submit' name='action' value='stop'>" . BTN_STOP . "</button>";
			} else {
				echo "<button class='btn btn-danger' type='submit' name='action' value='start'>" . BTN_START . "</button>";
			}
			echo "<br></div>";
			showScheduleSettings($schedulePars);
		}
		echo '</form>';
		echo '</div>';
		cmdHelp();
	} else {
		mainCLI();
	}
?>