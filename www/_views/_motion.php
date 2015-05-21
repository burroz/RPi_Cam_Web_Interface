
<div class="row">
      <form action="motion.php" method="POST">
      <?php
      if ($debugString) echo $debugString . "<br>";
      echo '<div class="container-fluid text-center">';
      if ($showAll) {
         echo "<button class='btn btn-primary' type='submit' name='action' value='showLess'>" . BTN_SHOWLESS . "</button>";
      } else {
         echo "<button class='btn btn-primary' type='submit' name='action' value='showAll'>" . BTN_SHOWALL . "</button>";
      }
      echo "&nbsp;&nbsp;<button class='btn btn-primary' type='submit' name='action' value='save'>" . BTN_SAVE . "</button>";
      echo "&nbsp;&nbsp;<button class='btn btn-primary' type='submit' name='action' value='backup'>" . BTN_BACKUP . "</button>";
      echo "&nbsp;&nbsp;<button class='btn btn-primary' type='submit' name='action' value='restore'>" . BTN_RESTORE . "</button><br><br>";
      echo '</div>';
      if ($motionReady) {
         buildParsTable($motionPars, $filterPars, $showAll);
      } else {
         echo "<h1>Motion not running. Put in detection state</h1>";
      }
      ?>
      </form>
      </div>