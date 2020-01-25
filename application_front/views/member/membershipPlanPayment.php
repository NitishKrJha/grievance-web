<section class="main-container">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="btm-section payment">
                    <h2>Summary</h2>
                    <div class="bx grayBx">
                        <h3><?php echo $getPlanDetails[0]['plantype'] ?> Plan <span>($<?php echo $getPlanDetails[0]['price'] ?> per month)</span></h3>
                        <span class="pull-right rate">$ <?php echo $getPlanDetails[0]['price'] ?></span> <a class="changePln" href="<?php echo base_url('member/membershipplan') ?>">Want to change plan?</a> </div>
                    <h2>Personal Details</h2>
                    <form action="<?php echo base_url('member/doMembershipPayment'); ?>" id="membershipPayment" method="post">
                    <div class="bx whitBx">
                        <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="usr">name</label>
                                        <input type="text" class="form-control" name="name" placeholder="Name" value="<?php echo $memberInfo[0]['name']!=''?$memberInfo[0]['name']:'' ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="usr">Email id</label>
                                        <input type="email" class="form-control" name="email_id" placeholder="Email ID" value="<?php echo $memberInfo[0]['email']!=''?$memberInfo[0]['email']:''; ?>">
                                    </div>
                                </div>
                                <!--<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="usr">Phone no</label>
                                        <input type="number" class="form-control" name="phone_no" placeholder="Phone Number">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="usr">Location</label>
                                        <input type="text" class="form-control" name="location" placeholder="Location or Street" >
                                    </div>
                                </div>-->
                        </div>
                    </div>
                    <h2>Provide Credit Card Details</h2>
                    <div class="paymntMthdbx">
                        <div class="crdtSec"><!--card sec start-->
                            <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="usr">CREDIT CARD NUMBER</label>
                                            <input type="text" class="form-control" placeholder="7896 8903 6789 1234" name="ccNbr" id="card_number">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group cvv">
                                            <label for="usr">CVV</label>
                                            <input type="text" class="form-control" name="cvv" id="cvv">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="form-group">
                                            <label for="usr">EXPIRY MONTH</label>
                                            <select class="form-control" name="expiryMonth" id="expiryMonth">
                                                <option value="">Month</option>
                                                <option value="01">January</option>
                                                <option value="02">February</option>
                                                <option value="03">March</option>
                                                <option value="04">April</option>
                                                <option value="05">May</option>
                                                <option value="06">June</option>
                                                <option value="07">July</option>
                                                <option value="08">August</option>
                                                <option value="09">September</option>
                                                <option value="10">October</option>
                                                <option value="11">November</option>
                                                <option value="12">December</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="form-group">
                                            <label for="usr">EXPIRY YEAR</label>
                                            <select class="form-control" name="expiryYear" id="expiryYear">
                                                <option value="">Year</option>
                                                <?php
                                                for($i=0;$i<=10;$i++){ ?>
                                                    <option value="<?php echo date('Y',strtotime('+'.$i.'year')) ?>"><?php echo date('Y',strtotime('+'.$i.'year')) ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="usr">NAME ON CARD</label>
                                            <input type="text" class="form-control" name="nameOnCard" id="nameOnCard">
                                        </div>
                                    </div>
                                <input type="hidden" name="planId" value="<?php echo base64_decode($this->uri->segment(3)); ?>">
                            </div>
                            <input type="checkbox" name="anyone_visable" value="1">
										get boosted to be x5 visible than anyone else
                        </div>
                        <div class="col-md-12">
                        	<input type="submit" class="checkOutBtn" value="CHECK OUT" style="border: none;width: 100%;">
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<span class="loader" style="display: none"><img src="<?php echo front_base_url().'public/images/loader.gif' ?>"></span>
<script type="text/javascript" src="https://demos.codexworld.com/credit-card-number-validation-jquery/creditCardValidator.js"></script>
<script>
    $(document).ready(function(){
        $("#membershipPayment").validate({
            // Specify validation rules
            rules: {
                name: {
                    required: true
                },
                email_id: {
                    required: true,
                    email:true
                },
                ccNbr: {
                    required: true,
                    number:true
                },
                cvv: {
                    required: true,
                    number:true,
                    maxlength: 3,
                    minlength: 3
                },
                expiryMonth: {
                    required: true
                },
                expiryYear: {
                    required: true
                },
                nameOnCard: {
                    required: true
                }
            },
            submitHandler: function(form) {
                //form.submit();
                $.ajax({
                    url:"<?php echo base_url('member/doMembershipPayment') ?>",
                    type:"Post",
                    data:$("#membershipPayment").serialize(),
                    dataType:"Json",
                    beforeSend:function(){
                        $(".loader").show();
                    },
                    success:function(data){
                        if(data.error==0){
                            window.location.href="<?php echo base_url('member/profile') ?>";
                        }else{
                            notifyMe('Error',data.message);
                        }
                    },
                    complete:function(){
                        $(".loader").hide();
                    }
                })
            }
        });
    });
    function cardFormValidate(){
    var cardValid = 0;

    //card number validation
    $('#card_number').validateCreditCard(function(result){
        if(result.valid){
            $("#card_number").removeClass('required');
            cardValid = 1;
        }else{
            $("#card_number").addClass('required');
            cardValid = 0;
        }
    });
      
    //card details validation
    var cardName = $("#nameOnCard").val();
    var expMonth = $("#expiryMonth").val();
    var expYear = $("#expiryYear").val();
    var cvv = $("#cvv").val();
    var regName = /^[a-z ,.'-]+$/i;
    var regMonth = /^01|02|03|04|05|06|07|08|09|10|11|12$/;
    var regYear = /^2017|2018|2019|2020|2021|2022|2023|2024|2025|2026|2027|2028|2029|2030|2031$/;
    var regCVV = /^[0-9]{3,3}$/;
    if (cardValid == 0) {
        $("#card_number").addClass('required');
        $("#card_number").focus();
        return false;
    }else if (!regMonth.test(expMonth)) {
        $("#card_number").removeClass('required');
        $("#expiryMonth").addClass('required');
        $("#expiryMonth").focus();
        return false;
    }else if (!regYear.test(expYear)) {
        $("#card_number").removeClass('required');
        $("#expiryMonth").removeClass('required');
        $("#expiryYear").addClass('required');
        $("#expiryYear").focus();
        return false;
    }else if (!regCVV.test(cvv)) {
        $("#card_number").removeClass('required');
        $("#expiryMonth").removeClass('required');
        $("#expiryYear").removeClass('required');
        $("#cvv").addClass('required');
        $("#cvv").focus();
        return false;
    }else if (!regName.test(cardName)) {
        $("#card_number").removeClass('required');
        $("#expiryMonth").removeClass('required');
        $("#expiryYear").removeClass('required');
        $("#cvv").removeClass('required');
        $("#nameOnCard").addClass('required');
        $("#nameOnCard").focus();
        return false;
    }else{
        $("#card_number").removeClass('required');
        $("#expiryMonth").removeClass('required');
        $("#expiryYear").removeClass('required');
        $("#cvv").removeClass('required');
        $("#nameOnCard").removeClass('required');
        return true;
    }
}
$(document).ready(function() {
    //card validation on input fields
    $('#membershipPayment input[type=text]').on('keyup',function(){
        cardFormValidate();
    });
});
</script>