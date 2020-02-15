<?php
//pr($data);
?>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content">
	  <?php //echo validation_errors(); ?>
      <ul class="parsley-errors-list filled error text-left" ><li class="parsley-required"><?php echo $errmsg; ?></li></ul>
			<form id="form1" class="form-horizontal" action="<?php echo $do_addedit_link;?>" method="post" enctype="multipart/form-data">
			<table class="table responsive-table">
							<tbody>
								<tr>
									<td>ID</td>
									<td>:</td>
									<td><?php echo $detail['id']; ?></td>
								</tr>
								<tr>
									<td>Department</td>
									<td>:</td>
									<td><?php echo $detail['department_name']; ?></td>
								</tr>
								<tr>
									<td>Topic</td>
									<td>:</td>
									<td><?php echo $detail['subject']; ?></td>
								</tr>
								<tr>
									<td>Details</td>
									<td>:</td>
									<td><?php echo $detail['query']; ?></td>
								</tr>
								<tr>
									<td>Uploaded File</td>
									<td>:</td>
									<td>
										<?php if($detail['file_name']!=''){
											?><a href="<?php echo base_url().'uploads/grievance/'.$detail['file_name']; ?>" download><?php echo $detail['file_name']; ?></a><?php
										}else{
											echo "NA";
										} ?>
									</td>
								</tr>
								<tr>
									<td>Created Date</td>
									<td>:</td>
									<td><?php echo date('Y-m-d',strtotime($detail['created_date'])); ?></td>
								</tr>
								
								<?php 	
									if($detail['status'] == '3'){
										$status='Rejected';
										$class="db-done";
									}else if($detail['status'] == '2'){
										$status='Resolved';
										$class="db-done";
									}else if($detail['status'] == '1'){
										$status='Work In Progress';
										$class="db-not-done";
									}else{
										$status='Pending';
										$class="db-not-done";
									}
								?>
								<tr>
									<td>Status</td>
									<td>:</td>
									<td>
										<span class="<?php echo $class; ?>"><?php echo $status; ?></span>
										
									</td>
								</tr>
								<?php
								if($detail['status']!='0'){
									?>
									<tr>
										<td>Responded By</td>
										<td>:</td>
										<td>
											<?php
												$name= '';
												if($detail['first_name']!==''){
													$name .= $detail['first_name']." ";
												}
												if($detail['middle_name']!==''){
													$name .= $detail['middle_name']." ";
												}
												if($detail['last_name']!==''){
													$name .= $detail['last_name'];
												}
												echo $name;
											?>
										</td>
									</tr>
									<?php
								}
								?>
								
								
							</tbody>
						</table>
						<div class="db-mak-pay-bot">
							<a href="<?php echo base_url('grievance/index/0/1'); ?>" class="btn btn-info">Back To List</a> 
						</div>
			</form>
	 </div>
    </div>
  </div>
</div>
