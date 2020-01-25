<style>
	.blurry-text {
	   color: transparent;
	   text-shadow: 0 0 20px rgba(0,0,0,0.5);
	}
</style>
<?php $this->load->helper('text');?>
<?php 
	$vv=$this->functions->checkPaidOrNot($this->nsession->userdata('member_session_id'));
?>
        <section class="main-container">
            <div class="container-fluid">
                <div class="row">
                   <?php $this->load->view('layout/member_left_menu')?>
                    <div class="col-md-10">
                       <div class="userTips">
                       		<h2 class="title-header">Useful Tips</h2>
                            <div class="show-tips">
                            	<div class="row">
								<form action="<?php echo base_url('tips')?>" method="post">
								    <div class="form-group">
										<div class="col-md-4 col-sm-4">
										  <select class="validate[required] form-control" id="category_id" name="category_id">
												  
												<option value=""> Select Category</option>
												<?php
												if($tipscategory){	
												foreach($tipscategory as $category){?>					   
												<option value="<?php echo $category['id'];?>" <?php if($params['category_id'] == $category['id']) echo 'selected';?>><?php echo $category['title']; ?></option>
											
												<?php }} ?>
										   </select>
										</div>										
                                    </div>  
									
                                    <div class="col-md-4 col-sm-4">                                    
                                        <div class="form-group">                                          
										   <select class="validate[required] form-control" id="sub_category_id" name="sub_category_id">
												<option value=""> Select sub category </option>
   									       </select>
                                        </div>
                              	
                                    </div>
									
                                    <div class="col-md-3 col-sm-3">
                                    	<button type="submit" class="showTipsBtn"> Show Tips </button>
                                    </div>
									
									
								</form>	
									
                                </div>                              
                            </div>
                            
                           <div class="UsefulList">
                           		<ul class="list-blog">
                                	
									<?php if(!empty($recordset)){
											foreach($recordset as $tipdetails){
											//pr($tipdetails);
											$blurry_text='';
											if($tipdetails['paid_or_free'] == 1){
												if($vv==0){
													$blurry_text="blurry-text";
												}
											}	
									?>
									<li>
                                    	<div class="row"> 
                                        	<div class="col-xs-12 col-sm-3 col-md-3">
                                            <figure>
                                              <img src="<?php echo base_url()?>uploads/tips_image/<?php echo isset($tipdetails['icon'])?$tipdetails['icon']:''; ?>" alt="" width="219">
											  
											  <?php if($tipdetails['paid_or_free'] == 1){?>
											  
												<figcaption class="free"> Paid </figcaption>
											  
											  <?php } ?>
											  
											  <?php if($tipdetails['paid_or_free'] == 2){?>
											  
												<figcaption class="free"> Free </figcaption>
											  
											  <?php } ?>
											  
                                            </figure>
                                            	
                                            </div>
                                            
                                            <div class="col-xs-12 col-sm-9 col-md-9">
                                            	<div class="tipsTextSec">
												
												<?php $tips_id = base64_encode($tipdetails['id']);
													$tipsId = rtrim($tips_id, '=');
												?>
                                                	<h3>
													
													  <?php if($tipdetails['paid_or_free'] == 1){?>
													
													<a href="<?php echo base_url('tips/viewdetails/'.$tipsId);?>"> <?php echo $tipdetails['title']; ?> </a>

													  <?php } ?>

													  <?php if($tipdetails['paid_or_free'] == 2){?>
													
														<a href="<?php echo base_url('tips/freeviewdetails/'.$tipsId);?>"> <?php echo $tipdetails['title']; ?> </a>

													  <?php } ?> 
													  
													  
													</h3>
                                                    <ul>
                                                    	<li><i class="fa fa-user" aria-hidden="true"></i> Posted by <span>Admin</span></li>
                                                        <li><i class="fa fa-tags" aria-hidden="true"></i> Category <span><?php echo isset($tipdetails['cat_name'])?$tipdetails['cat_name']:''; ?></span></li>
                                                    </ul>
                                                    <div class="<?php echo $blurry_text; ?>">
                                                    <p><?php 
													echo htmlspecialchars_decode(character_limiter($tipdetails['content']),20);?></p>
													</div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    
									<?php }} else{?>
									
										<h2 class="no_data"> No data found </h2>
									
									<?php } ?>									
									
                                </ul>
                           </div> 
						   
						   <?php echo $this->pagination->create_links();?>
                        </div><!--end-->
                       
                    </div>
                    
                     
                   
				   
				   
                </div>
            </div>

        </section>

    </div>
	
	<script>
	
		$(document).ready(function(){		
			var category_id = '<?php echo $params['category_id'];?>';			
			 if(category_id){				 
				$('#category_id').trigger('change');
			 }			 
		});

		$("#category_id").change(function(){	
		$.ajax({
		  url : '<?php echo base_url("tips/getSubcategory");?>',
		  type : 'POST',
		  data : 'category_id='+$(this).val(),
		  dataType : 'json',
		  success : function(data){		
			var html = '';
			var preCource = '<?php echo $params['sub_category_id'];?>';
			if(data!=''){
				html = html+'<option value="" >-None-</option>';
			  $.each(data,function(index,value){
				var selected ='';
				
				if(preCource == value.id){ selected = 'selected'; }
				
				html = html+'<option value="'+value.id+'" '+selected+'>'+value.title+'</option>';
			  }); 
			}else{
				 html = html+'<option value="" >-None-</option>';
			}
			$("#sub_category_id").html(html);
		  }
		})
	  })
	</script>
  