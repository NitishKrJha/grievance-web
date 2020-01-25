<link href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>css/loader.css" rel="stylesheet">
<div class="loading" id="load-txt" style="display: none;">Loading&#8230;</div>
<style>
  .deleteVideo{
    z-index: 999999999999!important;
  }
</style>
<section class="main-container">
    <div class="container-fluid">
      <div class="row">
        <?php $this->load->view('layout/member_left_menu')?>
      
        <div class="col-md-10">
            <div class="dashboardSec">
              <div class="row">
                <div class="col-xl-12 col-md-12 ">
                  <form action="<?php echo base_url('member/do_upload_photo') ?>" method="post" id="picForm" enctype="multipart/form-data">
                    <div class="form-group choseyourfile">
                      <label for="Choseyourfile"><i class="fa fa-paperclip" aria-hidden="true"></i> Choose your Image File</label>
                      <input type="file" class="form-control-file" name="files[]" id="choseyourfile" accept="image/*">
                      <ul class="file-path-wrapper" id="photo-data">
                        <?php 
                          if(count($allimg) > 0){
                            foreach ($allimg as $key => $value) {
                              ?>
                              <li> <a href="javascript:void(0)"><i class="fa fa-times deletePhoto" aria-hidden="true" data-id="<?php echo $value['id']; ?>"></i></a> <img src="<?php echo $value['photo']; ?>" alt=""> </li>
                              <?php
                            }
                          }
                        ?>
                      </ul>
                    </div>
                  </form>
                </div>
              </div>

              <div class="row">
                <div class="col-xl-12 col-md-12 ">
                  <form action="<?php echo base_url('member/do_upload_video') ?>" method="post" id="videoForm" enctype="multipart/form-data">
                    <div class="form-group choseyourfile">
                      <label for="Choseyourfile"><i class="fa fa-paperclip" aria-hidden="true"></i> Choose your Video File</label>
                      <input type="file" class="form-control-file" name="videos[]" id="choseyourvideofile" size="5MB" accept="video/*">
                      <ul class="file-path-wrapper" id="video-data">
                        <?php 
                          if(count($allvid) > 0){
                            foreach ($allvid as $key => $value) {
                              ?>
                              <li> <a href="javascript:void(0)"><i class="fa fa-times deleteVideo" aria-hidden="true" data-id="<?php echo $value['id']; ?>"></i></a>
                                <video width="150" height="150" controls="">
                                      <source src="<?php echo $value['video']; ?>" type="video/mp4">
                                </video>
                               </li>
                              <?php
                            }
                          }
                        ?>
                      </ul>
                    </div>
                  </form>
                </div>
              </div>

            </div>
          </div>  
      </div>
    </div>
  </section>


<script>
 $(document).on('click','.deactiveaccount',function(){
	
	//alert(1);
	 
	var $this=$(this);
	var id=$this.data('idto');
	//alert(id);
	if(id==''){
		return false;
	}
	var url='<?php echo base_url(); ?>member/do_deactiveaccount/'+id;
	
	if(window.confirm("Are you sure to Deactive your account ?"))
	{
		  //window.location.href = url;
		  window.location.href = url;
		 //window.location.reload();
		 //alert(1);
	} 
});

$(document).on('click','.deletePhoto',function(){
  var $this=$(this);
  var id=$this.data('id');
  var result = confirm("Are you sure want to delete?");
  if (result) {
      $('#load-txt').show();
      $.ajax({
        type:'POST',
        url:"<?php echo base_url(); ?>"+'member/delphoto/',
        data:{'id':id,'type':'photo'},
        success:function(msg){
          var response=$.parseJSON(msg);
          $('#load-txt').hide();
          if(response.status==1){
            $this.parent().parent().remove();
            messagealert('Success',response.msg,'success');
          }else{
            messagealert('Error',response.msg,'error');
          }
        },
        error: function () {
          $('#load-txt').hide();
          messagealert('Error','Invalid Request','error');
        }
      });
  }
});

$(document).on('click','.deleteVideo',function(){
  var $this=$(this);
  var id=$this.data('id');
  var result = confirm("Are you sure want to delete?");
  if (result) {
      $('#load-txt').show();
      $.ajax({
        type:'POST',
        url:"<?php echo base_url(); ?>"+'member/delphoto/',
        data:{'id':id,'type':'video'},
        success:function(msg){
          var response=$.parseJSON(msg);
          $('#load-txt').hide();
          if(response.status==1){
            $this.parent().parent().remove();
            messagealert('Success',response.msg,'success');
          }else{
            messagealert('Error',response.msg,'error');
          }
        },
        error: function () {
          $('#load-txt').hide();
          messagealert('Error','Invalid Request','error');
        }
      });
  }
});

$('#fileupload').change(function(){
	
  
   var input = document.getElementById('fileupload');
   if(input.files.length>10){
	   
       $('.validation').css('display','block');
	   $('.submit_button').css('display','none');
   }else{
       $('.validation').css('display','none');
       
   }
});

$(document).ready(function () {
    $('#choseyourfile').change(function () {
        $('#load-txt').show();
        $('#picForm').submit();
    });
    $('#choseyourvideofile').change(function () {
        var size=this.files[0].size;
        if(size > 4979786){
          messagealert("Error","File size should not be greater than 5mb",'error');
        }else{
          $('#load-txt').show();
          $('#videoForm').submit();
        }
        //$('#load-txt').show();
        //$('#videoForm').submit();
    });
});

function messagealert(title,text,type){
      new PNotify({
            title: title,
            text:  text,
            type:  type,
            styling: 'bootstrap3'
          });
  }

</script>