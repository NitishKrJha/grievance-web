<div class="col-md-3 col-sm-6">
    <div class="contactSec rightcontactSec">
        <div class="header-title">My Contacts <a style="color: #000;" href="<?php echo base_url('member/video_call_log/0/1'); ?>">(Video Call Details)</a></div>
        <div class="scrollbar-outer">
            <ul class="inner-content mycontactlist" id="contact">
                <li>No Contact Available</li>
			 <?php /* if(!empty($contacts)){ foreach($contacts['result']  as $k=>$val){  ?>
               <li> <span class="userIcn img-circle"><img src="<?= $val['crop_profile_image']?>" alt=""> <span class="onlineActv"></span></span> <span class="textSec">
                <h3><?= $val['name']?></h3>				</li>			  <?php  } } */?>
            </ul>
        </div>
        <!-- <div id="custom-search-input">
            <div class="input-group col-md-12">
                <input type="text" class="  search-query form-control" placeholder="Search Contact" onkeyup="search_contach(this)" />
                <span class="input-group-btn">
                <button class="btn btn-danger" type="button"> <span class=" glyphicon glyphicon-search"></span> </button>
                </span> </div>
        </div> -->
    </div>
</div>
<script>
    function search_contach(obj){
    	var text = $(obj).val();
    	$.ajax({
    		dataType:'json',
            type:'POST',
            url:'<?= base_url('member/get_top_ten')?>',
            data: {'search_text':text},
            beforeSend: function(){
            },
            success:function(data){
                var html ='';
                if(data!='no data found'){
                	for(var i=0; i< data.length; i++){
                    	html = html+'<li> <span class="userIcn img-circle"><img src="'+data[i].crop_profile_image+'" alt=""> <span class="onlineActv"></span></span> <span class="textSec"><h3>'+data[i].name+'</h3></li>';
                    }
                    $('#contact').html(html);
                }
                else{
                    html ='<li> <span class="textSec"><h3>No data found</h3></span></li>';
                    $('#contact').html(html);
                }
            }
        })
    }
    $(function(){
        getMyContactList();
    })
    function getMyContactList(num=0){
        var url="<?php echo base_url('page/getFirendList'); ?>";
        $.ajax({
          type:'POST',
          url: url,
          data:{'num':num},
          success:function(msg){ //alert(11);
            var response=$.parseJSON(msg);
            if(response.status > 0){
                if(response.cnt > 0){
                    $('.mycontactlist').html('');
                    var data=response.data;
                    var myid="<?php echo $this->nsession->userdata('member_session_id'); ?>";
                    $.each(data,function(key,val){
                        
                        if(val.from_member==myid){
                            var member_id=val.to_member;
                            var picture=val.to_picture;
                            var name=val.to_name;
                        }else{
                            var member_id=val.from_member;
                            var picture=val.from_picture;
                            var name=val.from_name;
                        }
                        if(picture==''){
                            picture="<?php echo css_images_js_base_url().'images/images.png'; ?>";
                        }
                        if(name==''){
                            name="Unknown";
                        }
                        var newchatReq ='';
                        newchatReq += '<li class="listimc'+member_id+'">';
                        newchatReq +='<span class="userIcn img-circle">';
                        newchatReq +='<img src="'+picture+'" alt="" style="height:50px; width:50px;">';
                        newchatReq +='</span>';
                        newchatReq +='<span class="textSec">';
                        newchatReq +='<h3>'+name+'</h3>';
                        newchatReq +='</span>';
                        newchatReq += '</li>';
                        $(".mycontactlist").append(newchatReq);
                    })
                }else{
                    $('.mycontactlist').html('<li>No Contact Available</li>');
                }
            }else{
                $('.mycontactlist').html('<li>No Contact Available</li>');
            }
          },
          error: function () {
            $('.mycontactlist').html('<li>No Contact Available</li>');
          }
        });
    }
</script>