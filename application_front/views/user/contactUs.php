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
					<h4>Raise A Query</h4>
					<div class="db-2-main-com db2-form-pay db2-form-com">
						<form class="col s12">
							<div class="row">
								<div class="input-field col s12">
									<input type="text" class="validate">
									<label>Subject</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12 m6">
									<input type="email" class="validate">
									<label>Optional Email id</label>
								</div>
								<div class="input-field col s12 m6">
									<input type="number" class="validate">
									<label>Optional Phone</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
                                    <textarea class="validate"></textarea>
									<label for="pay-ca">Body</label>
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
			
		</div>
	</section>