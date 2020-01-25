// JavaScript Document
window.addEvent('domready', function()
		{
    	new FormCheck('formedit',{
			display : {
						errorsLocation : 1,
						indicateErrors : 1,
						flashTips : true,
						fadeDuration : 500
					}
	});
});

function getAjaxColor(pid)
{
	if(pid){
	var req = new Request({
	method: 'get',
	url: hostname + 'ajax/getColorbyPid/'+pid,
	data: { 'do' : '1' },
	onSuccess: function(response) {  
	var i, x;
	var ColorInfo = response.split("^");
	x = document.formedit.color_id.options.length;
	for(i=0; i<x;i++)
	{
		document.formedit.color_id.options[0] = null;
	}
	var option = new Option();
	option.value='';
	option.text='Select Product Color';
	document.formedit.color_id.options[0]=option;
	for(i=1; i<ColorInfo.length; i++)
		{
				arrColor = ColorInfo[i].split("##");
				var option = new Option();
				option.value=arrColor[0];
				option.text=arrColor[1];
				document.formedit.color_id.options[document.formedit.color_id.options.length]=option;
		}	
	 },
	onFailure: function(){ alert('Sorry! some error occured while sending request.\nPlease try again after some time.') ;}
	}).send();
	}else{
		document.formedit.color_id.value='';
		document.formedit.sku.value='';
	}
}
function getAjaxSku(colorid)
{
	var pid = document.formedit.product_id.value;
	if(colorid){
	var req = new Request({
	method: 'get',
	url: hostname + 'ajax/getSkubyPidColor/'+pid+'/'+colorid,
	data: { 'do' : '1' },
	onSuccess: function(response) {
		document.formedit.sku.value=response;
	},
	onFailure: function(){ alert('Sorry! some error occured while sending request.\nPlease try again after some time.') ;}
	}).send();
	}else{
		document.formedit.sku.value='';
	}
}
function getAjaxWarehouseNumber(loc)
{
	if(loc){
	var req = new Request({
	method: 'get',
	url: hostname + 'ajax/getWarehousebyLocation/'+loc,
	data: { 'do' : '1' },
	onSuccess: function(response) {  
	var i, x;
	var WHInfo = response.split("^");
	x = document.formedit.warehouse_number.options.length;
	for(i=0; i<x;i++)
	{
		document.formedit.warehouse_number.options[0] = null;
	}
	var option = new Option();
	option.value='';
	option.text='Select Warehouse Number';
	document.formedit.warehouse_number.options[0]=option;
	for(i=1; i<WHInfo.length; i++)
		{
				var option = new Option();
				option.value=WHInfo[i];
				option.text=WHInfo[i];
				document.formedit.warehouse_number.options[document.formedit.warehouse_number.options.length]=option;
		}	
	 },
	onFailure: function(){ alert('Sorry! some error occured while sending request.\nPlease try again after some time.') ;}
	}).send();
	}else{
		document.formedit.warehouse_number.value='';
		document.formedit.picking_zone.value='';
		document.formedit.location_level.value='';
		document.formedit.location_masters_id.value='';
	}
}
function getAjaxPickingZone(wh)
{
	var loc = document.formedit.location.value;
	if(wh){
	var req = new Request({
	method: 'get',
	url: hostname + 'ajax/getPickingbyWarehouse/'+loc+'/'+wh,
	data: { 'do' : '1' },
	onSuccess: function(response) {  
	var i, x;
	var PicInfo = response.split("^");
	x = document.formedit.picking_zone.options.length;
	for(i=0; i<x;i++)
	{
		document.formedit.picking_zone.options[0] = null;
	}
	var option = new Option();
	option.value='';
	option.text='Select Picking Zone';
	document.formedit.picking_zone.options[0]=option;
	for(i=1; i<PicInfo.length; i++)
		{
				var option = new Option();
				option.value=PicInfo[i];
				option.text=PicInfo[i];
				document.formedit.picking_zone.options[document.formedit.picking_zone.options.length]=option;
		}	
	 },
	onFailure: function(){ alert('Sorry! some error occured while sending request.\nPlease try again after some time.') ;}
	}).send();
	}else{
		document.formedit.picking_zone.value='';
		document.formedit.location_level.value='';
		document.formedit.location_masters_id.value='';
	}
}
function getAjaxLocationLevel(pic)
{
	var loc = document.formedit.location.value;
	var wh = document.formedit.warehouse_number.value;
	if(pic){
	var req = new Request({
	method: 'get',
	url: hostname + 'ajax/getAjaxLocationLevel/'+loc+'/'+wh+'/'+pic,
	data: { 'do' : '1' },
	onSuccess: function(response) {  
	var i, x;
	var LevelInfo = response.split("^");
	x = document.formedit.location_level.options.length;
	for(i=0; i<x;i++)
	{
		document.formedit.location_level.options[0] = null;
	}
	var option = new Option();
	option.value='';
	option.text='Select Location Level';
	document.formedit.location_level.options[0]=option;
	for(i=1; i<LevelInfo.length; i++)
		{
				var option = new Option();
				option.value=LevelInfo[i];
				option.text=LevelInfo[i];
				document.formedit.location_level.options[document.formedit.location_level.options.length]=option;
		}	
	 },
	onFailure: function(){ alert('Sorry! some error occured while sending request.\nPlease try again after some time.') ;}
	}).send();
	}else{
		document.formedit.location_level.value='';
		document.formedit.location_masters_id.value='';
	}
}

function getAjaxLocationId(level)
{
	var loc = document.formedit.location.value;
	var wh = document.formedit.warehouse_number.value;
	var pic = document.formedit.picking_zone.value;
	if(level){
	var req = new Request({
	method: 'get',
	url: hostname + 'ajax/getAjaxLocationId/'+loc+'/'+wh+'/'+pic+'/'+level,
	data: { 'do' : '1' },
	onSuccess: function(response) {
	document.formedit.location_masters_id.value=response;
	 },
	onFailure: function(){ alert('Sorry! some error occured while sending request.\nPlease try again after some time.') ;}
	}).send();
	}else{
		document.formedit.location_masters_id.value='';
	}
}
