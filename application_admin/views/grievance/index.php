<?php //pr($recordset); ?>
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
                   <option value="member.name" <?php if(isset($params['searchField']) && $params['searchField']=='grievances.id') echo 'selected';?>>Grievance ID</option>
                   <option value="member.email" <?php if(isset($params['searchField']) && $params['searchField']=='grievances.subject') echo 'selected';?>>Topic</option>
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
      <li><a title="Add supervisor" href="<?php echo $add_link; ?>"><i class="fa fa-plus"></i></a>
          </li>
        </ul>
      </div>
      <div class="clearfix"></div>
      <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
          <thead>
            <tr class="headings">
                <th>Sl</th>
                <th>Grievance ID</th>
                <th>Topic</th>
                <th>Department</th>
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
              
            </tr>
          </thead>

          <tbody>
            <?php if(!empty($recordset)){
              $i=1;
              foreach($recordset as $kry=>$val){
                ?>
                <tr>
                  <td><?php echo $i+$startRecord; ?></td>
                  <td><?php echo $val['id']; ?></td>
                  <td><?php echo $val['subject']; ?></td>
                  <td><?php echo $val['department_name']; ?></td>
                  <td><?php echo date('Y-m-d',strtotime($val['created_date'])); ?></td>
                  <td>
                    <?php if($val['status'] == '3'){
                      $status='Rejected';
                      $class="db-done";
                    }else if($val['status'] == '2'){
                      $status='Resolved';
                      $class="db-done";
                    }else if($val['status'] == '1'){
                      $status='Work In Progress';
                      $class="db-not-done";
                    }else{
                      $status='Pending';
                      $class="db-not-done";
                    } ?>
                    <span class="<?php echo $class; ?>"><?php echo $status; ?></span>
                  </td>
                  <td><a href="<?php echo base_url('grievance/detail/'.$val['id']); ?>" class="<?php echo $class; ?>">view more</a>
                  </td>
                </tr>
                <?php
                  $i++;
              }
            }else{
              ?>
              <tr>
                <td colspan="7">No Data Found</td>
              </tr>
              <?php
            }?>
											
          </tbody>
        </table>
        <?php echo $this->pagination->create_links();?>
      </div>
    </div>
  </div>
</div>
</div>
