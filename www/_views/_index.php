<!--
<input id="toggle_display" type="button" class="btn btn-primary" value="<?php echo $toggleButton; ?>" style="position:absolute;top:60px;right:10px;" onclick="set_display(this.value);">
-->

<div class="row text-center liveimage">
	<div><img id="mjpeg_dest" <?php if(file_exists("pipan_on")) echo "ontouchstart=\"pipan_start()\""; ?> onclick="toggle_fullscreen(this);" src="/loading.jpg"></div>
	<div id="main-buttons" <?php echo $displayStyle; ?> >
		<input id="video_button" type="button" class="btn btn-primary">
		<input id="image_button" type="button" class="btn btn-primary">
		<input id="timelapse_button" type="button" class="btn btn-primary">
		<input id="md_button" type="button" class="btn btn-primary">
		<input id="halt_button" type="button" class="btn btn-danger">
	</div>
</div>


	<div class="row text-center">
         <div class="panel-group" id="accordion" <?php echo $displayStyle; ?> >
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h2 class="panel-title">
                     <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">System</a>
                  </h2>
               </div>
               <div id="collapseTwo" class="panel-collapse collapse">
                  <div class="panel-body">
                     <input id="toggle_stream" type="button" class="btn btn-primary" value="<?php echo $streamButton; ?>" onclick="set_stream_mode(this.value);">
                     <input id="shutdown_button" type="button" value="shutdown system" onclick="sys_shutdown();" class="btn btn-danger">
                     <input id="reboot_button" type="button" value="reboot system" onclick="sys_reboot();" class="btn btn-danger">
                     <input id="reset_button" type="button" value="reset settings" onclick="send_cmd('rs 1');setTimeout(function(){location.reload(true);}, 1000);" class="btn btn-danger">
                     <form action='<?php echo ROOT_PHP; ?>' method='POST'>
                        <br>Style
                        <select name='extrastyle' id='extrastyle'>
                           <?php getExtraStyles(); ?>
                        </select>
                        &nbsp;<button type="submit" name="OK" value="OK" >OK</button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <?php if ($debugString != "") echo "$debugString<br>"; ?>