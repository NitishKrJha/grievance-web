<!DOCTYPE html>
<html lang="en">
  <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="title" content="<?php echo constant('GLOBAL_META_TITLE') ?>">
        <meta name="keywords" content="<?php echo constant('GLOBAL_META_KEYWORDS') ?>">
        <meta name="description" content="<?php echo constant('GLOBAL_META_DESCRIPTION') ?>">
        <link rel="icon" href="<?php echo base_url().'public/images/favicon.png'; ?>">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?php echo constant('GLOBAL_META_TITLE') ?></title>
        <link rel="icon" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/favicon.ico">
        <!-- all css here -->
        <!-- bootstrap v3.3.7 css -->
        <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>css/line-awesome.min.css">
        <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>css/owl.carousel.min.css">
        <!-- theme css -->
        <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>css/theme.css">
        <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>css/responsive.css">

        <link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>js/vendor/pnotify/dist/pnotify.css" rel="stylesheet">
        <link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>js/vendor/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
        <link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>js/vendor/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">
      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  </head>
  <?php $page = $this->uri->segment(2); ?>
  <body>
	<!--Header Section-->
	<?php echo isset($content_for_layout_header)?$content_for_layout_header:'';?>
	<!--Main Section-->
	<?php echo isset($content_for_layout_main)?$content_for_layout_main:'';?>
	<!--Footer Section-->
	<?php echo isset($content_for_layout_footer)?$content_for_layout_footer:'';?>
  <?php echo isset($content_for_layout_chat)?$content_for_layout_chat:'';?>
   <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>js/vendor/jquery-migrate-1.2.1.js"></script>
    <script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>js/vendor/bootstrap.min.js"></script>
    <script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>js/vendor/owl.carousel.min.js"></script>
	  <script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>js/vendor/main.js"></script>
	  <script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>js/vendor/pnotify/dist/pnotify.js"></script>
    <script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>js/vendor/pnotify/dist/pnotify.buttons.js"></script>
    <script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>js/vendor/pnotify/dist/pnotify.nonblock.js"></script>
    
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>
	$("input").on("keypress", function(e) {
	if (e.which === 32 && !this.value.length)
		e.preventDefault();
	});
	</script>
	<!-- PNotify -->
        <script>
          $(function(){
            setInterval(function(){ checklogin(); }, 100000);
          })
          function checklogin(){
            var url="<?php echo base_url('page/loginCheck/');?>";
            $.ajax({
              type:'POST',
              url: url,
              data:{},
              success:function(msg){ //alert(11);
                if(msg=='false'){
                  window.location.href="<?php echo base_url('logout'); ?>";
                }
              },
              error: function () {
              }
            });
          }
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