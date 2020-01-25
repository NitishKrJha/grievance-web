<?php
//pr($dataset);
?>
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
				   <option value="members.name" <?php if(isset($params['searchField']) && $params['searchField']=='members.name') echo 'selected';?>>Name</option>
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
          <li><a title="add member" href="<?php echo $add_link; ?>"><i class="fa fa-plus"></i></a>
          </li>
        </ul>
      </div>
      <div class="clearfix"></div>
      <div class="table-responsive">
		<table class="table table-condensed" style="border-collapse:collapse;">
		<thead>
		<tr>
			<th>View</th>
			<th>Retailer Name</th>
			<th>Action</th>
		</tr>
		</thead>
		<tbody>
		<?php 
		if(!empty($recordset)){
		$i=1;
		foreach($dataset as $singleData){
			$deleteLink = str_replace('{{ID}}', $singleData['retailer_id'], $delete_link);
		?>
		<tr>
			<td data-toggle="collapse" data-target="#demo<?php echo $i;?>" class="accordion-toggle"><button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open"></span></button></td>
			<td><?php echo $singleData['retailer_name'];?></td>
			<td class=" last"><a href="<?php echo $deleteLink; ?>" title="Delete" onclick="return confirm('Are you sure?')"><i class="fa fa-times" aria-hidden="true"></i></a></td>
			
		</tr>
		<tr>
			<td colspan="12" class="hiddenRow">
			<div class="accordian-body collapse" id="demo<?php echo $i;?>"> 
			  <table class="table table-striped">
				  <thead>
					<tr>
						<th>Start Range</th>
						<th>End Range</th>
						<th>Price </th>
					</tr>
				  </thead>
				<tbody>
				<?php foreach($singleData['price_record'] as $priceData){ ?>
				<tr>
					<td><?php echo $priceData['starting_range'];?></td>
					<td><?php echo $priceData['ending_range'];?></td>
					<td><?php echo $priceData['price'];?></td>
				</tr>
				<?php } ?>
				</tbody>
				</table>
			 </div> 
			</td>
		</tr>
		<?php $i++; }
			}else{ echo '<tr><td colspan="7" align="center">No Record Found.</td></tr>'; }
        ?>
		</tbody>
		</table>
        <?php echo $this->pagination->create_links();?> 
      </div>
    </div>
  </div>
</div>
</div>