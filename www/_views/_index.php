<div class="container">
	<div class="row">
		<div class="col-md-10 text-center liveimage">
			<img id="mjpeg_dest" <?php if(file_exists("pipan_on")) echo "ontouchstart=\"pipan_start()\""; ?> onclick="toggle_fullscreen(this);" src="/loading.jpg">
		</div>
		<div class="col-md-2" id="main-buttons" <?php #echo $displayStyle; ?> >
			<div class="row">
				<input id="video_button" type="button" class="btn btn-default btn-block">
				<input id="image_button" type="button" class="btn btn-default btn-block">
				<input id="timelapse_button" type="button" class="btn btn-default btn-block">
				<input id="md_button" type="button" class="btn btn-default btn-block">
				<input id="halt_button" type="button" class="btn btn-warning btn-block">
			</div>
		</div>
	</div>
	<div class="row">
	
		
			<div class="panel panel-default">
				<div class="panel-heading">1. Resolution</div>
				<div class="panel-body">
					<div class="form-group">
						<label for="">Load Preset</label>
						<select onchange="set_preset(this.value)" class="form-control">
							<option value="1920 1080 25 25 2592 1944">Select option...</option>
							<option value="1920 1080 25 25 2592 1944">Std FOV</option>
							<option value="1296 730 25 25 2592 1944">16:9 wide FOV</option>
							<option value="1296 976 25 25 2592 1944">4:3 full FOV</option>
							<option value="1920 1080 01 30 2592 1944">Std FOV, x30 Timelapse</option>
						</select>
					</div>
					<hr>
					<h5>Custom Values</h5>
					<form class="form-inline">
						<div>
							<div class="form-group">
								<label>Video res:</label>
								<?php makeInput('video_width', 4); ?>
								<label>x</label>
								<?php makeInput('video_height', 4); ?>
								<label>px</label>
							</div>
						</div>
						<div>
							<div class="form-group">
								<label>Video fps:</label>
								<?php makeInput('video_fps', 2); ?>
								<label>recording,</label>
								<?php makeInput('MP4Box_fps', 4); ?>
								<label>boxing</label>
							</div>
						</div>
						<div>
							<div class="form-group">
								<label>Image res:</label>
								<?php makeInput('image_width', 4); ?>
								<label>x</label>
								<?php makeInput('image_height', 4); ?>
								<label>px</label>
								<button class="btn btn-default btn-sm" onclick="set_res();"><i class="fa fa-floppy-o"></i> save</button>
							</div>
						</div>
					</form>
					<hr>
					<form class="form-inline">
						<div class="form-group">
							<label>Timelapse-Interval (0.1...3200)</label>
							<?php makeInput('tl_interval', 4); ?>
							<label>s</label>
							<button class="btn btn-default btn-sm" onclick="send_cmd('tv ' + 10 * document.getElementById('tl_interval').value)"><i class="fa fa-floppy-o"></i> save</button>
						</div>
					</form>
				</div>
			</div>
		
			<div class="panel panel-default">
				<div class="panel-heading">2. Annotation (max 127 characters)</div>
				<div class="panel-body">
					<form class="form-inline">
						<div>
							<div class="form-group">
								<label>Text:</label>
								<?php makeInput('annotation', 20); ?>
								<button class="btn btn-default btn-sm" onclick="send_cmd('an ' + encodeURI(document.getElementById('annotation').value))"><i class="fa fa-floppy-o"></i> save</button>
								<button class="btn btn-default btn-sm" onclick="document.getElementById('annotation').value = 'RPi Cam %Y.%M.%D_%h:%m:%s'; send_cmd('an ' + encodeURI(document.getElementById('annotation').value))"><i class="fa fa-undo"></i> set default</button>
							</div>
						</div>
						<div>
							<div class="form-group">
								<label>Annotation size (0-99):</label>
								<?php makeInput('anno_text_size', 3); ?>
								<button class="btn btn-default btn-sm" onclick="send_cmd('as ' + document.getElementById('anno_text_size').value)"><i class="fa fa-floppy-o"></i> save</button>
								<label>Custom text color:</label>
								<select id="at_en"><?php makeOptions($options_at_en, 'anno3_custom_text_colour'); ?></select> y:u:v = <?php makeInput('at_y', 3, 'anno3_custom_text_Y'); ?>:<?php makeInput('at_u', 4, 'anno3_custom_text_U'); ?>:<?php makeInput('at_v', 4, 'anno3_custom_text_V'); ?>
								<button class="btn btn-default btn-sm" onclick="set_at();"><i class="fa fa-floppy-o"></i> save</button>
							</div>
						</div>
						<div>
							<div class="form-group">
								<label>Background:</label>
								<select onchange="send_cmd('ab ' + this.value)"><?php makeOptions($options_ab, 'anno_background'); ?></select>
								<label>Custom background color:</label>
								<select id="ac_en"><?php makeOptions($options_ac_en, 'anno3_custom_background_colour'); ?></select> y:u:v = <?php makeInput('ac_y', 3, 'anno3_custom_background_Y'); ?>:<?php makeInput('ac_u', 4, 'anno3_custom_background_U'); ?>:<?php makeInput('ac_v', 4, 'anno3_custom_background_V'); ?>
								<button class="btn btn-default btn-sm" onclick="set_ac();"><i class="fa fa-floppy-o"></i> save</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		
			<?php if (file_exists("pilight_on")) pilight_controls(); ?>
		
			<div class="panel panel-default">	
				<div class="panel-heading">3. Light and Image</div>
				<div class="panel-body">
					<form class="form-inline">
						<div>
							<div class="form-group">
								<label>Buffer (1000... ms), default 0:</label>
								<?php makeInput('video_buffer', 4); ?>
								<button class="btn btn-default btn-sm" onclick="send_cmd('bu ' + document.getElementById('video_buffer').value)"><i class="fa fa-floppy-o"></i> save</button>
							</div>
						</div>
						<div>
							<div class="form-group">
								<label>Sharpness (-100...100), default 0:</label>
								<?php makeInput('sharpness', 4); ?>
								<button class="btn btn-default btn-sm" onclick="send_cmd('sh ' + document.getElementById('sharpness').value)"><i class="fa fa-floppy-o"></i> save</button>
							</div>
						</div>
						<div>
							<div class="form-group">
								<label>Contrast (-100...100), default 0:</label>
								<?php makeInput('contrast', 4); ?>
								<button class="btn btn-default btn-sm" onclick="send_cmd('co ' + document.getElementById('contrast').value)"><i class="fa fa-floppy-o"></i> save</button>
							</div>
						</div>
						<div>
							<div class="form-group">
								<label>Brightness (0...100), default 50:</label>
								<?php makeInput('brightness', 4); ?>
								<button class="btn btn-default btn-sm" onclick="send_cmd('br ' + document.getElementById('brightness').value)"><i class="fa fa-floppy-o"></i> save</button>
							</div>
						</div>
						<div>
							<div class="form-group">
								<label>Saturation (-100...100), default 0:</label>
								<?php makeInput('saturation', 4); ?>
								<button class="btn btn-default btn-sm" onclick="send_cmd('sa ' + document.getElementById('saturation').value)"><i class="fa fa-floppy-o"></i> save</button>
							</div>
						</div>
						<div>
							<div class="form-group">
								<label>ISO (100...800), default 0:</label>
								<?php makeInput('iso', 4); ?>
								<button class="btn btn-default btn-sm" onclick="send_cmd('is ' + document.getElementById('iso').value)"><i class="fa fa-floppy-o"></i> save</button>
							</div>
						</div>
						<div>
							<div class="form-group">
								<label>Metering Mode, default 'average':</label>
								<select onchange="send_cmd('mm ' + this.value)"><?php makeOptions($options_mm, 'metering_mode'); ?></select>
							</div>
						</div>
					</form>
				</div>
			</div>
		
			<div class="panel panel-default">
				<div class="panel-heading">4. Image orientation</div>
				<div class="panel-body">
					Video Stabilisation, default: 'off'
					<select onchange="send_cmd('vs ' + this.value)"><?php makeOptions($options_vs, 'video_stabilisation'); ?></select>
					Rotation, default 0:
					<select onchange="send_cmd('ro ' + this.value)"><?php makeOptions($options_ro, 'rotation'); ?></select>
					Flip, default 'none':
					<select onchange="send_cmd('fl ' + this.value)"><?php makeOptions($options_fl, 'flip'); ?></select>
				</div>
			</div>
		
			<div class="panel panel-default">
				<div class="panel-heading">5. Exposure</div>
				<div class="panel-body">
					Exposure Compensation (-10...10), default 0:
					<?php makeInput('exposure_compensation', 4); ?>
					<button class="btn btn-default btn-sm" onclick="send_cmd('ec ' + document.getElementById('exposure_compensation').value)"><i class="fa fa-floppy-o"></i> save</button>
					Exposure Mode, default 'auto':
					<select onchange="send_cmd('em ' + this.value)"><?php makeOptions($options_em, 'exposure_mode'); ?></select>
					White Balance, default 'auto':
					<select onchange="send_cmd('wb ' + this.value)"><?php makeOptions($options_wb, 'white_balance'); ?></select>
					Image Effect, default 'none':
					<select onchange="send_cmd('ie ' + this.value)"><?php makeOptions($options_ie, 'image_effect'); ?></select>
					Colour Effect, default 'disabled':
					<select id="ce_en"><?php makeOptions($options_ce_en, 'colour_effect_en'); ?></select> u:v = <?php makeInput('ce_u', 4, 'colour_effect_u'); ?>:<?php makeInput('ce_v', 4, 'colour_effect_v'); ?>
					<button class="btn btn-default btn-sm" onclick="set_ce();"><i class="fa fa-floppy-o"></i> save</button>
					Sensor Region, default 0/0/65536/65536:
					x<?php makeInput('roi_x', 5, 'sensor_region_x'); ?> y<?php makeInput('roi_y', 5, 'sensor_region_y'); ?> w<?php makeInput('roi_w', 5, 'sensor_region_w'); ?> h<?php makeInput('roi_h', 4, 'sensor_region_h'); ?>
					<button class="btn btn-default btn-sm" onclick="set_roi();"><i class="fa fa-floppy-o"></i> save</button>
					Shutter speed (0...330000), default 0:
					<?php makeInput('shutter_speed', 4); ?>
					<button class="btn btn-default btn-sm" onclick="send_cmd('ss ' + document.getElementById('shutter_speed').value)"><i class="fa fa-floppy-o"></i> save</button>
				</div>
			</div>
		
			<div class="panel panel-default">
				<div class="panel-heading">6. Others</div>
				<div class="panel-body">
					Image quality (0...100), default 85:
					<?php makeInput('image_quality', 4); ?>
					<button class="btn btn-default btn-sm" onclick="send_cmd('qu ' + document.getElementById('image_quality').value)"><i class="fa fa-floppy-o"></i> save</button>
					Preview quality (0...100) Default 25:<br>Width (128...1024) Default 512:<br>Divider (1-16) Default 1: Qu: <?php makeInput('quality', 4); ?> Wi: <?php makeInput('width', 4); ?> Di: <?php makeInput('divider', 4); ?>
					<button class="btn btn-default btn-sm" onclick="set_preview();"><i class="fa fa-floppy-o"></i> save</button>
					Raw Layer, default: 'off' <select onchange="send_cmd('rl ' + this.value)"><?php makeOptions($options_rl, 'raw_layer'); ?></select>
					Video bitrate (0...25000000), default 17000000: <?php makeInput('video_bitrate', 10); ?>
					<button class="btn btn-default btn-sm" onclick="send_cmd('bi ' + document.getElementById('video_bitrate').value)"><i class="fa fa-floppy-o"></i> save</button>
					MP4 Boxing mode : <select onchange="send_cmd('bo ' + this.value)"><?php makeOptions($options_bo, 'MP4Box'); ?></select>
					Watchdog, default interval 3s, errors 3<br>Interval <?php makeInput('watchdog_interval', 3); ?>s&nbsp;&nbsp;&nbsp;&nbsp;Errors <?php makeInput('watchdog_errors', 3); ?>
					<button class="btn btn-default btn-sm" onclick="send_cmd('wd ' + 10 * document.getElementById('watchdog_interval').value + ' ' + document.getElementById('watchdog_errors').value)"><i class="fa fa-floppy-o"></i> save</button>
				</div>
			</div>
		

	</div>
</div>

<!--
<input id="toggle_display" type="button" class="btn btn-primary" value="<?php echo $toggleButton; ?>" style="position:absolute;top:60px;right:10px;" onclick="set_display(this.value);">
-->



<!--
	<div class="row text-center">
         <div class="panel-group" id="accordion" <?php #echo $displayStyle; ?> >
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h2 class="panel-title">
                     <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">System</a>
                  </h2>
               </div>
               <div id="collapseTwo" class="panel-collapse collapse">
                  <div class="panel-body">
                     <input id="toggle_stream" type="button" class="btn btn-primary" value="<?php #echo $streamButton; ?>" onclick="set_stream_mode(this.value);">
                     <input id="shutdown_button" type="button" value="shutdown system" onclick="sys_shutdown();" class="btn btn-danger">
                     <input id="reboot_button" type="button" value="reboot system" onclick="sys_reboot();" class="btn btn-danger">
                     <input id="reset_button" type="button" value="reset settings" onclick="send_cmd('rs 1');setTimeout(function(){location.reload(true);}, 1000);" class="btn btn-danger">
                     <form action='<?php #echo ROOT_PHP; ?>' method='POST'>
                        <br>Style
                        <select name='extrastyle' id='extrastyle'>
                           <?php #getExtraStyles(); ?>
                        </select>
                        &nbsp;<button type="submit" name="OK" value="OK" ><i class="fa fa-floppy-o"></i> save</button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      -->
      <?php #if ($debugString != "") echo "$debugString<br>"; ?>