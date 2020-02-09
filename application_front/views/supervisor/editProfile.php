<section>
		<div class="db">
			<!--LEFT SECTION-->
			<?php $this->load->view('layout/member_left_menu')?>
			<!--CENTER SECTION-->
			<div class="db-2">
				<div class="db-2-com db-2-main">
					<h4>Edit My Profile </h4>
					<div class="db-2-main-com db2-form-pay db2-form-com">
						<form class="col s12">
							<div class="row">
								<div class="input-field col s12">
									<input type="number" class="validate">
									<label>User Name</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12 m6">
									<input type="password" class="validate">
									<label>Enter Password</label>
								</div>
								<div class="input-field col s12 m6">
									<input type="password" class="validate">
									<label>Confirm Password</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12 m6">
									<input type="email" class="validate">
									<label>Email id</label>
								</div>
								<div class="input-field col s12 m6">
									<input type="number" class="validate">
									<label>Phone</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<select>
										<option value="" disabled selected>Select Status</option>
										<option value="1">Active</option>
										<option value="2">Non-Active</option>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<input id="pay-ca" type="number" class="validate">
									<label for="pay-ca">Card Number</label>
								</div>
							</div>
							<div class="row db-file-upload">
								<div class="file-field input-field">
									<div class="db-up-btn"> <span>File</span>
										<input type="file"> </div>
									<div class="file-path-wrapper">
										<input class="file-path validate" type="text"> </div>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<input type="submit" value="SUBMIT" class="waves-effect waves-light full-btn"> </div>
							</div>
						</form>
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