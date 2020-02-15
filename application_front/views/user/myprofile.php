<section>
		<div class="db">
			<!--LEFT SECTION-->
			<?php $this->load->view('layout/member_left_menu')?>
			<!--CENTER SECTION-->
			<div class="db-2">
				<div class="db-2-com db-2-main">
					<h4>My Profile</h4>
					<div class="db-2-main-com db-2-main-com-table">
						<table class="responsive-table">
							<tbody>
								<tr>
									<td>Full Name</td>
									<td>:</td>
									<td><?php echo $myDtl['first_name']." ".$myDtl['middle_name']." ".$myDtl['last_name']; ?></td>
								</tr>
								<tr>
									<td>CRN</td>
									<td>:</td>
									<td><?php echo $myDtl['crn']; ?></td>
								</tr>
								<tr>
									<td>DOJ</td>
									<td>:</td>
									<td><?php echo $myDtl['doj']; ?></td>
								</tr>
								<tr>
									<td>Department</td>
									<td>:</td>
									<td><?php echo $myDtl['department']; ?></td>
								</tr>
								<tr>
									<td>Designation</td>
									<td>:</td>
									<td><?php echo $myDtl['designation']; ?></td>
								</tr>
								<tr>
									<td>Phone</td>
									<td>:</td>
									<td><?php echo $myDtl['phone']; ?></td>
								</tr>
								<tr>
									<td>Email</td>
									<td>:</td>
									<td><?php echo $myDtl['email']; ?></td>
								</tr>
							</tbody>
						</table>
						<div class="db-mak-pay-bot">
							<a href="<?php echo base_url('user/editProfile') ?>" class="waves-effect waves-light btn-large">Edit my profile</a> </div>
					</div>
				</div>
			</div>
			<!--RIGHT SECTION-->
			<div class="db-3">
				<h4>Notifications</h4>
				<ul>
					<li>
						<a href="#!"> <img src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>assets/images/icon/dbr1.jpg" alt="" />
							<h5>50% Discount Offer</h5>
							<p>All the Lorem Ipsum generators on the</p>
						</a>
					</li>
					<li>
						<a href="#!"> <img src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>assets/images/icon/dbr2.jpg" alt="" />
							<h5>paris travel package</h5>
							<p>All the Lorem Ipsum generators on the</p>
						</a>
					</li>
					<li>
						<a href="#!"> <img src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>assets/images/icon/dbr3.jpg" alt="" />
							<h5>Group Trip - Available</h5>
							<p>All the Lorem Ipsum generators on the</p>
						</a>
					</li>
					<li>
						<a href="#!"> <img src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>assets/images/icon/dbr4.jpg" alt="" />
							<h5>world best travel agency</h5>
							<p>All the Lorem Ipsum generators on the</p>
						</a>
					</li>
					<li>
						<a href="#!"> <img src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>assets/images/icon/dbr5.jpg" alt="" />
							<h5>special travel coupons</h5>
							<p>All the Lorem Ipsum generators on the</p>
						</a>
					</li>
					<li>
						<a href="#!"> <img src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>assets/images/icon/dbr6.jpg" alt="" />
							<h5>70% Offer 2018</h5>
							<p>All the Lorem Ipsum generators on the</p>
						</a>
					</li>
					<li>
						<a href="#!"> <img src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>assets/images/icon/dbr7.jpg" alt="" />
							<h5>Popular Cities</h5>
							<p>All the Lorem Ipsum generators on the</p>
						</a>
					</li>
					<li>
						<a href="#!"> <img src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>assets/images/icon/dbr8.jpg" alt="" />
							<h5>variations of passages</h5>
							<p>All the Lorem Ipsum generators on the</p>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</section>