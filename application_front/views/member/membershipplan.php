<section class="main-container">
    <div class="container-fluid">
        <div class="row">
            <?php $this->load->view('layout/member_left_menu')?>
            <div class="col-md-10">
                <div class="membership ">
                    <?php if($isPremiumMemmber==1){ ?>
                        <a class="cancelMembership" href="<?php echo base_url('member/cancelMembershipPlan')?>" onClick="return confirm('Are you sure.? You want to cancel your membership.')">Cancel Membership</a>
                    <?php } ?>
                    <?php if($isPremiumMemmber==0){ ?>
                        <h2>Upgrade your Account for Full Access to Premium Features</h2>
                        <?php if(count($membershipPlans)>0){
                            foreach ($membershipPlans as $membershipPlan){ ?>
                            <div class="col-md-4 col-sm-4">
                                <div class="item-memeber">
                                    <h3><?php echo $membershipPlan['plantype']; ?></h3>
                                    <div class="amount"><i class="fa fa-usd" aria-hidden="true"></i> <span><?php echo $membershipPlan['price']; ?></span>  <strong>/Mo</strong>. </div>
                                    <p><?php echo $membershipPlan['minute']; ?> Free Calling Minutes</p>
                                    <p><?php echo $membershipPlan['tips_reads']; ?> Paid Tips</p>
                                    <p><?php echo $membershipPlan['messaging']; ?> Messaging</p>
                                    <p>Free Introduction</p>
                                    <a class="selectBtn" href="<?php echo base_url('member/membershipplanpayment/'.base64_encode($membershipPlan['plan_id'])) ?>">Select</a>
                                </div>
                            </div>
                            <?php } } ?>
                    <?php }else{
                        $membership_plan_data = json_decode($planDetails['membership_plan_data'],true);
                        ?>
                        <h2>Your Current Premium Membership Plan Details.</h2>
                        <div class="col-md-6 col-sm-6 col-md-offset-3  col-sm-offset-3 singleMembership">
                            <div class="item-memeber active">
                                <h3><?php echo $membership_plan_data['plantype']; ?></h3>
                                <div class="amount"><i class="fa fa-usd" aria-hidden="true"></i> <span><?php echo $membership_plan_data['price']; ?></span>  <strong>/Mo</strong>. </div>
                                <p><?php echo $planDetails['minute_remaning']; ?> Free Calling Minutes</p>
                                <p><?php echo $planDetails['tips_reads_remaning']; ?> Paid Tips</p>
                                <p><?php echo $planDetails['messaging_remaining']; ?> Messaging</p>
                                <p>Free Introduction</p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php //echo $this->load->view('layout/memberMyContact'); ?>
            <?php //echo $this->load->view('layout/memberChatRequest'); ?>
        </div>
    </div>
</section>
