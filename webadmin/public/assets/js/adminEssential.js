// JavaScript Document
function logout(url)
{
	$( "#msg_box_confirm" ).html('Are you sure you want to logout from Admin Panel?');
	$(function() {
		
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
	
		$( "#msg_box_confirm" ).dialog({
			resizable: false,
			width:400,
			modal: true,
			buttons: {
				Ok: function() {
					window.location.href = url;
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});
	});
}

/*
function search_alpha(url)
{
	window.location.href = url;
}
*/
function refreshSerachDesplay()
{
	document.frmSearch.submit();
}
function tableOrdering(sfield,stype)
{
	document.frmSearch.sortType.value  = stype;
	document.frmSearch.sortField.value = sfield;
	document.frmSearch.submit();
}
function do_search(frm)
{
	if(document.frmSearch.searchText.value == ''){
		alert('Please provid any search keyword');
		document.frmSearch.searchText.focus();
		return false;
	}
	else {
		document.frmSearch.submit();
	}
}


function show_all(url)
{
	window.location.href = url;
}

function Delete(url)
{
	if(window.confirm("Are you sure to delete this record ?"))
	{
		window.location.href = url;
	}
}
function Assign_Agent(url)
{
	if(window.confirm("Do you want to assign the member as Agent?"))
	{
		window.location.href = url;
	}
}
/*function ChangeStatus(url,closedAccount)
{
	if(window.confirm("Are you sure to change status of this record ?"))
	{
		window.location.href = url+closedAccount;
	}
}
*/
function SendTrash(url)
{
	if(window.confirm("Are you sure to send this record to Trash ?"))
	{
		window.location.href = url;
	}
}
function RestoreItem(url)
{
	if(window.confirm("Are you sure to restore back this record from Trash ?"))
	{
		window.location.href = url;
	}
}
function ChangeStatus(url)
{
	if(window.confirm("Are you sure to change status of this record ?"))
	{
		window.location.href = url;
	}
}
function ChangeRepeat(url)
{
	if(window.confirm("Are you sure to change repeat status of this record ?"))
	{
		window.location.href = url;
	}
}

function ChangeEmailStatus(url)
{
	if(window.confirm("Are you sure to change email status ?"))
	{
		window.location.href = url;
	}
}

function ChangeAccountType(action_url)
{
	document.form1.action = action_url;
	document.form1.submit();
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  var newwindow = window.open(theURL,winName,features);
  if (window.focus) {newwindow.focus()}
  return false;
}

function popUp(URL) {
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=950,height=700,left =100,top = 100');");
}

function popUpsmall(URL) {
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=750,height=400,left =100,top = 100');");
}

function postit(el){ //check postcode format is valid
 test = el.value; size = test.length
 test = test.toUpperCase(); //Change to uppercase
 while (test.slice(0,1) == " ") //Strip leading spaces
  {test = test.substr(1,size-1);size = test.length
  }
 while(test.slice(size-1,size)== " ") //Strip trailing spaces
  {test = test.substr(0,size-1);size = test.length
  }
 el.value = test; //write back to form field
 if (size < 6 || size > 8){ //Code length rule
  el.errors.push(test + " is not a valid postcode - wrong length");
  return false;
  }
 if (!(isNaN(test.charAt(0)))){ //leftmost character must be alpha character rule
  el.errors.push(test + " is not a valid postcode - cannot start with a number");
  return false;
  }
 if (isNaN(test.charAt(size-3))){ //first character of inward code must be numeric rule
  el.errors.push(test + " is not a valid postcode - alpha character in wrong position");
  return false;
  }
 if (!(isNaN(test.charAt(size-2)))){ //second character of inward code must be alpha rule
  el.errors.push(test + " is not a valid postcode - number in wrong position");
  return false;
  }
 if (!(isNaN(test.charAt(size-1)))){ //third character of inward code must be alpha rule
  el.errors.push(test + " is not a valid postcode - number in wrong position");
  return false;
  }
 if (!(test.charAt(size-4) == " ")){//space in position length-3 rule
  el.errors.push(test + " is not a valid postcode - no space or space in wrong position");
  return false;
   }
 count1 = test.indexOf(" ");count2 = test.lastIndexOf(" ");
 if (count1 != count2){//only one space rule
  el.errors.push(test + " is not a valid postcode - only one space allowed");
  return false;
  }
return true;
}
