<?php #echo $displayStyle; ?>
<?
	if (!defined('NAV_POS')) {
		define('NAV_POS','index');
	}
?>
<nav class="navbar navbar-default">
  <div class="container-fluid">
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
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Settings <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
			<li class="<? if (NAV_POS == "motion") { echo "active"; } ?>"><a href="motion.php">Motion settings</a></li>
    	    <li class="<? if (NAV_POS == "schedule") { echo "active"; } ?>" ><a href="schedule.php">Schedule settings</a></li>
            <li class="divider"></li>
	        <li class="<? if (NAV_POS == "camera") { echo "active"; } ?>"><a href="camera.php">Camera settings</a></li>
          </ul>
        </li>
		<li class="<? if (NAV_POS == "system") { echo "active"; } ?>"><a href="#">System</a></li>
      </ul>
    </div>
  </div>
</nav>