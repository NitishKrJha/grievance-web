<?php //pr($recordset); ?>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2><?php echo $module;?> </h2>
      <div class="clearfix"></div>
    </div>

    <div class="x_content">
          <!--<form id="frmSearch" class="form-horizontal form-label-left input_mask" name="frmSearch" action="<?php echo $search_link; ?>" method="post" >
          <div class="col-md-4 form-group">
		  
            <select class="form-control" aria-controls="example" name="searchField">
                  <option value="">-Select-</option>
                   <option value="tips.title" <?php if(isset($params['searchField']) && $params['searchField']=='tips.title') echo 'selected';?>> Name </option>                  
            </select>
			
          </div>
          <div class="col-md-4 form-group">
               <input type="text" class="form-control" value="<?php if(isset($params['searchString'])){echo $params['searchString']; }?>" name="searchString">
          </div>
           <div class="col-md-4 form-group">
              <input type="hidden" name="sortType" id="sortType" value="<?php echo $params['sortType'];?>" />
              <input type="hidden" name="sortField" id="sortField" value="<?php echo $params['sortField'];?>" />
              <input type="submit" id="addData" class="btn btn-primary marg-5" name="search" value="Search">
              <a href="<?php echo $showall_link;?>" class="btn btn-success marg-5">Show All</a>
          </div>
          </form>-->
      <div>
        <ul class="nav navbar-right panel_toolbox">
          <li style="width:50px;">&nbsp;
          </li>
        <li><a title="Add Owner/Managers" href="<?php echo $add_link; ?>"><i class="fa fa-plus"></i></a>
          </li>
        </ul>
      </div>
      <div class="clearfix"></div>
      <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
          <thead>
            <tr class="headings">
              <th class="column-title">SL</th>
              <th class="column-title">Member Name</th>
              <th class="column-title">Counselor Name</th>
              <th class="column-title">Time Zone</th>
              <th class="column-title">Date</th>              
              <th class="column-title">Action</th>
              </th>
            </tr>
          </thead>

          <tbody>
          <?php if(!empty($recordset)){ $i=2; ?>
            <?php $i=1; foreach($recordset as $singleRecord){
              $ediLink = str_replace('{{ID}}', $singleRecord['booking_id'], $edit_link);
              $activeLink = str_replace('{{ID}}',$singleRecord['booking_id'],$activated_link);
			        $inacttivedLink = str_replace('{{ID}}',$singleRecord['booking_id'],$inacttived_Link);
            ?>
            <tr class="<?php echo $i%2==0?'even':'odd'; ?> pointer">
			        <td class=" "><?php echo $i+$startRecord; ?></td>
			        <td class=" "><?php echo $singleRecord['memberName']; ?></td>
              <td class=" "><?php echo $singleRecord['counselorName']; ?></td>
              <td class=" "><?php echo $singleRecord['timezone']; ?></td>
               <td class=" "><?php echo date('Y m d H:i:s',strtotime($singleRecord['booking_date'])); ?></td>
             
              <!--<td class=" last"><a href="<?php echo $ediLink; ?>" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a> ||  <a href="<?php echo base_url('tips/delete/'.$singleRecord['id']) ?>" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a></td>-->
			  <!--<td><a href="<?php echo base_url('booking/counselor_assign/'.$singleRecord['counselor_id'])?>"><button class="btn btn-info btn-xs" type="button"> Assign </button></a></td>-->

			 <td><a href="javascript:ChangeStatusForBooking('<?php echo $singleRecord['assign'];?>','<?php echo $singleRecord['booking_id']; ?>');"><button class="btn btn-<?php echo $singleRecord['assign']=='0'?'info':'danger';?> btn-xs" type="button"><?php echo $singleRecord['assign']==0?'Assign':'Already Assigned';?></button></a> </td> 
		  
            </tr>
          <?php  $i++; }
            }else{ echo '<tr><td colspan="7" align="center">No Record Added Yet.</td></tr>'; }
          ?>
          </tbody>
        </table>
        <?php echo $this->pagination->create_links();?>
      </div>
    </div>
  </div>
</div>
</div>
<script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>js/jquery.validate.min.js"></script>
<script>
function ChangeStatusForBooking(val,booking_id){
  if(val==0){
    var cnf="Do yo want to assign";
  }else{
    var cnf="Do yo want to cancel";
  }
  if(confirm(cnf)){
    $('#modalContactForm').modal('show');
    $('#booking_id').val(booking_id);
    $('#booking_status').val(val);
  }
}

  $(function(){
    $("#sendForm").validate({
    
      // Specify validation rules
      rules: {
        subject:{
          required: true
        },
        message: {
          required: true
        },
        c_subject:{
          required: true
        },
        c_message: {
          required: true
        }
      },
      messages: {
      },
      submitHandler: function(form) {
    
        var data=$("form[name='sendForm']").serialize();
        do_submit(data);
      }
    });
  })

  function do_submit(formData){
    $.ajax({
          type:'POST',
          url:$( '#sendForm' ).attr('action'),
          data:formData,
          beforeSend:function(){
            //$('#makeLogin').button('loading');
          },
          success:function(msg){
           window.location.reload();
          },
          error: function () {
            alert('Please try after some time');
          }
        });
  }
</script>

<div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form name="sendForm" id="sendForm" action="<?php echo base_url('booking/givepermission'); ?>" method="post">
              <div class="modal-header text-center">
                  <h4 class="modal-title w-100 font-weight-bold">Send Message</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <center><h4 class="modal-title w-100 font-weight-bold">User Message</h4></center>
              <div class="modal-body mx-3">

                  <div class="md-form mb-5">
                      <label data-error="wrong" data-success="right" for="form32">Subject</label>
                      <input type="text" id="subject" name="subject" class="form-control validate">
                      
                  </div>
                  <input type="hidden" name="booking_id" id="booking_id" value="0">
                  <input type="hidden" name="booking_status" id="booking_status" value="0">
                  <div class="md-form">
                      <label data-error="wrong" data-success="right" for="form8">Your message</label>
                      <textarea type="text" id="message" name="message" class="md-textarea form-control" rows="4"></textarea>
                      
                  </div>

              </div>
              <center><h4 class="modal-title w-100 font-weight-bold">Councellor Message</h4></center>
              <div class="modal-body mx-3">

                  <div class="md-form mb-5">
                      <label data-error="wrong" data-success="right" for="form32">Subject</label>
                      <input type="text" id="c_subject" name="c_subject" class="form-control validate">
                      
                  </div>
                  <div class="md-form">
                      <label data-error="wrong" data-success="right" for="form8">Your message</label>
                      <textarea type="text" id="c_message" name="c_message" class="md-textarea form-control" rows="4"></textarea>
                      
                  </div>

              </div>
              <div class="modal-footer d-flex justify-content-center">
                  <button class="btn btn-unique" type="submit" id="submit" name="submit" value="submit">Send <i class="fa fa-paper-plane-o ml-1"></i></button>
              </div>
            </form>
        </div>
    </div>
</div>