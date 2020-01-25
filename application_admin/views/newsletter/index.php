<script>
jQuery(document).ready(function($){
	var dates = $( "#searchFromDate, #searchToDate" ).datepicker({
		dateFormat: "yy-mm-dd",
		showOn: 'both',
		buttonImage: '<?php echo CSS_IMAGES_JS_BASE_URL;?>images/calendar.gif',
		buttonImageOnly: true,
		buttonText: 'Choose',
		defaultDate: "+0w",
		numberOfMonths: 1,
		onSelect: function( selectedDate ) {
			var option = this.id == "searchFromDate" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" );
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});

	jQuery("#frmSearch").validationEngine();

	jQuery("#searchField").change(function()
	{
	  	if(jQuery("#searchString").hasClass("validate[required]"))
		{
			jQuery("#searchString").removeClass("validate[required]");
			jQuery(".searchStringformError").hide();
		}
	});

	jQuery("#search").click(function()
	{
		if(jQuery("#searchField").val()!="")
		{
			jQuery("#searchString").addClass("validate[required]");
			var error=jQuery('#frmSearch').validationEngine('validateField', '#searchString');
			if(jQuery("#searchString").hasClass("validate[required]") && error==true)
			{
				jQuery(".searchStringformError").show();
			}
		 }
	});
	$('#showAll').click(function() {
        $("#searchForm").trigger('reset');
        window.location.href="<?php echo $search_link;?>";
    });
	$('#addData').click(function() {
		var emp_name = $("#employeeName").val();
		var emp_phone = $("#employeePhone").val();
       if(emp_name=='' && emp_phone==''){
		   alert('Please provide data to search.')
		return false;
	   }
    });
});

function refreshSearchOption(val)
{
	if(val=='custom'){
		document.getElementById('custom_range_tr').style.display='';
	}else{
		document.getElementById('searchFromDate').value='';
		document.getElementById('searchToDate').value='';
		document.getElementById('custom_range_tr').style.display='none';
	}
 }
 
function search_alpha(alpha)
{
	document.frmSearch.search_mode.value = "ALPHA";
	document.frmSearch.searchString.value = '';
	document.frmSearch.searchFromDate.value = '';
	document.frmSearch.searchToDate.value = '';
	document.frmSearch.txt_alpha.value = alpha;
	document.frmSearch.submit();
}
</script>
<style type="text/css">
.active_member{
	color:#C1BEBE;
}
.active_member.active{
	color:#65D953;
}
.fa-trash.inactive{
	color:#C1BEBE;
}
</style>
<!--main content start-->
<section id="main-content">
	<section class="wrapper site-min-height">
        <!-- page start-->
        <div class="col-md-13">
            <div class="panel-body">
                <div class="border-head">
                    <h3 style="margin-bottom:15px;">
                        NewsLetter
                        <small>
                            <i class="ace-icon fa fa-angle-double-right"></i>
                            All Listing (<?php echo $total_rows;?>)
                        </small>
                    </h3>
                </div>
				<div class="col-sm-11"></div>
				<div class="col-sm-1" style="padding-right:0px;">
						<a href="<?php echo base_url('newsletter/export_email') ?>" title="Add Banner" style="color: #6DBB4A;font-size: 15px;"><i class="fa fa-file" aria-hidden="true"></i> Export</a>
				</div>
				<!--<div class="panel-body">
                    <form method="post" id="searchForm" action="<?php echo $search_link;?>">
                        <div class="form-group col-md-5">
                            <label for="agentrealname">Employee Name</label>
                            <input type="text" class="form-control" id="employeeName" name="employeeName" value="<?php echo $params['employeeName'];?>">
                        </div>
						<div class="form-group col-md-5">
                            <label for="agentrealname">Employee Phone Number</label>
                            <input type="text" class="form-control" id="employeePhone" name="employeePhone" value="<?php echo $params['employeePhone'];?>">
                        </div>
                        <!--<div class="form-group col-md-2">
                            <label for="agentalanname">To Date</label>
                            <input type="text" class="form-control" id="searchToDate" name="searchToDate" value="<?php echo $params['searchToDate'];?>">
                        </div>-->
                        <!--<div class="col-md-5">
                            <br>	
                            <button  style="background-color:hsl(101, 55%, 56%)" id="addData" class="btn btn-default marg-5">Search</button>
						   <a class="newbtn" href="<?php echo $search_link;?>">Show All</a>
                        </div>
                    </form>
                </div>-->
                <br style="clear:both;">
                <div class="form-group block-block">
				
				  	<div class="col-sm-1"><strong>SL</strong></div>
                    <div class="col-sm-3" style="margin-left: -45px;"><strong>Email</strong></div>
					<div class="col-sm-2" style="margin-left: -45px;"><strong>Status</strong></div>
                    <!--<div class="col-sm-1"><strong>Action</strong></div>-->
				</div>
                <br style="clear:both;">
                <br style="clear:both;">
                <?php
				/* echo '<pre>';
				print_r($recordset);
				exit;     */
				if($recordset)
				{
					for($i=0; $i<count($recordset); $i++)
					{
						$editLink = str_replace("{{ID}}",$recordset[$i]['id'],$edit_link);
						$activatedLink = str_replace("{{ID}}",$recordset[$i]['id'],$activated_link);
						$inacttivedLink = str_replace("{{ID}}",$recordset[$i]['id'],$inacttived_Link);
						$suspendedLink = str_replace("{{ID}}",$recordset[$i]['id'],$suspended_link);
						if($i%2==0) $style_td ='gray-block' ; else $style_td ='blue-block';
				?>
                <div class="form-group <?php echo $style_td;?>">
				
				  	<div class="col-sm-1"><?php echo $i+$startRecord+1; ?></div>
                    <div class="col-sm-3" style="margin-left: -45px;"><?php echo $recordset[$i]['email'];?></div>
					<div class="col-sm-2" style="margin-left: -45px;"><?php echo $recordset[$i]['is_active']=1?'Active':'InActivate';?></div>
                    <!--<div class="col-sm-1" style="padding-right:0;">
						<a href="javascript:void(0)" title=" InActivate Member " class="active_member active"><i class="fa fa-check" aria-hidden="true"></i></a>
					</div>-->
                <br style="clear:both;">
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