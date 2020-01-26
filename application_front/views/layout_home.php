<!DOCTYPE html>
<html lang="en">
  <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="title" content="<?php echo constant('GLOBAL_META_TITLE') ?>">
        <meta name="keywords" content="<?php echo constant('GLOBAL_META_KEYWORDS') ?>">
        <meta name="description" content="<?php echo constant('GLOBAL_META_DESCRIPTION') ?>">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?php echo constant('GLOBAL_META_TITLE') ?></title>
        <link rel="icon" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>assets/images/fav.ico">
        <!-- all css here -->
        <link href="https://fonts.googleapis.com/css?family=Poppins%7CQuicksand:400,500,700" rel="stylesheet">
        <!-- FONT-AWESOME ICON CSS -->
          <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>assets/css/font-awesome.min.css">
          <!--== ALL CSS FILES ==-->
          <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>assets/css/style.css">
          <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>assets/css/materialize.css">
          <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>assets/css/bootstrap.css">
          <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>assets/css/mob.css">
          <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>assets/css/animate.css">
          <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
          <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
          <!--[if lt IE 9]>
        <script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>assets/js/html5shiv.js"></script>
        <script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>assets/js/respond.min.js"></script>
        <![endif]-->
        <link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>assets/vendor/pnotify/dist/pnotify.css" rel="stylesheet">
        <link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>assets/vendor/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
        <link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>assets/vendor/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">
        <link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>assets/css/loader.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  </head>
  
  <div class="loading" id="load-txt" style="display: none;">Loading&#8230;</div>
  <?php $page = $this->uri->segment(2); ?>
  <body>
    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
	<!--Header Section-->
	<?php echo isset($content_for_layout_header)?$content_for_layout_header:'';?>
	<!--Main Section-->
	<?php echo isset($content_for_layout_main)?$content_for_layout_main:'';?>
	<!--Footer Section-->
	<?php echo isset($content_for_layout_footer)?$content_for_layout_footer:'';?>
   <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>assets/js/bootstrap.js"></script>
    <script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>assets/js/wow.min.js"></script>
    <script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>assets/js/materialize.min.js"></script>
    <script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>assets/js/custom.js"></script>
	  <script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>assets/vendor/pnotify/dist/pnotify.js"></script>
    <script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>assets/vendor/pnotify/dist/pnotify.buttons.js"></script>
    <script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>assets/vendor/pnotify/dist/pnotify.nonblock.js"></script>

	<script>
	$("input").on("keypress", function(e) {
	if (e.which === 32 && !this.value.length)
		e.preventDefault();
	});
	</script>
	<!-- PNotify -->
        <script>
          $(document).ready(function() {
			    //console.log("<?php echo $succmsg; ?><?php echo $errmsg; ?>");
            <?php if($succmsg!='' || $errmsg!=''){ ?>
            new PNotify({
               title: '<?php echo $succmsg!=""?"Success":"Error";?>',
              text: '<?php echo $succmsg!=""?$succmsg:$errmsg;?>',
              type: '<?php echo $succmsg!=""?"success":"error";?>',
              styling: 'bootstrap3'
            });
            <?php } ?>
          });
        </script>
        <!-- /PNotify -->
  </body>
</html>