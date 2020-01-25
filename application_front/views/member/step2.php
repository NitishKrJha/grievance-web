<div class="login-bg">
    <div class="main-box">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="login_box">
                        <div class="login-logo">
                            <a href="javascript:void(0)"><img src="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/logo.png" alt="" class="img-responsive"></a>
                        </div>
                        <div class="register-box-body text-center">
                            <h2 class="login-box-msg">
                                Complete Your Profile
                            </h2>
                            <form name="f1" method="post" id="step2Form" class="padding_tpbtm" action="<?php echo base_url('member/doMemberStep2') ?>" enctype="multipart/form-data">
                                <div id="tab1">
                                    <div class="form-group">
                                        <label>Choose an username</label>
                                        <input type="text" name="username" id="username" class="form-control" placeholder="Stay safe! Don't use your real name...">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-cmn" id="step1_2">Continue</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab2" style="display: none">
                                    <input type='file' id="imgInp" />
                                    <div class="form-group">
                                        <label>Add Photo</label>
                                        <div id="uploadFile">

                                            <label for="upload" title="Upload photo" id="previoImg" class="camera"><img style="display: none" id="blah" src="#" /></label>

                                            <!--<a href="javascript:void(0)" class="photo_upload" >
                                                <input type="file" name="file" required id="upload"><i class="fa fa-upload" aria-hidden="true"></i> Upload Photo
                                            </a>-->
                                            <input id="upload" type="file" name="file"/>
                                            <a href="" id="upload_link">Upload your photo</a>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-cmn" id="step2_1">Previous</button>
                                            <button type="button" class="btn btn-cmn" id="step2_3">Continue</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab3" style="display: none">
                                    <div class="form-group">
                                        <label>Profile Heading</label>
                                        <textarea class="form-control" name="profile_heading" id="profile_heading" placeholder="Add a short summary about yourself..."></textarea>
                                    </div>
                                    <label>Birth Date</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select class="form-control" name="day" id="day" onchange="setDays(month,this,year)">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select class="form-control" name="month" id="month" onchange="setDays(this,day,year)">
                                                    <option value="1">January</option>
                                                    <option value="2">February</option>
                                                    <option value="3">March</option>
                                                    <option value="4">April</option>
                                                    <option value="5">May</option>
                                                    <option value="6">June</option>
                                                    <option value="7">July</option>
                                                    <option value="8">August</option>
                                                    <option value="9">September</option>
                                                    <option value="10">October</option>
                                                    <option value="11">November</option>
                                                    <option value="12">December</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select class="form-control" name="year" id="year" onchange="setDays(month,day,this)">
                                                    <?php for($i=1944;$i<=date('Y');$i++){ ?>
                                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <input class="form-control" type="hidden" id="dob" name="dob" value="1/1/1944">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label>Lifestyle</label>
                                        <textarea class="form-control" name="lifestyle" id="lifestyle" placeholder="What your normal spending habits..."></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-cmn" id="step3_2">Previous</button>
                                            <button type="button" class="btn btn-cmn" id="step3_4">Continue</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab4" style="display: none">
                                    <div class="form-group">
                                        <label>About Me</label>
                                        <textarea class="form-control" name="about_me" id="about_me" rows="3" placeholder="Add a short summary about yourself..." onKeyDown="textCounter(this,4000);" onKeyUp="textCounter(this,'aboutspan' ,4000)" ></textarea>
                                        <span class="help-block"><span id="aboutspan">0</span>/4000 characters.</span>
                                    </div>

                                    <div class="form-group">
                                        <label>Describe what you're looking for</label>
                                        <textarea class="form-control" name="describe_looking_for" id="describe_looking_for" rows="3" placeholder="Add a short summary about the person you are interested in" onKeyDown="textCounter(this,4000);" onKeyUp="textCounter(this,'shortsummarysapn' ,4000)" ></textarea>
                                        <span class="help-block"><span id="shortsummarysapn">0</span>/4000 characters.</span>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="hidden" name="memberId" value="<?php echo base64_decode($this->uri->segment(3)) ?>" />
                                            <button type="button" class="btn btn-cmn" id="step4_3">Previous</button>
                                            <button type="button" id="finalBtnClick" class="btn btn-cmn">Submit</button>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="login-footer text-center">
        <p>© <?php echo date('Y'); ?> All Rights Reserved. Designed by <a href="https://www.mymissingrib.com" rel="nofollow" target="_blank"> Mymissingrib </a></p>
    </div>
</div>
<script type="text/javascript">
    var numDays = {
        '1': 31, '2': 28, '3': 31, '4': 30, '5': 31, '6': 30,
        '7': 31, '8': 31, '9': 30, '10': 31, '11': 30, '12': 31
    };
    function setDays(oMonthSel, oDaysSel, oYearSel)
    {
        var nDays, oDaysSelLgth, opt, i = 1;
        nDays = numDays[oMonthSel[oMonthSel.selectedIndex].value];
        if (nDays == 28 && oYearSel[oYearSel.selectedIndex].value % 4 == 0)
            ++nDays;
        oDaysSelLgth = oDaysSel.length;
        if (nDays != oDaysSelLgth)
        {
            if (nDays < oDaysSelLgth)
                oDaysSel.length = nDays;
            else for (i; i < nDays - oDaysSelLgth + 1; i++)
            {
                opt = new Option(oDaysSelLgth + i, oDaysSelLgth + i);
                oDaysSel.options[oDaysSel.length] = opt;
            }
        }
        var oForm = oMonthSel.form;
        var month = oMonthSel.options[oMonthSel.selectedIndex].value;
        var day = oDaysSel.options[oDaysSel.selectedIndex].value;
        var year = oYearSel.options[oYearSel.selectedIndex].value;
        oForm.dob.value = month + '/' + day + '/' + year;
    }

</script>
<script>
 //Next Tab function
    $(document).on('click','#step1_2',function(){
        $("#username").css('border-color','');
        var username = $("#username").val();
        if(username==''){
            $('#username').css('border-color','#FF0004');
            return false;
        }else{
            $.ajax({
                type:'POST',
                url:'<?php echo base_url('member/checkUsername')?>',
                data:{username:username},
                dataType:'JSON',
                success:function(result){
                    if(result.error == 1)
                    {
                        alert('Username already exist.');
                        $('#username').val('');
                        $('#username').css('border-color','#FF0004');
                        return false;
                    }else{
                        $("#tab1").hide();
                        $("#tab2").show();
                        $("#tab3").hide();
                        $("#tab4").hide();
                    }
                }
            });
        }
    });
    $(document).on('click','#step2_3',function(){
        if($('#upload').get(0).files.length === 0)
        {
            $('#previoImg').css('border-color','#FF0004');
            return false;
        }else {
            $("#tab1").hide();
            $("#tab2").hide();
            $("#tab3").show();
            $("#tab4").hide();
        }
    });
    $(document).on('click','#step3_4',function(){
        $("#profile_heading").css('border-color','');
        $("#lifestyle").css('border-color','');
        if($('#profile_heading').val() == '')
        {
            $('#profile_heading').css('border-color','#FF0004');
            return false;
        }
        if($('#lifestyle').val() == '')
        {
            $('#lifestyle').css('border-color','#FF0004');
            return false;
        }
        $("#tab1").hide();
        $("#tab2").hide();
        $("#tab3").hide();
        $("#tab4").show();
    });

//Previous Tab function

    $(document).on('click','#step2_1',function(){
        $("#tab1").show();
        $("#tab2").hide();
        $("#tab3").hide();
        $("#tab4").hide();
    });
    $(document).on('click','#step3_2',function(){
        $("#tab1").hide();
        $("#tab2").show();
        $("#tab3").hide();
        $("#tab4").hide();
    });
    $(document).on('click','#step4_3',function(){
        $("#tab1").hide();
        $("#tab2").hide();
        $("#tab3").show();
        $("#tab4").hide();
    });
 function textCounter(field,cnt, maxlimit) {
     var cntfield = document.getElementById(cnt)
     if (field.value.length > maxlimit) // if too long...trim it!
         field.value = field.value.substring(0, maxlimit);
     // otherwise, update 'characters left' counter
     else if(field.value.length==0){
         cntfield.innerHTML = 0;
     }else{
         cntfield.innerHTML = maxlimit - field.value.length;
     }
 }
 $("#upload").change(function() {
     var val = $(this).val();
     switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
         case 'gif': case 'jpg': case 'png': case 'jpeg':
         readURL(this);
         break;
         default:
             $(this).val('');
             alert("Please Upload Valid Image.");
             break;
     }
 });
 function readURL(input) {

     if (input.files && input.files[0]) {
         var reader = new FileReader();

         reader.onload = function(e) {
             $("#blah").show();
             $('#blah').attr('src', e.target.result);
         }

         reader.readAsDataURL(input.files[0]);
     }
 }
 $("#finalBtnClick").on('click',function(){
     $("#about_me").css('border-color','');
     $("#describe_looking_for").css('border-color','');
     if($('#about_me').val() == '')
     {
         $('#about_me').css('border-color','#FF0004');
         return false;
     }
     if($('#describe_looking_for').val() == '')
     {
         $('#describe_looking_for').css('border-color','#FF0004');
         return false;
     }
     $("#step2Form")[0].submit();
 })
</script>

<script>
	$(function(){
$("#upload_link").on('click', function(e){
    e.preventDefault();
    $("#upload:hidden").trigger('click');
});
});
</script>
<style>
	#upload_link{
    text-decoration:none;
}
</style>