<?php //pr($recordset); ?>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2><?php echo $module;?> </h2>
      <div class="clearfix"></div>
    </div>

    <div class="x_content">
         
      <div>
        <ul class="nav navbar-right panel_toolbox">
          <li style="width:50px;">&nbsp;
          </li>
      
        </ul>
      </div>
      <div class="clearfix"></div>
      <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
          <thead>
            <tr class="headings">
              <th class="column-title">SL</th>
              <th class="column-title">Name</th>
             
              <th class="column-title">Price</th>             
              <th class="column-title">Minute</th>
              <th class="column-title">Tips Read</th>
              <th class="column-title">Message</th>
              <th class="column-title">Date</th>
              <th class="column-title">Action</th>
              </th>
            </tr>
          </thead>

          <tbody>
          <?php if(!empty($recordset)){ $i=2; ?>
            <?php $i=1; foreach($recordset as $singleRecord){
              $ediLink = str_replace('{{ID}}', $singleRecord['plan_id'], $edit_link);
              $activeLink = str_replace('{{ID}}',$singleRecord['plan_id'],$activated_link);
			        $inacttivedLink = str_replace('{{ID}}',$singleRecord['plan_id'],$inacttived_Link);
            ?>
            <tr class="<?php echo $i%2==0?'even':'odd'; ?> pointer">
			        <td class=" "><?php echo $i+$startRecord; ?></td>
			        <td class=" "><?php echo $singleRecord['plantype']; ?></td>
              <td class=" "><?php echo $singleRecord['price']; ?></td>
			  
			 
              <td class=" "><?php echo $singleRecord['minute']; ?></td>
              <td class=" "><?php echo $singleRecord['tips_reads']; ?></td>
              <td class=" "><?php echo $singleRecord['messaging']; ?></td>
              <td class=" "><?php echo date('m-d-Y',strtotime($singleRecord['date_modified'])); ?></td>
             
              <td class=" last"><a href="<?php echo $ediLink; ?>" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
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
