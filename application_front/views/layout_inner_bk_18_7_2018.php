<!DOCTYPE html>
<html lang="en">
  <head>
        <meta charset="utf-8">
        <link rel="Favicon" type="image/png" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/favicon.ico"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="title" content="<?php echo constant('GLOBAL_META_TITLE') ?>">
        <meta name="keywords" content="<?php echo constant('GLOBAL_META_KEYWORDS') ?>">
        <meta name="description" content="<?php echo constant('GLOBAL_META_DESCRIPTION') ?>">
        <!--<link rel="icon" href="<?php echo base_url().'public/images/favicon.png'; ?>">-->
		<link rel="icon" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/favicon.ico">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?php echo constant('GLOBAL_META_TITLE') ?></title>
        <!-- all css here -->
        <!-- bootstrap v3.3.7 css -->
        <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>css/line-awesome.min.css">
        <!-- theme css -->
        <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>css/theme.css">
        <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>css/responsive.css">
        <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>css/fullcalendar.css">

      <link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>js/vendor/pnotify/dist/pnotify.css" rel="stylesheet">
      <link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>js/vendor/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
      <link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>js/vendor/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">
	  
	  
	  <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>css/font-awesome.min.css">
	 <link rel="stylesheet" href="css/line-awesome.min.css">
    <!-- theme css -->
    <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>css/jquery.scrollbar.css">
    <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>css/slicknav.min.css">
    <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>css/theme.css">
    <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>css/responsive.css">
	  
      <!-- Optional theme -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  </head>
  <?php $page = $this->uri->segment(2); ?>
  <body>

  <div class="dashboard-bg">
	<!--Header Section--->
	<?php echo isset($content_for_layout_header)?$content_for_layout_header:'';?>
	
	<!--Main Section--->
	<?php echo isset($content_for_layout_main)?$content_for_layout_main:'';?>
    </div>
	
	<!--Footer Section--->
	<?php echo isset($content_for_layout_footer)?$content_for_layout_footer:'';?>
   <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>js/vendor/jquery-migrate-1.2.1.js"></script>
    <script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>js/vendor/bootstrap.min.js"></script>
	<script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>js/vendor/main.js"></script>
	<script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>js/vendor/pnotify/dist/pnotify.js"></script>
    <script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>js/vendor/pnotify/dist/pnotify.buttons.js"></script>
    <script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>js/vendor/pnotify/dist/pnotify.nonblock.js"></script>
    <script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>js/jquery.slicknav.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

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

          function notifyMe(title,text,type){
              new PNotify({
                  title: title,
                  text: text,
                  type: type,
                  styling: 'bootstrap3'
              });
          }
		  
		     var $ = jQuery.noConflict();
			(function($) {
				"use strict";
				$('#left_menu').slicknav({
					label: 'Menu',
					prependTo: '.dashboard-nav'
				});

			})(jQuery); 
			 
        </script>
        <!-- /PNotify -->
  </body>
</html>
