<?

   function initCamPos() {
      $tr = fopen("pipan_bak.txt", "r");
      if($tr){
         while(($line = fgets($tr)) != false) {
           $vals = explode(" ", $line);
           echo '<script type="text/javascript">init_pt(',$vals[0],',',$vals[1],');</script>';
         }
         fclose($tr);
      }
   }

   function pipan_controls() {
      initCamPos();
      echo "<div class='container-fluid text-center liveimage'>";
      echo "<input type='button' class='btn btn-primary' value='up' onclick='servo_up();'><br>";
      echo "&nbsp<input type='button' class='btn btn-primary' value='left' onclick='servo_left();'>";
      echo "&nbsp<input type='button' class='btn btn-primary' value='down' onclick='servo_down();'>";
      echo "&nbsp<input type='button' class='btn btn-primary' value='right' onclick='servo_right();'>";
      echo "</div>";   
   }
  
   function pilight_controls() {
      echo "<tr>";
        echo "<td>Pi-Light:</td>";
        echo "<td>";
          echo "R: <input type='text' size=4 id='pilight_r' value='255'>";
          echo "G: <input type='text' size=4 id='pilight_g' value='255'>";
          echo "B: <input type='text' size=4 id='pilight_b' value='255'><br>";
          echo "<input type='button' value='ON/OFF' onclick='led_switch();'>";
        echo "</td>";
      echo "</tr>";
   }

   function getExtraStyles() {
      $files = scandir('css');
      foreach($files as $file) {
         if(substr($file,0,3) == 'es_') {
            echo "<option value='$file'>" . substr($file,3, -4) . '</option>';
         }
      }
   }
   
   #function getStyle() {
   #   return 'css/' . file_get_contents(BASE_DIR . '/css/extrastyle.txt');
   #}
   



   
?>