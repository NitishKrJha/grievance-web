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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>css/line-awesome.min.css">
    <!-- theme css -->
    <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>css/theme.css">
    <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>css/responsive.css">
    <!-- <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>css/fullcalendar.css"> -->

    <link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>js/vendor/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>js/vendor/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>js/vendor/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">


    <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>css/font-awesome.min.css">

    <!-- theme css -->
    <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>css/jquery.scrollbar.css">
    <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>css/slicknav.min.css">

    <!-- <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>css/theme.css">
    <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>css/responsive.css"> -->

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
    <link href="<?php echo css_images_js_base_url(); ?>css/emoji.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>css/chat.css"> -->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="<?php echo css_images_js_base_url(); ?>js/ez.countimer.min.js"></script>
    <style>
      .callTimeCounter{
        color: #fff;
        text-align: center;
        font-size: 15px;
      }
      .callTimeCounter-black{
        color: #000;
        text-align: center;
        font-size: 15px;
      }
    </style>
<!--
  <div class="callTimeCounter"><i class="fa fa-clock-o" style="color: #fff;margin: 5px;"></i>10:15:45</div>

-->
    <script>
    $(document).ready(function() {
      //alert(1);
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
    $(function(){
      setInterval(function(){ checklogin(); }, 300000);
      getNotificationList();
      setInterval(function(){ getNotificationList(); }, 300000);
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
    function makeLogOfVideo(from_member='',to_member='',type='update',status=0){
      if(from_member!='' && to_member!=''){
        var url="<?php echo base_url('page/doLogOfVideoChat'); ?>"
        $.ajax({
          data : {'from_member':from_member,'to_member':to_member,'type':type,'status':status},
          dataType : 'json',
          type : 'post',
          url: url,
          success : function(msg){
            console.log("Added");
            if(status==1){
              setInterval(updateTimeLogOfVideo(from_member), 10000);
            }
          },
          error: function () {
            console.log('Unable to tracked');
          }
        });
      }
    }

    function endLogOfVideo(from_member=''){
      if(from_member!=''){
        var url="<?php echo base_url('page/doEndLogOfVideoChat'); ?>"
        $.ajax({
          data : {'from_member':from_member},
          dataType : 'json',
          type : 'post',
          url: url,
          success : function(msg){
            console.log("Added");
            location.reload();
          },
          error: function () {
            console.log('Unable to tracked');
            location.reload();
          }
        });
      }
    }

    function updateTimeLogOfVideo(from_member=''){
      if(from_member!=''){
        var url="<?php echo base_url('page/doUpdateTimeLogOfVideoChat'); ?>"
        $.ajax({
          data : {'from_member':from_member},
          dataType : 'json',
          type : 'post',
          url: url,
          success : function(msg){
            console.log("Added");
          },
          error: function () {
            console.log('Unable to tracked');
            location.reload();
          }
        });
      }
    }

    function getNotificationList(){
      var url="<?php echo base_url('page/showNotificationList'); ?>";
      $.ajax({
        data : {},
        dataType : 'json',
        type : 'post',
        url: url,
        success : function(msg){
          //console.log(msg);
          $('#chat-not-cnt').html(msg.total);
          if(msg.error==0){
            if(msg.total > 0){
              var data=msg.data;
              $.each(data,function(key,val){
                var html='';
                var url ='<?php echo base_url(); ?>'+val.site_url;  
                var html='<li id="notilisting'+val.id+'"><a href="JavaScript:void(0);" class="clcikNotification" data-url="'+url+'" data-id="'+val.id+'"> '+val.contents+'</a></li>';
                if($(".notilisting"+val.id).length <= 0){
                  $('#chat-notification-list').append(html);
                }
              })
            }else{
              $('#chat-notification-list').html('');
              $('#chat-notification-list').hide();
            }
          }
        },
        error: function () {
          $('#chat-not-cnt').html('0');
        }
      });
    }

    $(document).on('click','.clcikNotification',function(){
      var $this=$(this);
      var urls=$this.data('url');
      var id=$this.data('id');
      $.ajax({
        data : {'id':id},
        dataType : 'json',
        type : 'post',
        url: "<?php echo base_url(); ?>page/readNotification",
        success : function(msg){
           window.location.href=urls;
        },
        error: function () {
          window.location.href="<?php echo base_url(); ?>notification/index/0/1";
        }
      });
    });
    </script>
  </head>
  <?php $page = $this->uri->segment(2); ?>
  <body>

  <div class="dashboard-bg">
	<!--Header Section-->
	<?php echo isset($content_for_layout_header)?$content_for_layout_header:'';?>
	
	<!--Main Section-->
	<?php echo isset($content_for_layout_main)?$content_for_layout_main:'';?>
    </div>
	<?php echo isset($content_for_layout_chat)?$content_for_layout_chat:'';?>
	<!--Footer Section-->
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
