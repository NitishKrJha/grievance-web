<style>
    textarea {
        width: 100%;
        height: 150px;
        background: #fff;
    }
</style>
<section>
		<div class="db">
			<!--LEFT SECTION-->
			<?php $this->load->view('layout/member_left_menu')?>
			<!--CENTER SECTION-->
			<div class="db-2">
				<div class="db-2-com db-2-main">
					<h4>Logging Grievance</h4>
					<div class="db-2-main-com db2-form-pay db2-form-com">
						<?php $this->load->view('errors/msg');?>
						<div class="col s12">
							<!-- No Data Found -->
							<div class="db-2-main-com db-2-main-com-table">
								<table class="responsive-table">
									<thead>
										<tr>
											<th>Sl</th>
											<th>Grievance ID</th>
											<th>Department</th>
											<th>Topic</th>
											<th>Date</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php if(!empty($list)){
											$i=1;
											foreach($list as $kry=>$val){
												?>
												<tr>
													<td><?php echo $i+$startRecord; ?></td>
													<td><?php echo $val['id']; ?></td>
													<td><?php echo $val['department_name']; ?></td>
													<td><?php echo $val['subject']; ?></td>
													<td><?php echo date('Y-m-d',strtotime($val['created_date'])); ?></td>
													<td>
														<?php if($val['status'] == '3'){
															$status='Rejected';
															$class="db-done";
														}else if($val['status'] == '2'){
															$status='Resolved';
															$class="db-done";
														}else if($val['status'] == '1'){
															$status='Work In Progress';
															$class="db-not-done";
														}else{
															$status='Pending';
															$class="db-not-done";
														} ?>
														<span class="<?php echo $class; ?>"><?php echo $status; ?></span>
													</td>
													<td><a href="<?php echo base_url('supervisor/detail/'.$val['id']); ?>" class="<?php echo $class; ?>">view more</a>
													</td>
												</tr>
												<?php
												 $i++;
											}
										}else{
											?>
											<tr>
												<td colspan="7">No Data Found</td>
											</tr>
											<?php
										}?>
											
									</tbody>
								</table>
								<?php echo $this->pagination->create_links();?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--RIGHT SECTION-->
			
		</div>
	</section>