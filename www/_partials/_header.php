<?php
   function getStyle() {
      return 'css/' . file_get_contents(BASE_DIR . '/css/extrastyle.txt');
   }
?>
<!DOCTYPE html>
<html>
   <head>
      <meta name="viewport" content="width=550, initial-scale=1">
      <title><?php echo CAM_STRING; ?></title>
	  <!-- Bootstrap -->
	  <!-- Latest compiled and minified CSS -->
	  <link rel="stylesheet" href="assets/bootstrap-3.3.4-dist/css/bootstrap.min.css">
	  <!-- Optional theme -->
	  <link rel="stylesheet" href="assets/bootstrap-3.3.4-dist/css/bootstrap-theme.min.css">
	  <!-- FontAwesome -->
	  <link rel="stylesheet" href="assets/font-awesome-4.3.0/css/font-awesome.min.css">

      <!-- <link rel="stylesheet" href="css/style_minified.css" /> -->
      <!-- <link rel="stylesheet" href="<?php #echo getStyle(); ?>" /> -->
      <!-- <script src="js/style_minified.js"></script> -->
      <script src="js/script.js"></script>
      <script src="js/pipan.js"></script>
      <script src="js/script.js"></script>

	  <link rel="stylesheet" href="css/style.css" />

   </head>
   <body onload="setTimeout('init(<?php echo "$mjpegmode, $video_fps, $divider" ?>);', 100);">
   
	   <?php include BASE_DIR . '/_partials/_navi.php'; ?>
	   
		<?php include BASE_DIR . '/_partials/_breadcrumb.php'; ?>