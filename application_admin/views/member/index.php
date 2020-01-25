<?php //pr($recordset); ?>
<style>

</style>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2><?php echo $module;?> </h2>
      <div class="clearfix"></div>
    </div>

    <div class="x_content">
          <form id="frmSearch" class="form-horizontal form-label-left input_mask" name="frmSearch" action="<?php echo $search_link; ?>" method="post" >
          <div class="col-md-4 form-group">
            <select class="form-control" aria-controls="example" name="searchField">
                  <option value="">-Select-</option>
                   <option value="member.name" <?php if(isset($params['searchField']) && $params['searchField']=='member.name') echo 'selected';?>>Name</option>
                   <option value="member.email" <?php if(isset($params['searchField']) && $params['searchField']=='member.email') echo 'selected';?>>Email</option>
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
          </form>
      <div>
        <ul class="nav navbar-right panel_toolbox">
          <li style="width:50px;">&nbsp;
          </li>
         <!-- <li><a title="Add Owner/Managers" href="<?php echo $add_link; ?>"><i class="fa fa-plus"></i></a>
          </li> -->
        </ul>
      </div>
      <div class="clearfix"></div>
      <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
          <thead>
            <tr class="headings">
              <th class="column-title">SL</th>
              <th class="column-title">Profile Image</th>
              <th class="column-title">Name</th>
              <th class="column-title">Email</th>
              <th class="column-title">Gender</th>
              <th class="column-title">Marital Status</th>
              <th class="column-title">Created</th>
              <th class="column-title">Status</th>
			        <th class="column-title">Featured Member</th>
              <th class="column-title">Send Url</th>
              <th class="column-title">Member Type</th>
              <th class="column-title">Plan Type</th>
			        <th class="column-title">Action</th>
              </th>
            </tr>
          </thead>

          <tbody>
          <?php  if(!empty($recordset)){ $i=2; ?>
            <?php $i=1; foreach($recordset as $singleRecord){
              $ediLink = str_replace('{{ID}}', $singleRecord['memberId'], $edit_link);
              $activeLink = str_replace('{{ID}}',$singleRecord['memberId'],$activated_link);
			        $inacttivedLink = str_replace('{{ID}}',$singleRecord['memberId'],$inacttived_Link);
				   
			        $addfutureLink = str_replace('{{ID}}',$singleRecord['memberId'],$addfuture_Link);
			        $removefutureLink = str_replace('{{ID}}',$singleRecord['memberId'],$removefuture_Link);
            ?>
            <tr class="<?php echo $i%2==0?'even':'odd'; ?> pointer">
			        <td class=" "><?php echo $i+$startRecord; ?></td>
              <td>
                  <?php
                  if($singleRecord['memberPicture']==''){ ?>
                  <img src="https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg" alt="" class="img-responsive" style="width:50px;height:50px">
				          <?php }else{
                  if(isset($singleRecord['oauth_uid']) && $singleRecord['oauth_uid']==''){ ?>
                  <img src="<?php echo $singleRecord['memberPicture']; ?>" alt="" class="img-responsive" style="width:50px;height:50px"/>
                  <?php }else{?>
                  <img src="<?php echo $singleRecord['memberPicture']; ?>" alt="" class="img-responsive" style="width:50px;height:50px"/>
                  <?php } } ?>
              </td>
			        <td class=" "><?php echo $singleRecord['MemberName']!=''?$singleRecord['MemberName']:"N/A"; ?></td>
              <td class=" "><?php echo $singleRecord['user_email']; ?></td>
              <td class=" "><span class="label label-<?php echo $singleRecord['gender']=='1'?'primary':'primary';?>"><?php echo $singleRecord['gender']==1?'Male':'Female';?></span></td>
              <td class=" ">
                  <span class="label label-primary">
                      <?php switch ($singleRecord['maritialStatus']){
                          case 1:
                                echo "Single";
                                break;
                          case 2:
                              echo "Married";
                              break;
                          case 3:
                              echo "Divorced";
                              break;
                      } ?>
                  </span>
              </td>
              <!-- <td class=" ">
                <span class="label label-primary">
                    <?php switch ($singleRecord['interestedIn']){
                        case 1:
                            echo "Men";
                            break;
                        case 2:
                            echo "Women";
                            break;
                        case 3:
                            echo "Both";
                            break;
                    } ?>
                </span>
              </td> -->
              <td class=" "><?php echo date('m-d-Y',strtotime($singleRecord['createdDate'])); ?></td>
			        <td><a href="javascript:ChangeStatus('<?php echo $singleRecord['member_active']==1?$inacttivedLink:$activeLink;?>');"><button class="btn btn-<?php echo $singleRecord['member_active']=='1'?'info':'danger';?> btn-xs" type="button"><?php echo $singleRecord['member_active']==1?'Suspended':'Non Sudpended';?></button></a></td>
			  
			       <td>
				
    					<?php if($singleRecord['futureMember']==1 || $singleRecord['futureMember']==2){ ?>
    					<?php } ?>
    					<a href="javascript:ChangeStatus('<?php echo $singleRecord['futureMember']==1?$addfutureLink:$removefutureLink;?>');"><button class="btn btn-<?php echo $singleRecord['futureMember']=='1'?'info':'danger';?> btn-xs" type="button"><?php echo $singleRecord['futureMember']==2?'Remove':'Add';?></button></a>
    					
    					
    					
    					<?php //echo $singleRecord['future_member'];?>
			  
			       </td>
			  
			  
			  
			       <td><a href="<?php echo base_url('member/send_url/'.$singleRecord['memberId'])?>"><button class="btn btn-info btn-xs" type="button"> Active Url <?php //echo $singleRecord['id']; ?></button></a></td>
    			   <td>
    			   <?php if($singleRecord['plan_active'] ==1){ echo"Paid ";} else { echo "Unpaid ";} ?>
    			  
    			   </td>
			  <td>	
    			<?php if($singleRecord['plan_active'] ==1){?>
    			  
    			<a href="#"><button class="btn btn-info btn-xs" type="button">
    			  
    			  <?php 
    	
    			  	 $data =$singleRecord['membership_plan_data'];
    				
    				$result_data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '',htmlspecialchars_decode($data)), true );
    				//echo "<pre>"; print_r($result_data);echo "</pre>";				
    				echo isset($result_data['plantype'])?$result_data['plantype']:'';
    				
    			  ?>
    			  
    			  </button></a>
    			
    			<?php } ?>
        </td> 
			  <td>
          <a href="<?php echo base_url('member/viewdetails/'.$singleRecord['memberId']) ?>" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
          ||
          <a href="<?php echo base_url('member/gallery/'.$singleRecord['memberId']) ?>" title="View"><i class="fa fa-image" aria-hidden="true"></i></a>
          ||
          <a onclick="return confirm('are you sure wan to delete');" href="<?= base_url('member/delete/'.$singleRecord['memberId'])?>" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
        </td> 
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
