<?php #echo $displayStyle; ?>
<?php
	if (!defined('NAV_POS')) {
		define('NAV_POS','index');
	}
	$systemButtons = '';
	$systemButtons .= '<div class="container"><p>';
	$systemButtons .= '<input id="toggle_stream" type="button" class="btn btn-primary" value="' . $streamButton . '" onclick="set_stream_mode(this.value);">';
	$systemButtons .= '<input id="shutdown_button" type="button" value="shutdown system" onclick="sys_shutdown();" class="btn btn-danger">';
	$systemButtons .= '<input id="reboot_button" type="button" value="reboot system" onclick="sys_reboot();" class="btn btn-danger">';
	$systemButtons .= '<input id="reset_button" type="button" value="reset settings" onclick="send_cmd_temporaer();setTimeout(function(){location.reload(true);}, 1000);" class="btn btn-danger">';
	$systemButtons .= '</p></div>';
?>
<script>
function testme() {
	bootbox.dialog({
		title: "That html",
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
				<li class="dropdown <?php if (NAV_POS == "motion" || NAV_POS == "schedule" || NAV_POS == "camera") { echo 'active'; } ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Settings <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li class="<? if (NAV_POS == "motion") { echo "active"; } ?>"><a href="motion.php">Motion settings</a></li>
						<li class="<? if (NAV_POS == "schedule") { echo "active"; } ?>" ><a href="schedule.php">Schedule settings</a></li>
						<li class="divider"></li>
						<li class="<? if (NAV_POS == "camera") { echo "active"; } ?>"><a href="camera.php">Camera settings</a></li>
					</ul>
				</li>
				<li class="<? if (NAV_POS == "system") { echo "active"; } ?>"><a href="javascript:testme()" id="test">System</a></li>
			</ul>
		</div>
	</div>
</nav>