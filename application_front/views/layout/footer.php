
<style>
	#local-media.video-popup-smallBx video{
		height:100px;
	}
	#local-media.video-popup-smallBx{
		top: 200px;
		right: 0;
	}
	#remote-media video{
		width:100%;
	}
	div#remote-media{
		position: relative;
		/*bottom: 20%;
    right: 0; */
	}
	#local-media.video-popup-smallBx video {
    height: 100px;
    width: 136px;
	}
</style>

<?php
$global_facebook = $this->functions->getGlobalInfo('global_facebook_url');
$global_twitter = $this->functions->getGlobalInfo('global_twitter_url');
$global_youtube_url = $this->functions->getGlobalInfo('global_youtube_url');
$global_linkedin_url = $this->functions->getGlobalInfo('global_linkdin_url');
$global_instagram_url = $this->functions->getGlobalInfo('global_instagram_url');
?>
<!--====== FOOTER 1 ==========-->
<?php  ?>
<section>
		<div class="rows">
				<div class="footer1 home_title tb-space">
						
				</div>
		</div>
</section>
<?php  ?>
<!--====== FOOTER 2 ==========-->
<section>
		<div class="rows">
				<div class="footer">
						<div class="container">
								<div class="foot-sec2">
										<div>
												<div class="row">
														<div class="col-sm-3 foot-spec foot-com">
																<h4><span>User</span> Grievence & Booking</h4>
																<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
														</div>
														<div class="col-sm-3 foot-spec foot-com">
																<h4><span>Address</span> & Contact Info</h4>
																<p>28800 Orchard Lake Road, Suite 180 Farmington Hills, U.S.A. Landmark : Next To Airport</p>
																<p> <span class="strong">Phone: </span> <span class="highlighted">+101-1231-1231</span> </p>
														</div>
														<div class="col-sm-3 col-md-3 foot-spec foot-com">
																<h4><span>SUPPORT</span> & HELP</h4>
																<ul class="two-columns">
																		<li> <a href="<?php echo base_url('page/aboutUs'); ?>">About Us</a> </li>
																		<li> <a href="<?php echo base_url('page/faq'); ?>">FAQ</a> </li>
																		<li> <a href="<?php echo base_url('page/aboutUs'); ?>">Testimonial</a> </li>
																		<li> <a href="<?php echo base_url('page/howitworks'); ?>">How It works </a> </li>
																		<li> <a href="<?php echo base_url('page/terms'); ?>">Terms</a> </li>
																		<li> <a href="<?php echo base_url('page/provacy'); ?>">Privacy</a> </li>
																		<li> <a href="<?php echo base_url('page/contactUs'); ?>">Contact Us</a> </li>
																</ul>
														</div>
														<div class="col-sm-3 foot-social foot-spec foot-com">
																<h4><span>Follow</span> with us</h4>
																<p>Join the thousands of other There are many variations of passages of Lorem Ipsum available</p>
																<ul>
																		<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a> </li>
																		<li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a> </li>
																		<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a> </li>
																		<li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a> </li>
																		<li><a href="#"><i class="fa fa-youtube" aria-hidden="true"></i></a> </li>
																</ul>
														</div>
												</div>
										</div>
								</div>
						</div>
				</div>
		</div>
</section>
<!--====== FOOTER - COPYRIGHT ==========-->
<section>
		<div class="rows copy">
				<div class="container">
						<p>Copyrights © 2020 Company Name. All Rights Reserved</p>
				</div>
		</div>
</section>
<!-- <section>
		<div class="icon-float">
				<ul>
						<li><a href="#" class="sh">1k <br> Share</a> </li>
						<li><a href="#" class="fb1"><i class="fa fa-facebook" aria-hidden="true"></i></a> </li>
						<li><a href="#" class="gp1"><i class="fa fa-google-plus" aria-hidden="true"></i></a> </li>
						<li><a href="#" class="tw1"><i class="fa fa-twitter" aria-hidden="true"></i></a> </li>
						<li><a href="#" class="li1"><i class="fa fa-linkedin" aria-hidden="true"></i></a> </li>
						<li><a href="#" class="wa1"><i class="fa fa-whatsapp" aria-hidden="true"></i></a> </li>
						<li><a href="#" class="sh1"><i class="fa fa-envelope-o" aria-hidden="true"></i></a> </li>
				</ul>
		</div>
</section> -->

<script>
	function messagealert(title,text,type){
			new PNotify({
						title: title,
						text:  text,
						type:  type,
						styling: 'bootstrap3'
					});
	}
</script>
