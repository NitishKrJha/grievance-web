<!--main content start-->
<section id="main-content">
	<section class="wrapper site-min-height">
        <!-- page start-->
        <div class="col-md-10 col-md-offset-1">
            <div class="panel-body">
                <div class="border-head">
                    <h3 style="margin-bottom:15px;">
                        Banner
                        <small>
                            <i class="ace-icon fa fa-angle-double-right"></i>
                            All Listing (<?php echo $total_rows;?>)
                        </small>
                    </h3>
                </div> 
                <div class="form-group">
                        <div class="col-sm-11"></div>
                  	<div class="col-sm-1" style="padding-right:0px;">
                            <a href="<?php echo $reload_link?>" title="Refresh"><i aria-hidden="true" class="fa fa-refresh"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="<?php echo $add_link?>" title="Add Banner"><i aria-hidden="true" class="fa fa-plus"></i></a>
                  	</div>
                 
                </div>
                <br style="clear:both;">
                <div class="form-group block-block">
				
				  	<div class="col-sm-1"><strong>SL</strong></div>
                    <div class="col-sm-2"><strong>Icon</strong></div>
				  	<div class="col-sm-4"><strong><?php echo tableOrdering("Name (EN)","title",$params['sortField'],$params['sortType']); ?></strong></div>
                    
                    <div class="col-sm-1"><strong>Action</strong></div>
				</div>
                <br style="clear:both;">
                <br style="clear:both;">
                <?php
				if($recordset)
				{
					for($i=0; $i<count($recordset); $i++)
					{
						$editLink = str_replace("{{ID}}",$recordset[$i]['id'],$edit_link);
						$deleteLink = str_replace("{{ID}}",$recordset[$i]['id'],$delete_link);
						if($i%2==0) $style_td ='gray-block' ; else $style_td ='blue-block';
				?>
                <div class="form-group <?php echo $style_td;?>">
				
				  	<div class="col-sm-1"><?php echo $i+$startRecord+1; ?></div>
                    <div class="col-sm-2"><img src="<?php echo $recordset[$i]['icon'];?>" width="50" height="50" /></div>
				  	<div class="col-sm-4"><?php echo $recordset[$i]['title'];?></div>
                    <div class="col-sm-1" style="padding-right:0;"><a href="<?php echo $editLink;?>" title=" Edit Content "><i aria-hidden="true" class="fa fa-pencil-square-o"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:Delete('<?php echo $deleteLink;?>');" title=" Delete Content "><i aria-hidden="true" class="fa fa-trash"></i></a></div>
				</div>
                <br style="clear:both;">
				<?php
					}
				}
				else
				{
				?>
				<div class="col-sm-12 blue-block"><center><strong>No Records Found</strong></center></div>
				<?php
				}
				?>
                <div class="col-sm-12 blue-block"><center><?php echo $this->pagination->create_links();?></center></div>
            </div>
        </div>  
        <!-- page end-->
    </section>
</section>
<!--main content end-->