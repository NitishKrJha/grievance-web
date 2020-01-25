/*

Copyright (c) 2009 Anant Garg (anantgarg.com | inscripts.com)

This script may be used for non-commercial purposes only. For any
commercial purposes, please contact the author at 
anant.garg@inscripts.com

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.

*/
var windowFocus = true;
var username;
var chatHeartbeatCount = 0;
var minChatHeartbeat = 1000;
var maxChatHeartbeat = 33000;
var chatHeartbeatTime = minChatHeartbeat;
var originalTitle;
var blinkOrder = 0;
var hosturl = window.location.origin;

var chatboxFocus = new Array();
var newMessages = new Array();
var newMessagesWin = new Array();
var chatBoxes = new Array();
window.askToPayment = 0;

$(document).ready(function(){
	//$('.chatShowHidePre').hide();
	originalTitle = document.title;
	startChatSession();

	$([window, document]).blur(function(){
		windowFocus = false;
	}).focus(function(){
		windowFocus = true;
		document.title = originalTitle;
	});
});

function restructureChatBoxes() {
	align = 0;
	for (x in chatBoxes) {
		chatboxtitle = chatBoxes[x];

		if ($("#chatbox_"+chatboxtitle).css('display') != 'none') {
			if (align == 0) {
				$("#chatbox_"+chatboxtitle).css('right', '20px');
			} else {
				width = (align)*(225+7)+20;
				$("#chatbox_"+chatboxtitle).css('right', width+'px');
			}
			align++;
		}
	}
}

function chatWith(chatuser) {
	if($(window).width() >= 1200){
		$max_len=4;
	}else if($(window).width() < 1200 && $(window).width() >= 800){
		$max_len=2;
	}else{
		$max_len=0;
	}
	//alert(1);
	//$("#closeRight2").trigger('click');
	//alert($('#chatAppend > div').length);
	if($('#chatbox_'+chatuser).length > 0){
		$('#chatbox_'+chatuser).remove();
	}
	if($('#chatAppend > div').length > $max_len){
		$('#chatAppend').find('div').first().remove();
	}
	// var chatnotcnt=parseInt($('#chat-not-cnt').text());
	// if(chatnotcnt > 0){
	// 	$('.list'+chatuser).parent().remove();
	// 	chatnotcnt = (chatnotcnt - 1);
	// 	//$('#chat-not-cnt').text(chatnotcnt);
	// }
	createChatBox(chatuser);
	$("#chatbox_"+chatuser+" .chatboxtextarea").focus();
	if($(".listli"+chatuser).length > 0 && page!='dashboard'){
		var prt=$(".listli"+chatuser).parent().parent();
		//$(".listli"+chatuser).parent().remove();
		$(".listli"+chatuser).parent().hide();
		
	}

	if(parseInt(chatnotcnt) <= 0){
		$('#chat-notification-list').hide();
	}

}

function emojiInit(){
	window.emojiPicker = new EmojiPicker({
      emojiable_selector: '[data-emojiable=true]',
      assetsPath: 'https://www.mymissingrib.com/public/img/',
      popupButtonClasses: 'fa fa-smile-o',
      norealTime: false
    });
    // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
    // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
    // It can be called as many times as necessary; previously converted input fields will not be converted again
    window.emojiPicker.discover();
}

function createChatBox(chatboxtitle,minimizeChatBox) {
	var username1 = $("#h_name"+chatboxtitle).val();
	var userpic = $("#h_pic"+chatboxtitle).val();
	//alert(username1+"--"+chatboxtitle);
	if(typeof username1!=='undefined'){
		//alert(username1+"---"+userpic);
		var chatData=$('#chatWindowData').html();
		chatData=chatData.replace("#chatWithName#", username1);
		chatData=chatData.replace("#identifier#", $("#h_name"+chatboxtitle).parent().attr('identifier'));
		chatData=chatData.replace("#imgsrc#", userpic);
		
		var htmladd='';
		htmladd +='<input type="text" class="form-control messageToSend chatboxtextarea" data-emojiable="true" placeholder="Type your message..." data-chatID="'+chatboxtitle+'" id="chatboxtitle_'+chatboxtitle+'">';
		htmladd +='<div style="display:none;" useridentifier="" class="useridentifier"></div>';
		htmladd +='<a href="javascript:void(0);" id="sendchat_'+chatboxtitle+'" onclick="javascript:return sendChat(event,this,\''+chatboxtitle+'\');"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>';
		chatData=chatData.replace("#addLBTN#", htmladd);

		chatData=chatData.replace("#closeBTNs#", '<a href="javascript:void(0);" class="hideParent" onclick="javascript:return closeChatBox(\''+chatboxtitle+'\');"><i class="fa fa-times" aria-hidden="true"></i></a>');
		chatData=chatData.replace("#id#", chatboxtitle);
		if(chatAccess=='1'){
			chatData=chatData.replace("#chatboxcontentDataAccess#", '<ul class="inner-chat-section inner-content chatboxcontent"></ul>');
		}else{
			chatData=chatData.replace("#chatboxcontentDataAccess#", '<img src="https://www.mymissingrib.com/public/images/blur-image.jpg"></img>');
		}
		
		$('#chatAppend').append(chatData);
		
		chatBoxeslength = 0;
		for (x in chatBoxes) {
			if ($("#chatbox_"+chatBoxes[x]).css('display') != 'none') {
				chatBoxeslength++;
			}
		}
		chatBoxes.push(chatboxtitle);
		if (minimizeChatBox == 1) {
			minimizedChatBoxes = new Array();

			if ($.cookie('chatbox_minimized')) {
				minimizedChatBoxes = $.cookie('chatbox_minimized').split(/\|/);
			}
			minimize = 0;
			for (j=0;j<minimizedChatBoxes.length;j++) {
				if (minimizedChatBoxes[j] == chatboxtitle) {
					minimize = 1;
				}
			}

			if (minimize == 1) {
				$('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','none');
				$('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','none');
			}
		}

		chatboxFocus[chatboxtitle] = false;

		$("#chatbox_"+chatboxtitle+" .chatboxtextarea").blur(function(){
			chatboxFocus[chatboxtitle] = false;
			$("#chatbox_"+chatboxtitle+" .chatboxtextarea").removeClass('chatboxtextareaselected');
		}).focus(function(){
			chatboxFocus[chatboxtitle] = true;
			newMessages[chatboxtitle] = false;
			$('#chatbox_'+chatboxtitle+' .chatboxhead').removeClass('chatboxblink');
			$("#chatbox_"+chatboxtitle+" .chatboxtextarea").addClass('chatboxtextareaselected');
		});

		$("#chatbox_"+chatboxtitle).click(function() {
			if ($('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display') != 'none') {
				$("#chatbox_"+chatboxtitle+" .chatboxtextarea").focus();
			}
		});
		
		$("#chatbox_"+chatboxtitle).show();
		hitAddprechatList(chatboxtitle);
		emojiInit();
	}else{
		alert(username1+"-1-2-"+userpic);
	}
	

}

function createChatBox_bckp(chatboxtitle,minimizeChatBox) {
	var username1 = $("#h_name"+chatboxtitle).val();
	if ($("#chatbox_"+chatboxtitle).length > 0) {
		if ($("#chatbox_"+chatboxtitle).css('display') == 'none') {
			$("#chatbox_"+chatboxtitle).css('display','block');
			restructureChatBoxes();
		}
		$("#chatbox_"+chatboxtitle+" .chatboxtextarea").focus();
		return;
	}
	$(" <div />" ).attr("id","chatbox_"+chatboxtitle)
	.addClass("chatbox")
	.html('<div class="chatboxhead"><div class="chatboxtitle"><a href="javascript:void(0)" style="text-decoration:none;color: #fff;" onclick="javascript:toggleChatBoxGrowth(\''+chatboxtitle+'\')">'+username1+'</a></div><div class="chatboxoptions"><a href="javascript:void(0)" onclick="javascript:toggleChatBoxGrowth(\''+chatboxtitle+'\')"><i class="fa fa-minus-circle" aria-hidden="true"></i></a>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="javascript:closeChatBox(\''+chatboxtitle+'\')"><i class="fa fa-times-circle" aria-hidden="true"></i></a></div><br clear="all"/></div><div class="chatboxcontent"></div><div class="chatboxinput"><div class="image-upload"><label for="file-input"><i class="fa fa-paperclip attachItem" aria-hidden="true"></i></label><input class="chatFileUpload" chatid='+chatboxtitle+' type="file"/></div><textarea class="chatboxtextarea" onkeydown="javascript:return checkChatBoxInputKey(event,this,\''+chatboxtitle+'\');"></textarea><a href="javascript: void(0);" onClick="javascript:return sendChat(event,this,\''+chatboxtitle+'\');" style="font-size: 19px;position: absolute;top: 26px;right: 9px;"><i class="fa fa-paper-plane" aria-hidden="true"></i></a></div>')
	.appendTo($( "body" ));
			   
	$("#chatbox_"+chatboxtitle).css('bottom', '0px');
	
	chatBoxeslength = 0;

	for (x in chatBoxes) {
		if ($("#chatbox_"+chatBoxes[x]).css('display') != 'none') {
			chatBoxeslength++;
		}
	}

	if (chatBoxeslength == 0) {
		$("#chatbox_"+chatboxtitle).css('right', '20px');
	} else {
		width = (chatBoxeslength)*(225+7)+20;
		$("#chatbox_"+chatboxtitle).css('right', width+'px');
	}
	
	chatBoxes.push(chatboxtitle);

	if (minimizeChatBox == 1) {
		minimizedChatBoxes = new Array();

		if ($.cookie('chatbox_minimized')) {
			minimizedChatBoxes = $.cookie('chatbox_minimized').split(/\|/);
		}
		minimize = 0;
		for (j=0;j<minimizedChatBoxes.length;j++) {
			if (minimizedChatBoxes[j] == chatboxtitle) {
				minimize = 1;
			}
		}

		if (minimize == 1) {
			$('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','none');
			$('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','none');
		}
	}

	chatboxFocus[chatboxtitle] = false;

	$("#chatbox_"+chatboxtitle+" .chatboxtextarea").blur(function(){
		chatboxFocus[chatboxtitle] = false;
		$("#chatbox_"+chatboxtitle+" .chatboxtextarea").removeClass('chatboxtextareaselected');
	}).focus(function(){
		chatboxFocus[chatboxtitle] = true;
		newMessages[chatboxtitle] = false;
		$('#chatbox_'+chatboxtitle+' .chatboxhead').removeClass('chatboxblink');
		$("#chatbox_"+chatboxtitle+" .chatboxtextarea").addClass('chatboxtextareaselected');
	});

	$("#chatbox_"+chatboxtitle).click(function() {
		if ($('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display') != 'none') {
			$("#chatbox_"+chatboxtitle+" .chatboxtextarea").focus();
		}
	});

	$("#chatbox_"+chatboxtitle).show();
	addprechatList(chatboxtitle);

}


function chatHeartbeat(){

	var itemsfound = 0;
	
	if (windowFocus == false) {
 
		var blinkNumber = 0;
		var titleChanged = 0;
		for (x in newMessagesWin) {
			if (newMessagesWin[x] == true) {
				++blinkNumber;
				if (blinkNumber >= blinkOrder) {
					$.ajax({
					 url: hosturl+"/chat.php?action=GetName",
					 type : 'POST',
					 data : 'value=' + x,
					 success : function(data, textStatus, jqXHR){
						  var Uname = data;
					document.title = Uname+' says...';
					 },
					});
					//document.title = x+' says...';
					titleChanged = 1;
					break;	
				}
			}
		}
		
		if (titleChanged == 0) {
			document.title = originalTitle;
			blinkOrder = 0;
		} else {
			++blinkOrder;
		}

	} else {
		for (x in newMessagesWin) {
			newMessagesWin[x] = false;
		}
	}

	for (x in newMessages) {
		if (newMessages[x] == true) {
			if (chatboxFocus[x] == false) {
				//FIXME: add toggle all or none policy, otherwise it looks funny
				$('#chatbox_'+x+' .chatboxhead').toggleClass('chatboxblink');
			}
		}
	}
	
	$.ajax({
	  url: hosturl+"/chat.php?action=chatheartbeat",
	  cache: false,
	  dataType: "json",
	  success: function(data) {

		$.each(data.items, function(i,item){
			if (item)	{ // fix strange ie bug

				chatboxtitle = item.f;

				if ($("#chatbox_"+chatboxtitle).length <= 0) {
					//createChatBox(chatboxtitle);
				}
				if ($("#chatbox_"+chatboxtitle).css('display') == 'none') {
					$("#chatbox_"+chatboxtitle).css('display','block');
					//restructureChatBoxes();
				}
				
				if (item.s == 1) {
					item.f = username;
				}

				if (item.s == 2) {
					var msgt='<div class="chatboxmessage"><span class="chatboxinfo">'+item.m+'</span></div>';
					var msgcon = '';
					msgcon +='<li>';
					msgcon +='<span class="time"></span>';
					msgcon +='<div class="text left">';
					msgcon +=msgt;
					msgcon +='</div>';
					msgcon +='</li>';
					$("#chatbox_"+chatboxtitle+" .chatboxcontent").append(msgcon);
				} else {
					newMessages[chatboxtitle] = true;
					newMessagesWin[chatboxtitle] = true;
					
					//doubt
					$.ajax({
					 url:  hosturl+"/chat.php?action=GetName",
					 type : 'POST',
					 data : 'value=' + item.f,
					 success : function(data, textStatus, jqXHR){
						    var Uname = data;
						    var msgt='<div class="chatboxmessage"><span class="chatboxmessagefrom">'+Uname+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+item.m+'</span></div>';
					 	    var msgcon = '';
							msgcon +='<li>';
							msgcon +='<span class="time"></span>';
							msgcon +='<div class="text left">';
							msgcon +=msgt;
							msgcon +='</div>';
							msgcon +='</li>';
							$("#chatbox_"+chatboxtitle+" .chatboxcontent").append(msgcon);
					 },
					});
					//$("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+item.f+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+item.m+'</span></div>');
				}

				$("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
				itemsfound += 1;
			}
		});

		chatHeartbeatCount++;

		if (itemsfound > 0) {
			chatHeartbeatTime = minChatHeartbeat;
			chatHeartbeatCount = 1;
		} else if (chatHeartbeatCount >= 10) {
			chatHeartbeatTime *= 2;
			chatHeartbeatCount = 1;
			if (chatHeartbeatTime > maxChatHeartbeat) {
				chatHeartbeatTime = maxChatHeartbeat;
			}
		}
		
		setTimeout('chatHeartbeat();',chatHeartbeatTime);
	}});
}

function closeChatBox(chatboxtitle) {

	$('#chatbox_'+chatboxtitle).css('display','none');
	restructureChatBoxes();

	$.post(hosturl+"/chat.php?action=closechat", { chatbox: chatboxtitle} , function(data){	
	});
	$('#chatbox_'+chatboxtitle).remove();
}

function toggleChatBoxGrowth(chatboxtitle) {
	if ($('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display') == 'none') {  
		
		var minimizedChatBoxes = new Array();
		
		if ($.cookie('chatbox_minimized')) {
			minimizedChatBoxes = $.cookie('chatbox_minimized').split(/\|/);
		}

		var newCookie = '';

		for (i=0;i<minimizedChatBoxes.length;i++) {
			if (minimizedChatBoxes[i] != chatboxtitle) {
				newCookie += chatboxtitle+'|';
			}
		}

		newCookie = newCookie.slice(0, -1)


		$.cookie('chatbox_minimized', newCookie);
		$('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','block');
		$('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','block');
		$("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
	} else {
		
		var newCookie = chatboxtitle;

		if ($.cookie('chatbox_minimized')) {
			newCookie += '|'+$.cookie('chatbox_minimized');
		}


		$.cookie('chatbox_minimized',newCookie);
		$('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','none');
		$('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','none');
	}
	
}

$(document).on('keypress','.chatboxtextarea',function(event){
	//alert(event.keyCode);
	var chatboxtextarea=$(this);
	var chatboxtitle=chatboxtextarea.parent().find('input').data('chatid');
	if(event.keyCode == 13 && event.shiftKey == 0) {
		//alert(chatboxtitle);
		//chatboxtextarea.trigger('click');
		//chatboxtextarea.focus();
		message = $('#chatboxtitle_'+chatboxtitle).val();
		message = message.replace(/^\s+|\s+$/g,"");
		//alert(message);
		
		$('#chatboxtitle_'+chatboxtitle).val('');
		$('#chatboxtitle_'+chatboxtitle).focus();
		$('#chatboxtitle_'+chatboxtitle).css('height','44px');
		chatboxtextarea.html('');
		if (message != '') {
			message = message.replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\"/g,"&quot;");
				if(chatAccess==0){
					if(confirm("Do you want to purchase membership plan becuase text will not appear without having plan")){
						window.location.href='https://www.mymissingrib.com/member/membershipplan';
					}
					window.askToPayment=1;
				}
				addconvertation(window.userid,chatboxtitle,message,'text');
		
		}
		chatHeartbeatTime = minChatHeartbeat;
		chatHeartbeatCount = 1;

		return false;
	}

	var adjustedHeight = chatboxtextarea.clientHeight;
	var maxHeight = 94;

	if (maxHeight > adjustedHeight) {
		adjustedHeight = Math.max(chatboxtextarea.scrollHeight, adjustedHeight);
		if (maxHeight)
			adjustedHeight = Math.min(maxHeight, adjustedHeight);
		if (adjustedHeight > chatboxtextarea.clientHeight)
			chatboxtextarea.parent().find('input').css('height',adjustedHeight+8 +'px');
	} else {
		chatboxtextarea.parent().find('input').css('overflow','auto');
	}
});

function checkChatBoxInputKey(event,chatboxtextarea,chatboxtitle) {
	if(event.keyCode == 13 || event.shiftKey == 0)  {
		message = $(chatboxtextarea).val();
		message = message.replace(/^\s+|\s+$/g,"");

		$(chatboxtextarea).val('');
		$(chatboxtextarea).focus();
		$(chatboxtextarea).css('height','44px');
		if (message != '') {
			message = message.replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\"/g,"&quot;");
		
				addconvertation(window.userid,chatboxtitle,message,'text');
		
		}
		chatHeartbeatTime = minChatHeartbeat;
		chatHeartbeatCount = 1;

		return false;
	}

	var adjustedHeight = chatboxtextarea.clientHeight;
	var maxHeight = 94;

	if (maxHeight > adjustedHeight) {
		adjustedHeight = Math.max(chatboxtextarea.scrollHeight, adjustedHeight);
		if (maxHeight)
			adjustedHeight = Math.min(maxHeight, adjustedHeight);
		if (adjustedHeight > chatboxtextarea.clientHeight)
			$(chatboxtextarea).css('height',adjustedHeight+8 +'px');
	} else {
		$(chatboxtextarea).css('overflow','auto');
	}
	 
}

function sendChat(event,chatboxtextarea,chatboxtitle) {
	//var event;
	event.keyCode=13;
	event.shiftKey = 0;
	chatboxtextarea = $(chatboxtextarea).parent().find('input');
	//alert(.find('textarea'));

	checkChatBoxInputKey(event,chatboxtextarea,chatboxtitle);
	$('.emoji-wysiwyg-editor').html('');
}

function startChatSession(){  
	$.ajax({
	  url: hosturl+"/chat.php?action=startchatsession",
	  cache: false,
	  dataType: "json",
	  success: function(data) {
 
		username = data.username;

		$.each(data.items, function(i,item){
			if (item)	{ // fix strange ie bug

				chatboxtitle = item.f;

				if ($("#chatbox_"+chatboxtitle).length <= 0) {
					createChatBox(chatboxtitle,1);
				}
				
				if (item.s == 1) {
					item.f = username;
				}

				if (item.s == 2) {
					var msgt='<div class="chatboxmessage"><span class="chatboxinfo">'+item.m+'</span></div>';
					var msgcon = '';
					msgcon +='<li>';
					msgcon +='<span class="time"></span>';
					msgcon +='<div class="text left">';
					msgcon +=msgt;
					msgcon +='</div>';
					msgcon +='</li>';
					$("#chatbox_"+chatboxtitle+" .chatboxcontent").append(msgcon);
					
				} else {
					$.ajax({
					 url:  hosturl+"/chat.php?action=GetName",
					 type : 'POST',
					 data : 'value=' + item.f,
					 success : function(data, textStatus, jqXHR){
						  var Uname = data;

					varmsgt='<div class="chatboxmessage"><span class="chatboxmessagefrom">'+Uname+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+item.m+'</span></div>';
					var msgcon = '';
					msgcon +='<li>';
					msgcon +='<span class="time"></span>';
					msgcon +='<div class="text left">';
					msgcon +=msgt;
					msgcon +='</div>';
					msgcon +='</li>';
					$("#chatbox_"+chatboxtitle+" .chatboxcontent").append(msgcon);
					 },
					});
					var msgt= '<div class="chatboxmessage"><span class="chatboxmessagefrom">'+item.f+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+item.m+'</span></div>';
					var msgcon = '';
					msgcon +='<li>';
					msgcon +='<span class="time"></span>';
					msgcon +='<div class="text left">';
					msgcon +=msgt;
					msgcon +='</div>';
					msgcon +='</li>';
					$("#chatbox_"+chatboxtitle+" .chatboxcontent").append(msgcon);
				}
			}
		});
		
		for (i=0;i<chatBoxes.length;i++) {
			chatboxtitle = chatBoxes[i];
			$("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
			setTimeout('$("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);', 100); // yet another strange ie bug
		}
	
	setTimeout('chatHeartbeat();',chatHeartbeatTime);
		
	}});
}

/**
 * Cookie plugin
 *
 * Copyright (c) 2006 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */

jQuery.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        options = options || {};
        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        // CAUTION: Needed to parenthesize options.path and options.domain
        // in the following expressions, otherwise they evaluate to undefined
        // in the packed version for some reason...
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};
