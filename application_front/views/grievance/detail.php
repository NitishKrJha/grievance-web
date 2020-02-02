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
									<td>Subject</td>
									<td>:</td>
									<td><?php echo $detail['subject']; ?></td>
								</tr>
								<tr>
									<td>Created Date</td>
									<td>:</td>
									<td><?php echo date('Y-m-d',strtotime($detail['created_date'])); ?></td>
								</tr>
								<tr>
									<td>Optional Email</td>
									<td>:</td>
									<td><?php echo $detail['optional_email']; ?></td>
								</tr>
								<tr>
									<td>Optional Phone</td>
									<td>:</td>
									<td><?php echo $detail['optional_phone']; ?></td>
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
									<td><span class="<?php echo $class; ?>"><?php echo $status; ?></span>
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
							<a href="<?php echo base_url('grievance/index/0/1'); ?>" class="waves-effect waves-light btn-large">Back To List</a> 
						</div>
					</div>
				</div>
			</div>
			<!--RIGHT SECTION-->
			
		</div>
	</section>