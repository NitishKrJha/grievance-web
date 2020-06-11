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
                  <option value="quarters.quarter_no" <?php if(isset($params['searchField']) && $params['searchField']=='quarters.quarter_no') echo 'selected';?>>Quarter No.</option>
                  <option value="qtype.name" <?php if(isset($params['searchField']) && $params['searchField']=='qtype.name') echo 'selected';?>>Quarter Type</option>
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
      <li><a href="<?php echo $add_link; ?>"><button class="btn btn-info"><i class="fa fa-plus"></i> Add</button></a>
          </li>
        </ul>
      </div>
      <div class="clearfix"></div>
      <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
          <thead>
            <tr class="headings">
              <th class="column-title">SL</th>
              <th class="column-title">Quarter No.</th>
              <th class="column-title">Quarter Type</th>
              <th class="column-title">Full Address</th>
              <th class="column-title">Created</th>
              <th class="column-title">Status</th>
              <th class="column-title">Action</th>
              </th>
            </tr>
          </thead>

          <tbody>
          <?php if(!empty($recordset)){ $i=2; ?>
            <?php $i=1; foreach($recordset as $singleRecord){
              $ediLink = str_replace('{{ID}}', $singleRecord['id'], $edit_link);
              $activeLink = str_replace('{{ID}}',$singleRecord['id'],$activated_link);
			        $inacttivedLink = str_replace('{{ID}}',$singleRecord['id'],$inacttived_Link);
            ?>
            <tr class="<?php echo $i%2==0?'even':'odd'; ?> pointer">
			        <td class=" "><?php echo $i+$startRecord; ?></td>
			        <td class=" "><?php echo $singleRecord['quarter_no']; ?></td>
              <td class=" "><?php echo $singleRecord['quarter_type']; ?></td>
              <td class=" "><?php echo $singleRecord['full_address']; ?></td>
              <td class=" "><?php echo date('m-d-Y',strtotime($singleRecord['created_date'])); ?></td>
              <td><a href="javascript:ChangeStatus('<?php echo $singleRecord['is_active']==1?$inacttivedLink:$activeLink;?>');"><button class="btn btn-<?php echo $singleRecord['is_active']=='1'?'info':'danger';?> btn-xs" type="button"><?php echo $singleRecord['is_active']==1?'Active':'InActive';?></button></a></td>
              <td class=" last"><a href="<?php echo $ediLink; ?>" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a> ||  <a href="javascript:void(0)" data-url="<?php echo base_url('quarter/delete/'.$singleRecord['id']) ?>" class="delData" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
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
<script>
  $(document).on('click','.delData',function(){
    var $this=$(this);
    var url = $this.data('url');
    if(window.confirm("Are you sure want to delete this record?")){
      window.location.href=url;
    }
  })
</script>