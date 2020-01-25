<style>
    #profileImageChangeModal .modal-dialog {
      width: 100%;
      height: 100%;
      margin: 0;
      padding: 0;
    }

    #profileImageChangeModal .modal-content {
      height: auto;
      min-height: 100%;
      border-radius: 0;
    }
</style>
<?php //pr($memberMoreData);

 ?>
<link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
<section class="main-container">
    <div class="container-fluid">
        <div class="row">
            <?php
            if($this->nsession->userdata('member_session_membertype')==1){
             $this->load->view('layout/member_left_menu');
            }else{
             $this->load->view('layout/counselorLeftMenu');
            }?>
            <div class="col-md-7">
                <?php $this->load->view('layout/member_view')?>
                <div class="btm-section">
                    <div class="row">
                        <div class="col-md-9">
                            <h3 class="des-title"> About Me</h3>
                            <p><?php echo $memberData['about_me'];?></p><br>
                            <h3 class="des-title"> Details </h3>
                            <div class="table-borderless">
                                <table class="table w-100 ">
                                    <tbody>
                                        <tr>
                                            <td><strong>Looking For </strong>
                                                <?php
                                                    switch ($memberData['interested_in']){
                                                        case 1:
                                                            echo "Male";
                                                            break;
                                                        case 2:
                                                            echo "Female";
                                                            break;
                                                        case 3:
                                                            echo "Both";
                                                            break;
                                                    }
                                                ?>
                                            </td>
                                            <td><strong>Income</strong> $ <?php echo isset($memberMoreData['income'])?$memberMoreData['income']:''; ?> </td>
                                            <td><strong>Hair Type</strong> <?php echo isset($memberMoreData['hairType'])?$memberMoreData['hairType']:''; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Ethnicity </strong> <?php echo isset($memberMoreData['ethnicityType'])?$memberMoreData['ethnicityType']:''; ?> </td>
                                            <td><strong>Children </strong> <?php echo isset($memberMoreData['have_kids'])?$memberMoreData['have_kids']:''; ?> </td>
                                            <td><strong>Language</strong> <?php echo isset($memberMoreData['languageType'])?$memberMoreData['languageType']:''; ?> </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Education</strong><?php echo isset($memberMoreData['educationType'])?$memberMoreData['educationType']:''; ?></td>
                                            <td><strong>Smokes</strong> <?php
                                                switch (isset($memberMoreData['smoking'])?$memberMoreData['smoking']:''){
                                                    case 1:
                                                        echo "Non Smoker";
                                                        break;
                                                    case 2:
                                                        echo "Light Smoker";
                                                        break;
                                                    case 3:
                                                        echo "High Smoker";
                                                        break;
                                                }
                                                ?></td>
                                            <td><strong>Body Type</strong> <?php echo isset($memberMoreData['bodyType'])?$memberMoreData['bodyType']:''; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
							<div class="col-md-12 chkBx" >
                       		
							<h3 class="des-title"> My Interest </h3>
						      <span class="checkboxSec" >
                                <ul class="unstyled ">
                                <?php                                
									if(!empty($memberInterest)){
										foreach ($memberInterest as $interestDetails){
                                        ?>
                                            <li>
                                                <strong> <?php echo $interestDetails['name']; ?></strong>
                                            </li>
                                        <?php 
                                        }
                                    }else{
                                        echo 'You have not added any interest';
                                    } ?>
                                </ul>
                                </span>
                            </div>
                        </div>
						
					    <div class="col-md-3">
                            <?php 
                            if(count($memberPhoto) > 0){
                                ?>
                                <div class="col-md-12"> <span class="brd"></span>
                                    <h3 class="des-title"> My Photo </h3>
                                    <div class="row certificates">
                                        <ul class="gallery clearfix">
                                            <?php
                                            foreach($memberPhoto as $photoDetails){
                                                ?>
                                                <div class="col-md-6 col-xs-6 col-sm-3"><a href="<?php echo $photoDetails['photo']; ?>" rel="prettyPhoto[mixed]" title="image"><img class="img-responsive" src="<?php echo $photoDetails['photo']; ?>" alt=""></a></div>
                                                <?php
                                            }
                                            ?>
                                            
                                        </ul>
                                    </div>
                                </div> 
                                <?php
                                 
                            } ?>

                             	
                            <?php if(count($membervideo) > 0){ ?>
                                <div class="col-md-12" id="my_video"> <span class="brd"></span>
                                    <h3 class="des-title"> My Video </h3>
            				        <div class="row certificates" >
                						
                						<?php foreach($membervideo as $videoDetails){?>
                        				<div class="col-md-12 col-xs-12 col-sm-12 ">
                        				
                            				<video width="110"  class="video_div" onclick="show_modal_video(this)">
                            				  <source src="<?php echo $videoDetails['video'];?>" type="video/mp4">
                            				 
                            				
                            				</video>
                        				
                        				</div>
                						<?php } ?>	 	  
                                    </div>
            				    </div>	
                            <?php } ?>	
                            <?php
                                if($this->nsession->userdata('member_session_id') && $memberId!=$this->nsession->userdata('member_session_id')){
                                    ?>
                                    <div class="col-md-12" id="my_video">
                                        <a href="javascript:void(0);" class="btn btn-cmn makeFlag">Flag</a>
                                    </div>
                                    <?php
                                }
                            ?>
                            			
                        </div>
				
                    </div>
			  
			    </div>
            </div>
            <?php echo $this->load->view('layout/memberMyContact'); ?>
            <?php echo $this->load->view('layout/memberChatRequest'); ?>
        </div>
    </div>
</section>
<!-- <div id="chatAppend"></div> -->
<!-- Modal -->

<div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form name="flagForm" id="flagForm" action="<?php echo base_url('page/setFlag'); ?>" method="post">
              <div class="modal-header text-center">
                  <h4 class="modal-title w-100 font-weight-bold">Send Message</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <center><h4 class="modal-title w-100 font-weight-bold">User Message</h4></center>
              <div class="modal-body mx-3">

                  <input type="hidden" name="user_id" id="user_id" value="<?php echo $memberId; ?>">
                  <div class="md-form">
                      <label data-error="wrong" data-success="right" for="form8">Your message</label>
                      <textarea type="text" id="messaged" name="message" class="md-textarea form-control" rows="4"></textarea>
                      
                  </div>

              </div>
              
              <div class="modal-footer d-flex justify-content-center">
                  <button class="btn btn-unique" type="submit" id="submit" name="submit" value="submit">Send <i class="fa fa-paper-plane-o ml-1"></i></button>
              </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" charset="utf-8">
$(document).ready(function(){
    $("area[rel^='prettyPhoto']").prettyPhoto();
    
    $(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:3000, autoplay_slideshow: false});
    $(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true});

    
});

$(document).on('click','#openMessageForm',function(){
    var to_member="<?php echo $memberData['id']; ?>";
    $('#to_member').val(to_member);
    $('#myContactForm').modal('show');
});

$(function(){
    $("#messageForm").validate({
        rules: {
            message:{
                required: true
            }
        },
        submitHandler: function(form) {
          var data=$("form[name='messageForm']").serialize();
          do_send_message(data);
        }
      });
})


function do_send_message(formData){
    var url="<?php echo base_url('page/sendMessage/');?>";
    $.ajax({
      type:'POST',
      url: url,
      data:formData,
      success:function(msg){ //alert(11);
        window.location.reload();
      },
      error: function () {
        messagealert('Error','Technical issue , Please try later','error');
      }
    });
}

$(document).on('click','.makeFlag',function(){
    $('#messaged').val('');
    $('#modalContactForm').modal('show');

});




  $(function(){
    $("#flagForm").validate({
    
      // Specify validation rules
      rules: {
        message: {
          required: true
        }
      },
      messages: {
      },
      submitHandler: function(form) {
    
        var data=$("form[name='flagForm']").serialize();
        do_flag_submit(data);
      }
    });
  })

  function do_flag_submit(formData){
    $.ajax({
          type:'POST',
          url:$( '#flagForm' ).attr('action'),
          data:formData,
          dataType:'json',
          beforeSend:function(){
            //$('#makeLogin').button('loading');
          },
          success:function(msg){ //alert(11);
            if(msg.status==1){
                messagealert('success',msg.msg,'success');
            }else{
                messagealert('Error',msg.msg,'error');    
            }
            
            $('#messaged').val('');
            $('#modalContactForm').modal('hide');
          },
          error: function () {
            messagealert('Error','Technical issue , Please try later','error');
          }
        });
  }
</script>