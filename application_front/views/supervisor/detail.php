<section>
		<div class="db">
			<!--LEFT SECTION-->
			<?php $this->load->view('layout/member_left_menu')?>
			<!--CENTER SECTION-->
			<div class="db-2">
				<div class="db-2-com db-2-main">
					<h4>Grievance Detail</h4>
					<div class="db-2-main-com db-2-main-com-table">
						<?php $this->load->view('errors/msg');?>
						<table class="responsive-table">
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
										<!-- <span class="<?php echo $class; ?>"><?php echo $status; ?></span> -->
										<div class="form-group">
											<select class="form-control" id="changeStatus">
												<option value="">Select Status</option>
												<option value="0" <?php echo ($detail['status'] == '0')?'selected="selected"':'' ?>>Pending</option>
												<option value="1" <?php echo ($detail['status'] == '1')?'selected="selected"':'' ?>>Work In Progress</option>
												<option value="2" <?php echo ($detail['status'] == '2')?'selected="selected"':'' ?>>Resolved</option>
												<option value="3" <?php echo ($detail['status'] == '3')?'selected="selected"':'' ?>>Rejected</option>
											</select>
										</div>
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
							<a href="<?php echo base_url('supervisor/index/0/1'); ?>" class="waves-effect waves-light btn-large">Back To List</a> 
						</div>
					</div>
				</div>
			</div>
			<!--RIGHT SECTION-->
			
		</div>
	</section>

<script>
	$(document).on('change','#changeStatus',function(){
		var $this=$(this);
		if($this.val() != ''){
			if(window.confirm('Are you sure want to change status')){
				$('#load-txt').show();
				$.ajax({
				type:'POST',
				url:'<?php echo base_url() ?>supervisor/changeStatusOfGrievance/',
				data:{status: $this.val(), id: "<?php echo $detail['id']; ?>"},
				success:function(msg){
					$('#load-txt').hide();
					window.location.reload();
				},
				error: function () {
					$('#load-txt').hide();
					messagealert('Error','Technicle Issue, Please try after some time','error');
				}
			});
			}
		}
	});
</script>