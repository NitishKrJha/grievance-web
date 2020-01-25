<?php //pr($memberMoreData); ?>
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
               <div class="row message-left">
                    <div class="col-md-4 col-sm-4 border-rht">
                    <div id="message-search-input">
                    <div class="input-group col-md-12">
                    <span class="input-group-btn">
                            <button class="btn btn-danger" type="button">
                                <span class=" glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                        <input type="text" id="searchName" onkeyup="messageFilterByname()" placeholder="Search for names.." class="search-query form-control" placeholder="Search ">
                        
                    </div>
                </div>               
                    <ul class="navMsg">
                        <li class="limshstatus active" data-type="all"><a href="javascript:void(0);">All</a></li>
                        <li class="limshstatus" data-type="0"><a href="javascript:void(0);">Unread </a></li>
                        <li class="limshstatus" data-type="1"><a href="javascript:void(0);">Read</a></li>
                    </ul>
                    <div class="contactSec">
                    <ul id="myUL">
					   <?php
					   if(count($memberAllMessages)>0){
						   foreach($memberAllMessages as $mAmessahe){
                           ?>
                            <li class="allmsgdt msg_<?php echo $mAmessahe['status']; ?>" data-id="<?php echo $mAmessahe['id']; ?>" data-baseid="<?php echo base_url('member/profile/'.base64_encode($mAmessahe['id'])); ?>"><a href="javascript:void(0);">
                                <span class="userIcn img-circle"><img src="<?php echo $mAmessahe['crop_profile_image']?$mAmessahe['crop_profile_image']:'http://via.placeholder.com/200x200'; ?>" alt=""> </span>
                                <span class="textSec"><h3 id="fromname"><?php echo $mAmessahe['name']?$mAmessahe['name']:'Unknown'; ?></h3> <p><?php echo $mAmessahe['message']?substr($mAmessahe['message'], 0, 5).'...':''; ?></p></span>
                                <span class="count" style="display: none;"><?php echo $mAmessahe['unreadMessage']?$mAmessahe['unreadMessage']:'0'; ?></span>
                                <span class="time"><small><?php echo time_elapsed_string($mAmessahe['created_date'],true); ?></small></span>
                            </a></li>
                            <?php
    					     }
					    }
					   ?>
                       
                        
                    </ul>
                    
                   
                
                </div>
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <div class="msgBox">
                            <?php if(count($memberAllMessages) > 0){
                                ?>
                                <span class="msgImg"><img src="images/msg-1.jpg" alt=""></span>
                                    <span class="msgNm">
                                    
                                    </span>
                                    
                                    
                                    <div id="appendText"></div>
                                    <form class="form-horizontal" role="form" name="messageFormMain" id="messageFormMain" method="post" action="">
                                        <input type="hidden" id="to_member_id" name="to_member" value="0">
                                        <div class="form-group">
                                            <div class="col-md-9 col-sm-9">
                                                <textarea name="message" id="messageMain" class="form-control"></textarea>
                                            
                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <!-- <a class="showTipsBtn" href="javascript:void(0)" id="openMessageForm">Reply</a>  -->
                                                <button type="submit" name="submit" class="showTipsBtn">Send</button>   
                                            </div>
                                        </div>
                                        
                                    </form>
                                <?php
                            }else{
                                ?>
                                No Message Found..
                                <?php
                            } ?>
                            
                            
                            
                        </div>
                    </div>
               </div>
            </div>
            <?php echo $this->load->view('layout/memberMyContact'); ?>
            <?php echo $this->load->view('layout/memberChatRequest'); ?>
        </div>
    </div>
</section>
<div id="chatAppend"></div>
<!-- Modal -->



<script type="text/javascript" charset="utf-8">
	function messageFilterByname() {
		var input, filter, ul, li, a, i;
		input = document.getElementById("searchName");
		filter = input.value.toUpperCase();
		ul = document.getElementById("myUL");
		li = ul.getElementsByTagName("li");
		for (i = 0; i < li.length; i++) {
			a = li[i].getElementsByTagName("a")[0];
			if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
				li[i].style.display = "";
			} else {
				li[i].style.display = "none";
			}
		}
	}
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
        $('#message').val('');
        window.location.reload();
      },
      error: function () {
        messagealert('Error','Technical issue , Please try later','error');
      }
    });
}

$(document).on('click','.limshstatus',function(){
    $('.limshstatus').removeClass('active');
    var $this=$(this);
    $this.addClass('active');
    var type=$this.data('type');
    if(type=="all"){
        $('.allmsgdt').show();
    }else if(type=="1"){
        $('.msg_0').hide();
        $('.msg_1').show();
    }else{
        $('.msg_1').hide();
        $('.msg_0').show();
    }
});

$(document).on('click','.allmsgdt',function(){
    $('.allmsgdt').removeClass('active');
    var $this=$(this);
    $this.addClass('active');
    var src=$this.find('img').first().attr('src');
    var name=$this.find('#fromname').text();
    var from_name="<?php echo $this->nsession->userdata('member_session_name'); ?>";
    var from_id="<?php echo $this->nsession->userdata('member_session_id'); ?>";
    var to_member_id=$this.data('id');
    var baseid=$this.data('baseid');
    $('#to_member_id').val(to_member_id);
    var url="<?php echo base_url(); ?>page/getMessageData";
    $('.msgNm').html('Message With <strong><a target="_blank" href="'+baseid+'">'+name+'</a></strong>');
    $('.msgImg').find('img').attr('src',src);
    $.ajax({
        type:'POST',
        url: url,
        data:{'to_member_id':to_member_id},
        success:function(msg){
            var response=$.parseJSON(msg);
            $('#appendText').html('');
            if(response.error==0){
                $(this).removeClass('msg_0');
                $(this).removeClass('msg_1');
                $(this).addClass('msg_1');
                changeMessageCount();
                $.each((response.data),function(key,val){
                    if(val.member_id==from_id){
                        var nname=from_name;
                        var lmsg="outgoing_msg";
                        var lcalass="left_bubble";
                    }else{
                        var nname=name;
                        var lmsg="incoming_msg";
                        var lcalass="right_bubble";
                    }
                    var html='';
                    var msg=val.message;
                    msg=msg.replace(',','');
                    html +='<p class="'+lmsg+'"><span class="'+lcalass+'">'+msg+'</span></p><div class="clearfix"></div>';
                    $('#appendText').append(html);
                });
                $('#appendText').animate({
                    scrollTop: $('#appendText')[0].scrollHeight}, 2000);
            }else{
                messagealert('Error','You does not have permission to access this page','error');
            }
        }
    });
})

$(function(){
    $("#messageFormMain").validate({
        rules: {
            subject: {
                required: true
            },
            message:{
                required: true
            }
        },
        submitHandler: function(form) {
          var data=$("form[name='messageFormMain']").serialize();
          do_send_message_main(data);
        }
      });

    $('#myUL').find('li').first().trigger('click');
})

// $(document).on('click','#openMessageForm',function(){
//     var to_member=$('#to_member_id').val();
//     $('#to_member').val(to_member);
//     $('#myContactForm').modal('show');
// });

function do_send_message_main(formData){
    var url="<?php echo base_url('page/sendMessage/');?>";
    $.ajax({
      type:'POST',
      url: url,
      data:formData,
      success:function(msg){ //alert(11);
        $('#myContactForm').modal('hide');
        //messagealert('Success','Message Send Successfully','success');
        var html='';
        var msg=$('#messageMain').val();
        
        var lmsg="outgoing_msg";
        var lcalass="left_bubble";
        var html='';
        msg=msg.replace(',','');
        html +='<p class="'+lmsg+'"><span class="'+lcalass+'">'+msg+'</span></p><div class="clearfix"></div>';
        $('textarea[name="message"]').val('');
        $('#appendText').append(html);
        $('#appendText').animate({
                    scrollTop: $('#appendText')[0].scrollHeight}, 2000);
      },
      error: function () {
        messagealert('Error','Technical issue , Please try later','error');
      }
    });
}
</script>

<div class="modal fade" id="myContactForm" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" 
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Send Message
                </h4>
            </div>
            <form class="form-horizontal" role="form" name="messageForm" id="messageForm" method="post" action="">
            <!-- Modal Body -->
            <div class="modal-body">
                
                
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label"
                              for="inputPassword3" >Message</label>
                        <div class="col-sm-10">
                            <textarea name="message" id="message" class="form-control"></textarea>
                        </div>
                      </div>
                      <input type="hidden" name="to_member" id="to_member" value="">
                
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">
                            Close
                </button>
                <button type="submit" id="submit" class="btn btn-primary">
                    Send
                </button>
            </div>

            </form>

        </div>
    </div>
</div>