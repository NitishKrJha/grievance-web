<!DOCTYPE HTML>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=yes">

    <title><?php echo constant("GLOBAL_SITE_NAME");?></title>
    <link rel="icon" href="<?php echo front_base_url()."public/";?>assets/images/fav.ico">

    <!-- Bootstrap -->
    <link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	
    <link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
     <link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendors/build/css/custom.min.css" rel="stylesheet">

    <!-- jQuery -->
   
	
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>

    <script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>js/adminEssential.js"></script>
	
	<!--<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
    <link media="screen" type="text/css" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>jquery/css/validationEngine.jquery.css" rel="stylesheet" />
    <script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>jquery/js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo CSS_IMAGES_JS_BASE_URL;?>jquery/js/jquery.validationEngine.js"></script>
	
	<!--<script src="<?php echo front_base_url();?>public/assets/plugins/tinymce/js/tinymce/tinymce.min.js"></script>-->
	<script src="<?php echo front_base_url();?>public/assets/plugins/tinymce/tinymce.min.js"></script>
	<script src="<?php echo CSS_IMAGES_JS_BASE_URL();?>js/tinymc.js"></script>
	
    <script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>js/bhajslib.js"></script>
	
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <?php echo $content_for_layout_menu;?>
        <!-- top navigation -->
        <div class="top_nav">
          <?php echo $content_for_layout_topmenu;?>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <?php echo $content_for_layout_main;?>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            <?php echo date('Y');?> © <? echo constant("GLOBAL_SITE_NAME");?>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
        <!-- FastClick -->
       
        <!-- bootstrap-daterangepicker -->
        <script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendors/moment/min/moment.min.js"></script>
        <script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
        <script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendors/iCheck/icheck.min.js"></script>
        <script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendors/pnotify/dist/pnotify.js"></script>
        <script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendors/pnotify/dist/pnotify.buttons.js"></script>
        <script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendors/pnotify/dist/pnotify.nonblock.js"></script>

        <!-- Custom Theme Scripts -->
        <script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendors/build/js/custom.min.js"></script>

        <!-- bootstrap-daterangepicker -->
        <script>
          $(document).ready(function() {

            var cb = function(start, end, label) {
              console.log(start.toISOString(), end.toISOString(), label);
              $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            };

            var optionSet1 = {
              startDate: moment().subtract(29, 'days'),
              endDate: moment(),
              minDate: '01/01/2012',
              maxDate: '12/31/2015',
              dateLimit: {
                days: 60
              },
              showDropdowns: true,
              showWeekNumbers: true,
              timePicker: false,
              timePickerIncrement: 1,
              timePicker12Hour: true,
              ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
              },
              opens: 'left',
              buttonClasses: ['btn btn-default'],
              applyClass: 'btn-small btn-primary',
              cancelClass: 'btn-small',
              format: 'MM/DD/YYYY',
              separator: ' to ',
              locale: {
                applyLabel: 'Submit',
                cancelLabel: 'Clear',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
              }
            };
            $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
            $('#reportrange').daterangepicker(optionSet1, cb);
            $('#reportrange').on('show.daterangepicker', function() {
              console.log("show event fired");
            });
            $('#reportrange').on('hide.daterangepicker', function() {
              console.log("hide event fired");
            });
            $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
              console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
            });
            $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
              console.log("cancel event fired");
            });
            $('#options1').click(function() {
              $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
            });
            $('#options2').click(function() {
              $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
            });
            $('#destroy').click(function() {
              $('#reportrange').data('daterangepicker').remove();
            });
          });
        </script>
        <!-- /bootstrap-daterangepicker -->
        <!-- PNotify -->
        <script>
          $(document).ready(function() {
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
      </div>
    </div>
  </body>
</html>
