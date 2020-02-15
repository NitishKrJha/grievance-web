<section>
		<div class="db">
			<!--LEFT SECTION-->
			<?php $this->load->view('layout/member_left_menu')?>
			<!--CENTER SECTION-->
			<div class="db-2">
				<div class="db-2-com db-2-main">
					<h4>Edit My Profile </h4>
					<div class="db-2-main-com db2-form-pay db2-form-com">
						<form class="col s12" id="addForm" method="post" enctype="multipart/form-data" action="<?php echo base_url('supervisor/doEditProfile'); ?>">
							<div class="row">
								<div class="input-field col s12 m4">
									<input type="text" class="validate" name="first_name" value="<?php echo $myDtl['first_name']; ?>">
									<label>First Name</label>
								</div>
								<div class="input-field col s12 m4">
									<input type="text" class="validate" name="middle_name" value="<?php echo $myDtl['middle_name']; ?>">
									<label>Middle Name</label>
								</div>
								<div class="input-field col s12 m4">
								<input type="text" class="validate" name="last_name" value="<?php echo $myDtl['last_name']; ?>">
									<label>Last Name</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12 m12">
									<input type="email" value="<?php echo $myDtl['crn']; ?>" disabled>
									<label>CRN</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12 m12">
									<input type="email" value="<?php echo $myDtl['email']; ?>" disabled>
									<label>Email id</label>
								</div>
								<div class="input-field col s12 m12">
									<input type="number" value="<?php echo $myDtl['phone']; ?>" disabled>
									<label>Phone</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<div class="file-field">
										<div class="btn btn-primary btn-sm float-left" style="height: 44px !important;">
										<span>Choose file</span>
										<input type="file" name="file" accept="image/*">
										</div>
										<div class="file-path-wrapper">
										<input class="file-path validate" type="text" placeholder="Upload your file">
										</div>
									</div>
								</div>
								<label id="file-error" class="error col s12" for="file" ></label>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<input type="submit" value="SUBMIT" class="waves-effect waves-light full-btn"> </div>
							</div>
						</form>
					</div>
				</div>
			</div>
			
	</section>