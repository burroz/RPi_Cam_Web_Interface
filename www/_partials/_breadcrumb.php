<div class="container">
	<ol class="breadcrumb">
		<?php
			switch (NAV_POS) {
				case 'index':
					echo '<li class="active">Live</li>';
					break;
				case 'preview':
					echo '<li><a href="index.php">Live</a></li>';
					echo '<li class="active">Downloads</li>';
					break;
				case 'motion':
					echo '<li><a href="index.php">Live</a></li>';
					echo '<li><a href="motion.php">Settings</a></li>';
					echo '<li class="active">Motion</li>';
					break;
				case 'motion':
					echo '<li><a href="index.php">Live</a></li>';
					echo '<li><a href="motion.php">Settings</a></li>';
					echo '<li class="active">Schedule</li>';
					break;
				case 'camera':
					echo '<li><a href="index.php">Live</a></li>';
					echo '<li><a href="motion.php">Settings</a></li>';
					echo '<li class="active">Camera</li>';
					break;
			}
		?>
	</ol>
</div>