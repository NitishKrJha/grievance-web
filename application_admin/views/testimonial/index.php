<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">  <div class="x_panel">    <div class="x_title">      <h2><?php echo $module;?> </h2>      <div class="clearfix"></div>    </div>    <div class="x_content">      <div>        <ul class="nav navbar-right panel_toolbox">          <li style="width:50px;">&nbsp;          </li>          <li><a title="Add Help Center" href="<?php echo $add_link; ?>"><i class="fa fa-plus"></i></a>          </li>        </ul>      </div>      <div class="clearfix"></div>      <div class="table-responsive">        <table class="table table-striped jambo_table bulk_action">          <thead>            <tr class="headings">			  <th class="column-title">SL </th>              <th class="column-title">Question</th>              <th class="column-title">Status</th>              <th class="column-title no-link last"><span class="nobr">Action</span>              </th>            </tr>          </thead>          <tbody>          <?php if(!empty($recordset)){ $i=2; ?>            <?php $i=1;			foreach($recordset as $singleRecord){               $ediLink = str_replace('{{ID}}', $singleRecord['testimonial_id'], $edit_link);              $activeLink = str_replace('{{ID}}',$singleRecord['testimonial_id'],$activated_link);			  $inacttivedLink = str_replace('{{ID}}',$singleRecord['testimonial_id'],$inacttived_Link);			  $deleteLink = str_replace("{{ID}}",$singleRecord['testimonial_id'],$delete_link);            ?>            <tr class="<?php echo $i%2==0?'even':'odd'; ?> pointer">			  <td class=" "><?php echo $i+$startRecord; ?></td>             <td class=" "><?php echo $singleRecord['fullname']; ?></td>			 <!--<td class=" "><?php echo $singleRecord['address']; ?></td>-->             <td><a href="javascript:ChangeStatus('<?php echo $singleRecord['is_active']==1?$inacttivedLink:$activeLink;?>');"><button class="btn btn-<?php echo $singleRecord['is_active']=='1'?'info':'danger';?> btn-xs" type="button"><?php echo $singleRecord['is_active']==1?'Active':'InActive';?></button></a></td>              <td class=" last"><a href="<?php echo $ediLink; ?>" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a> <?php if(count($recordset)!=1) {?>| <a href="javascript:Delete('<?php echo $deleteLink;?>');" title=" Delete Content "><i aria-hidden="true" class="fa fa-trash"></i></a><?php } ?></td>            </tr>          <?php $i++; }             }else{ echo '<tr><td colspan="7" align="center">No Record Added Yet.</td></tr>'; }          ?>          </tbody>        </table>        <?php echo $this->pagination->create_links();?>       </div>    </div>  </div></div></div>