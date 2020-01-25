var config = {
      apiKey: "AIzaSyCZL8Uju5YVehDEa3vsEH3b_AcNjA07uKU",
      authDomain: "mymissingrib-ae1a4.firebaseapp.com",
      databaseURL: "https://mymissingrib-ae1a4.firebaseio.com",
      projectId: "mymissingrib-ae1a4",
      storageBucket: "mymissingrib-ae1a4.appspot.com",
     // messagingSenderId: "377468395279"
    };
    var firebase = firebase.initializeApp(config);
    //console.log(firebase.email);
    var defaultStorage = firebase.storage();

     firebase.auth().signInWithEmailAndPassword(firebaseemail, firebasepassword).then(function(user) {
      // Success 
      console.log(user.uid);
      //Update user info//
      //  firebase.database().ref('users/'+user.uid+'/credentials/').set({
      //   'name': user.displayName,
      //   'parentId': parentid,
      //   'memberId': userId,
      //   'email': user.email,
      //   'profilePicLink' : proPic
      //  // dateCreated: new Date()
      // });
        listUsers();
      }).catch(function(error) {
        // Handle Errors here.
        var errorCode = error.code;
        var errorMessage = error.message;
        // ...
        console.log(errorCode+'||'+errorMessage);
        console.log(firebase);

        if(errorCode == 'auth/user-not-found'){
            // register user//

            firebase.auth().createUserWithEmailAndPassword(firebaseemail, firebasepassword).then(function(user) {
              // [END createwithemail]
              // callSomeFunction(); Optional
              // var user = firebase.auth().currentUser;
              user.updateProfile({
                  displayName: firebaseuser_name //update user name
              }).then(function() {
                  // Update successful.
                   firebase.database().ref('users/'+user.uid+'/credentials/').set({
                     'name': user.displayName,
                     'email': user.email,
                     'profilePicLink' : firebaseproPic,
                     'parentId': firebaseparentid,
			         'memberId': firebaseuserId,
                     'dateCreated': new Date()
                   });
                  listUsers();
              }, function(error) {
                  // An error happened.
              }); }).catch(function(error) {
              // Handle Errors here.
              var errorCode = error.code;
              var errorMessage = error.message;
              console.log(errorCode+'||'+errorMessage);
              // ...
            });
        }
        
      });


    
  firebase.auth().onAuthStateChanged(function(user) {
  if (user) {
    console.log('Details : '+user.displayName);
    
    // User is signed in.
    var displayName = user.displayName;
    var email = user.email;
    var emailVerified = user.emailVerified;
    var photoURL = user.photoURL;
    var isAnonymous = user.isAnonymous;
    var uid = user.uid;
    var providerData = user.providerData;
    window.userid = user.uid;
    window.displayName = displayName;
    console.log('login : '+displayName);
    $.getScript("https://www.mymissingrib.com/public/js/chat.js");
    // ...
  } else {
    // User is signed out.
    // ...
  }
});


  function listUsers(){
    var me = window.userid;
    var userList = firebase.database().ref('users/');
    console.log(userList);
       //userList.orderByChild('credentials/parentId').equalTo(3).on('value', function(structuredUserAll) {
     userList.on('value', function(structuredUserAll) {
            if(structuredUserAll.numChildren() >0){
              $.each(structuredUserAll.val(),function(index,val){
                //alert(index + ":" +window.userid);
                  if(index != window.userid && typeof val.credentials != 'undefined'){
                      var chatWith = "'"+index+"'";
                      var prechatid = '';
                      if(typeof val.conversations !== 'undefined' && me in val.conversations){
                        prechatid = val.conversations[me].location;
                      }
                          //alert($("#h_prechat"+index).length);
                      if($(".h_name"+index).length <= 0){
                          /*if(typeof val.credentials.profilePicLink=='undefined' || val.credentials.profilePicLink==''){
                            val.credentials.profilePicLink = "http://vtdesignz.co/dev/ci/mmr/uploads/profile_pic/1529502271g_male_active.png";
                          }*/
                          //alert( $("#h_name"+index).val());
                          //alert("#h_name"+index);
                          $("#h_name"+val.credentials.memberId).attr('id',"h_name"+index);
                          $(".h_name"+val.credentials.memberId).attr('class',"h_name"+index);
                          $("#h_pic"+val.credentials.memberId).attr('id',"h_pic"+index);

                          $("#h_name"+index).parent().append('<input type="hidden" id="h_prechat'+index+'" value="'+prechatid+'">');
                          $("#h_name"+index).parent().attr('onclick','javascript:chatWith("'+index+'")');
                          $(".h_name"+index).parent().attr('onclick','javascript:chatWith("'+index+'")');
                          $("#h_name"+index).parent().attr('contentid',index);
                        }
                 }

                if($("#h_prechat"+index).val()!=prechatid){
                    $("#h_prechat"+index).val(prechatid);
                    addprechatList(index);
                }
          })
            }
            

      });
     $('.chatShowHidePre').show();
     getPreChatList(window.userid);
  }

  $(document).on('change',".chatFileUpload",function(){
	  	//handleFileSelect($(this));
	  	var chatID = $(this).attr('chatid');
	  	var storage = firebase.storage();
	  	var file = this.files[0];
	  	var storageRef = storage.ref().child('chat_photos');
	    
	    // Get a reference to store file at photos/<FILENAME>.jpg
	    var photoRef = storageRef.child(file.name);
	    // Upload file to Firebase Storage
	    var uploadTask = photoRef.put(file);
	    uploadTask.on('state_changed', null, null, function() {
	      // When the image has successfully uploaded, we get its download URL
	      var downloadUrl = uploadTask.snapshot.downloadURL;
	      // Set the download URL to the message box, so that the user can send it to the database
	      //textInput.value = downloadUrl;
	     // alert(downloadUrl);

	      addconvertation(window.userid,chatID,downloadUrl,'photo');
	    });
	  })

  var myFirebase = new Firebase('https://mymissingrib-ae1a4.firebaseio.com/');
    var usernameInput = document.querySelector('#username');
    var textInput = document.querySelector('#text');
    var postButton = document.querySelector('.fa-paper-plane');


    var starCountRef = firebase.database().ref().child('allconversations');
    var ik=0;
    //$('#chat-not-cnt').text(ik);
    var chatReqList_count=0;
    $(".chatReqList").html('<li>Not recieved any unseen chat message recently</li>')
    //$('#chat-notification-list').hide();
    starCountRef.limitToLast(1).on('child_added', function(snapshot) {
      
      
      // Now simply find the parent and return the name.
      //var ref_name= ref.parent().name();
      
      var newMsgDetails = snapshot.val();
      var ref_name = newMsgDetails.ref_name;
      console.log('New Message '+ref_name);
      if(newMsgDetails.fromID != window.userid && newMsgDetails.toID == window.userid){
        if($(".listli"+newMsgDetails.fromID).length < 1){
          chatReqList_count = (chatReqList_count +1);
          if(chatReqList_count==1){
            $(".chatReqList").html('');
          }
          var newchatReq = '<li class="listli'+newMsgDetails.fromID+'"><span class="userIcn img-circle"><img src="'+newMsgDetails.frompic+'" alt=""><input type="hidden" id="h_prechat'+newMsgDetails.fromID+'" value="'+ref_name+'"><input type="hidden" value="'+newMsgDetails.fromname+'" id="h_name'+newMsgDetails.fromID+'"><input type="hidden" value="'+newMsgDetails.frompic+'" id="h_pic'+newMsgDetails.fromID+'"><span class="onlineActv"></span></span> <span class="textSec"><h3>'+newMsgDetails.fromname+'</h3><p>'+newMsgDetails.content+'</p></span> <span class="count"><a href="javascript:void(0);" onclick="javascript:chatWith(\''+newMsgDetails.fromID+'\');" contentid="'+newMsgDetails.fromID+'">Reply</a></span> </li>';
          $(".chatReqList").append(newchatReq);
          //var newchatReq1='<li><input type="hidden" id="h_prechat'+newMsgDetails.fromID+'" value="'+ref_name+'"><input type="hidden" value="'+newMsgDetails.fromname+'" id="h_name'+newMsgDetails.fromID+'"><input type="hidden" value="'+newMsgDetails.frompic+'" id="h_pic'+newMsgDetails.fromID+'"> <a href="javascript:void(0);" class="listli'+newMsgDetails.fromID+'" onclick="javascript:chatWith(\''+newMsgDetails.fromID+'\');" contentid="'+newMsgDetails.fromID+'"> '+newMsgDetails.fromname+' send a message on chat.</a></li>';
          //$('#chat-notification-list').append(newchatReq1);
          var ccnt=(parseInt($('#chat-not-cnt').text()) + 1);
          //$('#chat-not-cnt').text(ccnt);
          //$('#chat-notification-list').show();
        }else{
          $(".listli"+newMsgDetails.fromID).find(".textSec p").text(newMsgDetails.content);
        }
        if(chatAccess!=1){
          $(".listli"+newMsgDetails.fromID).find(".textSec p").css({ 'color':'transparent','text-shadow':'0 0 5px rgba(0,0,0,0.5)' });
        }
      }
      newMsgDetails.read=1;
      firebase.database().ref().child('allconversations/'+newMsgDetails.allmessageKey).set(newMsgDetails);
    });
    function addconvertation(from,to,message,type){
      //alert('from: '+from+', to: '+to+', Message: '+message+', Type:'+type);
      addfriendList(firebaseparentid,$('#chatbox_'+to).attr('data-id'),from,to);
      var prechatPageId = $("#h_prechat"+to).val();
      //alert(prechatPageId);
      var postData = {
        content: message,
        fromID: from,
        isRead: false,
        timestamp: Math.floor(new Date().getTime()/1000),
        toID: to,
        type: type
      };

      // Get a key for a new Post.
      if(typeof prechatPageId == 'undefined' || prechatPageId==''){
        var newPostKey = firebase.database().ref().child('conversations').push().key;
        var subKey = firebase.database().ref().child('conversations/'+newPostKey).push().key;
        firebase.database().ref().child('conversations/'+newPostKey+'/'+subKey).set(postData);
        firebase.database().ref().child('users/'+from+'/conversations/'+to+'/location/').set(newPostKey);
        firebase.database().ref().child('users/'+to+'/conversations/'+from+'/location/').set(newPostKey);
      }else{
          var subKey = firebase.database().ref().child('conversations/'+prechatPageId).push().key;
          firebase.database().ref().child('conversations/'+prechatPageId+'/'+subKey).set(postData);
      }
      var allPoatKey = firebase.database().ref().child('allconversations').push().key;
      var postData = {
        content: message,
        fromID: from,
        isRead: false,
        timestamp: Math.floor(new Date().getTime()/1000),
        toID: to,
        type: type,
        fromname: firebaseuser_name,
        allmessageKey: allPoatKey,
        frompic: firebaseproPic,
        ref_name: prechatPageId,
        read: 0
      };
      firebase.database().ref().child('allconversations/'+allPoatKey).set(postData);
    }

    function addprechatList(chatuserid){
        $("#chatbox_"+chatuserid+" .chatboxcontent").html('');
        var firebasechatid = $("#h_prechat"+chatuserid).val();
        if(firebasechatid!=''){
        var commentsRef = firebase.database().ref('conversations/'+firebasechatid+'/');
            commentsRef.on('child_added', function(data) {
                var val = data.val();
                if(val.type=='image' || val.type=='photo'){
                    var contentMsg='<a href="'+val.content+'" target="_blank"><img src="'+val.content+'" /></a>';
                }else if(val.type=='location'){
                    var latLong = val.content.split(':');
                    var contentMsg='<a href="http://maps.google.com/?q='+latLong[0]+','+latLong[1]+'" target="_blank"><img src="http://maps.googleapis.com/maps/api/staticmap?center='+latLong[0]+','+latLong[1]+'&markers=color:red|label:C|'+latLong[0]+','+latLong[1]+'&zoom=16&size=700x700&maptype=terrain&key=&sensor=false" /></a>';
                }else{
                var contentMsg=val.content;
                }

                if(val.fromID == window.userid){
                    var fromUser = window.displayName;
                    var html = '<div class="chatboxmessage msgMe"><span class="chatboxmessagecontent" id="right_'+val.timestamp+'">'+contentMsg+'</span></div>';
                    var msgcon = '';
                    msgcon +='<li>';
                    msgcon +='<span class="time"></span>';
                    msgcon +='<div class="text left">';
                    msgcon +=html;
                    msgcon +='</div>';
                    msgcon +='</li>';
                    var valtmsgdatacheck='right_'+val.timestamp;
                }else{
                    var fromUser = $("#h_name"+chatuserid).val();
                    var html = '<div class="chatboxmessage msgOther"><span class="chatboxmessagecontent" id="left_'+val.timestamp+'">'+contentMsg+'</span></div>';
                    var msgcon = '';
                    msgcon +='<li class="rightChrt">';
                    msgcon +='<span class="time"></span>';
                    msgcon +='<div class="text left">';
                    msgcon +=html;
                    msgcon +='</div>';
                    msgcon +='</li>';
                    var valtmsgdatacheck='left_'+val.timestamp;
                }
                if($('#'+valtmsgdatacheck).length == 0){
                  //alert($('#chatbox_'+chatuserid).length);
                  if($('#chatbox_'+chatuserid).length > 0){
                    $("#chatbox_"+chatuserid+" .chatboxcontent").append(msgcon);
                    if(typeof $("#chatbox_"+chatuserid+" .chatboxcontent")[0].scrollHeight !=='undefined'){
                      $("#chatbox_"+chatuserid+" .chatboxcontent").scrollTop($("#chatbox_"+chatuserid+" .chatboxcontent")[0].scrollHeight);
                    }
                  }
                }
                
                
                
            });
        }
    }

    function hitAddprechatList(chatuserid){
        $("#chatbox_"+chatuserid+" .chatboxcontent").html('');
        var firebasechatid = $("#h_prechat"+chatuserid).val();
        if(typeof firebasechatid == 'undefined' || firebasechatid == ''){
         //alert(1);
          var postData = {};
          var newPostKey = firebase.database().ref().child('conversations').push().key;
          var subKey = firebase.database().ref().child('conversations/'+newPostKey).push().key;
          firebase.database().ref().child('conversations/'+newPostKey+'/'+subKey).set(postData);
          firebase.database().ref().child('users/'+window.userid+'/conversations/'+chatuserid+'/location/').set(newPostKey);
          firebase.database().ref().child('users/'+chatuserid+'/conversations/'+userid+'/location/').set(newPostKey);
          firebasechatid = newPostKey;
          $("#h_prechat"+chatuserid).val(firebasechatid);
        }
        if(firebasechatid!=''){
        var commentsRef = firebase.database().ref('conversations/'+firebasechatid+'/');
            commentsRef.on('child_added', function(data) {
                var val = data.val();
                if(val.type=='image' || val.type=='photo'){
                    var contentMsg='<a href="'+val.content+'" target="_blank"><img src="'+val.content+'" /></a>';
                }else if(val.type=='location'){
                    var latLong = val.content.split(':');
                    var contentMsg='<a href="http://maps.google.com/?q='+latLong[0]+','+latLong[1]+'" target="_blank"><img src="http://maps.googleapis.com/maps/api/staticmap?center='+latLong[0]+','+latLong[1]+'&markers=color:red|label:C|'+latLong[0]+','+latLong[1]+'&zoom=16&size=700x700&maptype=terrain&key=&sensor=false" /></a>';
                }else{
                var contentMsg=val.content;
                }

                if(val.fromID == window.userid){
                    var fromUser = window.displayName;
                    var html = '<div class="chatboxmessage msgMe"><span class="chatboxmessagecontent" id="right_'+val.timestamp+'">'+contentMsg+'</span></div>';
                    var msgcon = '';
                    msgcon +='<li>';
                    msgcon +='<span class="time"></span>';
                    msgcon +='<div class="text left">';
                    msgcon +=html;
                    msgcon +='</div>';
                    msgcon +='</li>';
                    var valtmsgdatacheck='right_'+val.timestamp;
                    }else{
                    var fromUser = $("#h_name"+chatuserid).val();
                    var html = '<div class="chatboxmessage msgOther"><span class="chatboxmessagecontent" id="left_'+val.timestamp+'">'+contentMsg+'</span></div>';
                    var msgcon = '';
                    msgcon +='<li class="rightChrt">';
                    msgcon +='<span class="time"></span>';
                    msgcon +='<div class="text left">';
                    msgcon +=html;
                    msgcon +='</div>';
                    msgcon +='</li>';
                    var valtmsgdatacheck='left_'+val.timestamp;
                    }
                if($('#'+valtmsgdatacheck).length == 0){
                  //alert($('#chatbox_'+chatuserid).length);
                  if($('#chatbox_'+chatuserid).length > 0){
                    $("#chatbox_"+chatuserid+" .chatboxcontent").append(msgcon);
                    if($("#chatbox_"+chatuserid+" .chatboxcontent")[0].scrollHeight !='undefined'){
                      $("#chatbox_"+chatuserid+" .chatboxcontent").scrollTop($("#chatbox_"+chatuserid+" .chatboxcontent")[0].scrollHeight);
                    }
                  }
                  
                }    
                // $("#chatbox_"+chatuserid+" .chatboxcontent").append(msgcon);
                // if($("#chatbox_"+chatuserid+" .chatboxcontent")[0].scrollHeight !='undefined'){
                //   $("#chatbox_"+chatuserid+" .chatboxcontent").scrollTop($("#chatbox_"+chatuserid+" .chatboxcontent")[0].scrollHeight);
                // }
                
                
            });
        }
    }

    function getPreChatList(userid){
      //alert(userid);
      // firebase.database().ref().child('allconversations').orderByChild('toID').equalTo(userid).on("value", function(snapshot) {
      //     snapshot.forEach(function(data) {
      //           var userKey = data.key;
      //           var value = data.val();
      //           console.log("1");
      //           console.log(value);
      //           var newchatReq ='';
      //               newchatReq += '<li class="listimc'+value.fromID+'">';
      //               newchatReq +='<span class="userIcn img-circle">';
      //               newchatReq +='<img src="'+value.frompic+'" alt="">';
      //               newchatReq +='</span>';
      //               newchatReq +='<span class="textSec">';
      //               newchatReq +='<h3>'+value.fromname+'</h3>';
      //               newchatReq +='</span>';
      //               newchatReq += '</li>';
      //           var cnt=0;
      //           $(".mycontactlist").html('');    
      //           if(value.fromID != window.userid && value.toID == window.userid){
      //             if($(".listimc"+value.fromID).length < 1){
      //               $(".mycontactlist").append(newchatReq);
      //               var cnt=1;
      //             }
      //           }
      //           if(cnt==0){
      //             $(".mycontactlist").html('<li>No Contact Available</li>');
      //           }    
      //     });
      // });
    }


/*------ Video Chat Req Handeler -------------*/
function chatRequest(to,toImg,toName){ 
  var newPostKey = firebase.database().ref().child('videochatreq').push().key;
  var postData = {
    fromID: firebaseuserId,
    timestamp: Math.floor(new Date().getTime()/1000),
    toID: to,
    toImg: toImg,
    toName: toName,
    fromname: firebaseuser_name,
    key : newPostKey
  };
  firebase.database().ref().child('videochatreq/'+newPostKey).set(postData);
  console.log('New Video Request');
  makeLogOfVideo(firebaseuserId,to,'insert',0);
}
function addChatReqListner(){
  var chatReq = firebase.database().ref().child('videochatreq');
  chatReq.limitToLast(1).on('child_added', function(snapshot) {
    console.log('New Video Request exist');
    var reqDetails = snapshot.val();
    var key = reqDetails.key;
    //console.log('key : '+key);
    if(reqDetails.toID == firebaseuserId){
      var roomname= 'room_member_'+reqDetails.toID+'_'+reqDetails.fromID;
      letsJoinRoom(reqDetails.toID,reqDetails.fromID,roomname);
    }
    if(reqDetails.fromID == firebaseuserId){
      setTimeout(function(){
        //console.log('firebaseconf.js fromID');
        callUser('room_member_'+reqDetails.toID+'_'+reqDetails.fromID,reqDetails.toImg,reqDetails.toName,'member_'+reqDetails.fromID);
      },1000);
    }

    setTimeout(function(){
      chatReq.child(key).remove();
    },1800);
})
}

function addfriendList(from_member='',to_member='',fid="",tid=""){
  if(from_member!='' && to_member!='' && tid!=''){
    if($('#chatbox_'+tid).data('friends') == 0){
      var origin   = window.location.origin;
      if(origin=='http://localhost'){
        var url=origin+"/mmr/page/make_friend";
      }else{
        var url=origin+"/page/make_friend";
      }
      
      $.ajax({
          type:'POST',
          url: url,
          data:{'from_member':from_member,'to_member':to_member,'fid':fid,'tid':tid},
          success:function(msg){ //alert(11);
            var response=$.parseJSON(msg);
            $('#chatbox_'+fid).data('friends',response.status);
          },
          error: function () {
            $('#chatbox_'+fid).data('friends',0);
          }
        });
    }
    return true;
  }else{
    return true;
  }
}

function addfriendListFromVideo(from_member='',to_member='',fid="",tid=""){
  if(from_member!='' && to_member!=''){
    
      var origin   = window.location.origin;
      if(origin=='http://localhost'){
        var url=origin+"/mmr/page/make_friend";
      }else{
        var url=origin+"/page/make_friend";
      }
      
      $.ajax({
          type:'POST',
          url: url,
          data:{'from_member':from_member,'to_member':to_member,'fid':fid,'tid':tid},
          success:function(msg){ //alert(11);
            var response=$.parseJSON(msg);
            $('#chatbox_'+fid).data('friends',response.status);
          },
          error: function () {
            $('#chatbox_'+fid).data('friends',0);
          }
        });
    
    return true;
  }else{
    return true;
  }
}