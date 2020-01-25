<?php
//pr($data);
?>
<link href="<?php echo front_base_url(); ?>public/css/loader.css" rel="stylesheet">
<div class="loading" id="load-txt" style="display: none;">Loading&#8230;</div>

<link rel="stylesheet" href="<?php echo front_base_url();?>public/css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<script src="<?php echo front_base_url();?>public/js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
<style type="text/css">
	.photo-detail-list{
		list-style: none;
		padding: 0;
	}
	.photo-detail-list li {
	    float: left;
	    padding: 4px;
	    border: 1px solid #d8d8d8;
	    margin: 5px;
	    border-radius: 3px;
	    background: #f7f7f7;
	    position: relative;
	}
	.cross {
	    position: absolute;
	    right: -5px;
	    top: -5px;
	    width: 20px;
	    height: 20px;
	    background: red;
	    color: #fff;
	    text-align: center;
	    cursor: pointer;
	    z-index: 2;
	}
</style>

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content">
	  	<span class="section">Profile Picture</span>
		<div class="form-group">
			<?php
			$picture=isset($picture)?$picture:'';
			if($picture==''){ ?>
				<img src="https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg" alt="" class="img-responsive" style="width:100px;height:100px">
			<?php }else{
				?>
				<ul class="photo-detail-list gallery">
					<li>
						<div class="cross emptyProfilePic">
		                	<i class="fa fa-times"></i>
		                </div>
						<a href="<?php echo $picture; ?>" rel="prettyPhoto[mixed]" title="image">
						<img src="<?php echo $picture; ?>" alt="" class="img-responsive" style="width:100px;height:100px"/>
						</a>
					</li>
				</ul>
				<?php
			} ?>
		</div>
		
		<div class="clearfix"></div><br/>
	  </div>
    </div>
  </div>

  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content">
	  	<span class="section">Photo Details</span>
		
		
		<div class="form-group">
			<ul class="photo-detail-list gallery">
                <?php                                
					if(!empty($photo)){
						foreach ($photo as $photos){
							if($photos['photo']==''){ continue; }
                            ?>
                                <li>
                                	<div class="cross deletePhoto" data-id="<?php echo $photos['id']; ?>">
                                    	<i class="fa fa-times"></i>
                                    </div>
                                	<a href="<?php echo $photos['photo']; ?>" rel="prettyPhoto[mixed]" title="image">
                                    <img src="<?php echo $photos['photo']; ?>" alt="" class="img-responsive" style="width:100px;height:100px"/>
                                    
                                    </a>
                                </li>
                            <?php 
                        }
                    }else{
                        echo 'No Data Available';
                    } ?>
                </ul>
		</div>
		
		
	  </div>
    </div>
  </div>

  

  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content">
	  	<span class="section">Video List</span>
		
		<div class="form-group">
			<ul class="photo-detail-list">
            <?php 
              if(isset($video) && count($video) > 0){
                foreach ($video as $key => $value) {
                  ?>
                  <li> 
                  	<div class="cross deleteVideo" data-id="<?php echo $value['id']; ?>">
                    	<i class="fa fa-times"></i>
                    </div>
                    <video width="150" height="150" controls="">
                          <source src="<?php echo $value['video']; ?>" type="video/mp4">
                    </video>
                     
                   </li>
                  <?php
                }
              }else{
              	 echo 'No Data Available';
              }
            ?>
          </ul>
		</div>
		
		
	  </div>
    </div>
  </div>

</div>
<script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>js/jquery.validate.min.js"></script>
<script>
	$(document).ready(function(){
	    $("area[rel^='prettyPhoto']").prettyPhoto();
	    
	    $(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:3000, autoplay_slideshow: false});
	    $(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true});
	});

	$(document).on('click','.deletePhoto',function(){
	  var $this=$(this);
	  var id=$this.data('id');
	  var result = confirm("Are you sure want to delete?");
	  if (result) {
	  	  $('#hid_id').val(id);
		  $('#del_type').val('photo');
	      $('#modalContactForm').modal('show');
	  }
	});

	$(document).on('click','.deleteVideo',function(){
	  var $this=$(this);
	  var id=$this.data('id');
	  var result = confirm("Are you sure want to delete?");
	  if (result) {
	  	  $('#hid_id').val(id);
		  $('#del_type').val('video');
	  	  $('#modalContactForm').modal('show');
	  }
	});

	function delData(id,type){
		$('#load-txt').show();
		var member_id="<?php echo $member_id; ?>";
	    $.ajax({
	        type:'POST',
	        url:"<?php echo base_url(); ?>"+'member/delphoto/',
	        data:{'member_id':member_id,'id':id,'type':type,'subject':$('#subject').val(),'message':$('#message').val()},
	        success:function(msg){
	          var response=$.parseJSON(msg);
	          $('#load-txt').hide();
	          window.location.reload();
	        },
	        error: function () {
	          $('#load-txt').hide();
	          messagealert('Error','Invalid Request','error');
	        }
	    });
	}

	$(document).on('click','.emptyProfilePic',function(){
		var $this=$(this);
		  var id="<?php echo $member_id; ?>";
		  var result = confirm("Are you sure want to delete?");
		  if (result) {
		  	$('#hid_id').val(id);
		  	$('#del_type').val('profile');
		  	$('#modalContactForm').modal('show');
		  }
	});

	function delProfilePic(id){
		var member_id="<?php echo $member_id; ?>";
		$('#load-txt').show();
	    $.ajax({
	        type:'POST',
	        url:"<?php echo base_url(); ?>"+'member/emptymyphoto/',
	        data:{'member_id':member_id,'id':id,'subject':$('#subject').val(),'message':$('#message').val()},
	        success:function(msg){
	          var response=$.parseJSON(msg);
	          $('#load-txt').hide();
	          window.location.reload();
	        },
	        error: function () {
	          $('#load-txt').hide();
	          messagealert('Error','Invalid Request','error');
	        }
	      });
	}

	$(function(){
	    $("#sendForm").validate({
	    
	      // Specify validation rules
	      rules: {
	        subject:{
	          required: true
	        },
	        message: {
	          required: true
	        }
	      },
	      messages: {
	      },
	      submitHandler: function(form) {
	    	var del_type=$('#del_type').val();
	        var id=$('#hid_id').val();
	        if(del_type=='profile'){
	        	delProfilePic(id);
	        }else{
	        	delData(id,del_type);
	        }
	      }
	    });
	  })

	

</script>



<div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form name="sendForm" id="sendForm" action="<?php echo base_url('booking/givepermission'); ?>" method="post">
              <div class="modal-header text-center">
                  <h4 class="modal-title w-100 font-weight-bold">Send Message</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body mx-3">

                  <div class="md-form mb-5">
                      <label data-error="wrong" data-success="right" for="form32">Subject</label>
                      <input type="text" id="subject" name="subject" class="form-control validate">
                      
                  </div>
                  <input type="hidden" name="hid_id" id="hid_id" value="0">
                  <input type="hidden" name="del_type" id="del_type" value="video">
                  <div class="md-form">
                      <label data-error="wrong" data-success="right" for="form8">Your message</label>
                      <textarea type="text" id="message" name="message" class="md-textarea form-control" rows="4"></textarea>
                      
                  </div>

              </div>
              <div class="modal-footer d-flex justify-content-center">
                  <button class="btn btn-unique" type="submit" id="submit" name="submit" value="submit">Send <i class="fa fa-paper-plane-o ml-1"></i></button>
              </div>
            </form>
        </div>
    </div>
</div>