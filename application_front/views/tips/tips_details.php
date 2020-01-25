        <section class="main-container">
            <div class="container-fluid">
                <div class="row">
                   <?php $this->load->view('layout/member_left_menu')?>
                    <div class="col-md-10">
                       <div class="userTips userTipsDetails">                       		
								<ul>
									<li>
                                    	<div class="row"> 
                                        	<div class="col-md-4">
												<figure>
																
												 <img src="<?php echo base_url()?>uploads/tips_image/<?php echo isset($icon)?$icon:''; ?>" alt="" width="" style="">									  
												</figure>                                            	
                                            </div>
                                            <div class="col-xs-6">
                                            	<div class="tipsTextSec">
													<h3> <?php echo isset($title)?$title:'';?> </h3>
                                                    <ul>
                                                    	<li><i class="fa fa-user" aria-hidden="true"></i> Posted by <span><a href="">Admin</a></span></li>
                                                        <li><i class="fa fa-tags" aria-hidden="true"></i> Category <span><a href=""><?php echo isset($cat_name)?$cat_name:'';?></a></span></li>
														<li><i class="fa fa-calendar" aria-hidden="true"></i> Posted Date<span><a href=""> <?php echo date('d M Y',strtotime($created_date));?></a></span></li>
                                                    </ul>
                                                    <p></p><p></p>
                                                </div>
                                            </div>
											<div class="col-md-12">
												<p><?php echo htmlspecialchars_decode(isset($content)?$content:'')?> </p>
											</div>
                                        </div>
                                    </li>
								</ul>                                                        
                       </div><!--end-->                       
                    </div>                 
                </div>
            </div>

        </section>

   
