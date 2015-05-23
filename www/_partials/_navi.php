<?php #echo $displayStyle; ?>
<?php
	if (!defined('NAV_POS')) {
		define('NAV_POS','index');
	}
	$systemButtons = '';
	if (NAV_POS == "index") {
		$systemButtons .= '<div>';
		$systemButtons .= '<input id="toggle_stream" type="button" class="btn btn-default btn-block" value="' . $streamButton . '" onclick="set_stream_mode(this.value);">';
		$systemButtons .= '<input id="shutdown_button" type="button" value="shutdown system" onclick="sys_shutdown();" class="btn btn-danger btn-block">';
		$systemButtons .= '<input id="reboot_button" type="button" value="reboot system" onclick="sys_reboot();" class="btn btn-warning btn-block">';
		$systemButtons .= '<input id="reset_button" type="button" value="reset settings" onclick="send_cmd_temporaer();setTimeout(function(){location.reload(true);}, 1000);" class="btn btn-danger btn-block">';
		$systemButtons .= '</div>';
	}
?>
<script>
function showSystemControllerButtons() {
	bootbox.dialog({
		title: "System",
		message: '<?php echo $systemButtons; ?>'
	});
}
function send_cmd_temporaer() {
	send_cmd('rs 1');
}
</script>
<nav class="navbar navbar-default">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php"><?php echo CAM_STRING; ?></a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li class="<? if (NAV_POS == "index") { echo "active"; } ?>"><a href="index.php">Live view</a></li>
				<li class="<? if (NAV_POS == "preview") { echo "active"; } ?>"><a href="preview.php">Downloads</a></li>
				<li class="dropdown <?php echo ( (NAV_POS == "motion" || NAV_POS == "schedule") ? 'active' : '' ); ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Settings <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li class="<? if (NAV_POS == "motion") { echo "active"; } ?>"><a href="motion.php">Motion Settings</a></li>
						<li class="<? if (NAV_POS == "schedule") { echo "active"; } ?>"><a href="schedule.php">Schedule Settings</a></li>
					</ul>
				</li>
			</ul>
			<?php
				if (NAV_POS == "index") {
					echo '<ul class="nav navbar-nav navbar-right">';
						echo '<li class="' . ( (NAV_POS == "system") ? 'active' : '') . '"><a href="javascript:showSystemControllerButtons()" id="test">System</a></li>';
					echo '</ul>';
				}
			?>
		</div>
	</div>
</nav>