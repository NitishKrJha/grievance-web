<?php
//pr($recordset);
?>
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
                   <option value="contact_type.title" <?php if(isset($params['searchField']) && $params['searchField']=='contact_type.title') echo 'selected';?>>Title</option>
                  
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
      <!--<div>
        <ul class="nav navbar-right panel_toolbox">
          <li style="width:50px;">&nbsp;
          </li>
         <li><a title="add member" href="<?php echo $add_link; ?>"><i class="fa fa-plus"></i></a>
          </li>
        </ul>
      </div>-->
      <div class="clearfix"></div>
      <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
          <thead>
            <tr class="headings">
				<th class="column-title">#</th>
				<th class="column-title">File to Use</th>
				<th class="column-title">Qty Volume</th>
				<th class="column-title">Discount percentage(%)</th>
				<th class="column-title">Discount Start date</th>
				<th class="column-title">Discount End date</th>
				<th class="column-title">Status</th>
				<th class="column-title no-link last"><span class="nobr">Action</span></th>
            </tr>
          </thead>

          <tbody>
          <?php if(!empty($recordset)){ $i=2;$j=1; ?>
            <?php foreach($recordset as $singleRecord){ 
				$ediLink = str_replace('{{ID}}', $singleRecord['id'], $edit_link);
				$activeLink = str_replace('{{ID}}',$singleRecord['id'],$activated_link);
				$inacttivedLink = str_replace('{{ID}}',$singleRecord['id'],$inacttived_Link);
				$ediLink = str_replace('{{ID}}', $singleRecord['id'], $edit_link);
				$deleteLink = str_replace('{{ID}}', $singleRecord['id'], $delete_link);
            ?>
            <tr class="<?php echo $i%2==0?'even':'odd'; ?> pointer">
              <td class=" "><?php echo $startRecord+$j; ?></td>
			  <td class=" "><?php echo $singleRecord['file_to_use_name']; ?></td>
			  <td class=" "><?php echo $singleRecord['qty']; ?></td>
			  <td class=" "><?php echo $singleRecord['discount_percentage']; ?></td>
			  <td class=" "><?php echo date('m/d/y',strtotime($singleRecord['discount_start_date'])); ?></td>
			  <td class=" "><?php echo date('m/d/y',strtotime($singleRecord['discount_end_date'])); ?></td>
			   <td><a href="javascript:ChangeStatus('<?php echo $singleRecord['is_active']==1?$inacttivedLink:$activeLink;?>');"><button class="btn btn-<?php echo $singleRecord['is_active']=='1'?'info':'danger';?> btn-xs" type="button"><?php echo $singleRecord['is_active']==1?'Active':'InActive';?></button></a></td>
              <td class=" last"><a href="<?php echo $ediLink; ?>" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
            </tr>
          <?php $j++; } 
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