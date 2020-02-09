<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo constant("GLOBAL_SITE_NAME");?></title>
    <link rel="icon" href="<?php echo front_base_url()."public/";?>assets/images/fav.ico">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
	<!---Angular-->
	<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <!-- Bootstrap -->
    <link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendors/build/css/custom.min.css" rel="stylesheet">

  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
           <?php echo $content_for_layout;?>
          </section>
        </div>

        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <?php echo $content_for_layout;?>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
