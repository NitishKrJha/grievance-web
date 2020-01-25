var activeRoom;
var previewTracks;
var identity;
var roomName;
window.audio='';
window.acceptCall = 0;
localStorage.setItem("connected",0);

function attachTracks(tracks, container) {
    tracks.forEach(function(track) {
        container.appendChild(track.attach());
    });
}

function attachParticipantTracks(participant, container) {
    var tracks = Array.from(participant.tracks.values());
    attachTracks(tracks, container);
}

function detachTracks(tracks) {
    tracks.forEach(function(track) {
        track.detach().forEach(function(detachedElement) {
            detachedElement.remove();
        });
    });
}

function detachParticipantTracks(participant) {
    var tracks = Array.from(participant.tracks.values());
    detachTracks(tracks);
}

function makeid() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < 5; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}

function setHeader(xhr) {
    xhr.setRequestHeader('securityCode', 'Foo');
    xhr.setRequestHeader('passkey', 'Bar');
}

// Check for WebRTC
if (!navigator.webkitGetUserMedia && !navigator.mozGetUserMedia) {
    alert('WebRTC is not available in your browser.');
}

// When we are about to transition away from this page, disconnect
// from the room, if joined.
window.addEventListener('beforeunload', leaveRoomIfJoined);
addChatReqListner(); 
function letsJoinRoom(to,from,roomname){
    var uidentity = window.loginas;
    activeRoom = roomName = roomname;
    $.getJSON(window.host + 'webroot/tokenVideo.php?name=' + uidentity + '&room=' + roomName, function(data) {
        identity = data.identity;
        console.log('.............');
        roomName = data.room;
        if (roomName) {
                         
            console.log("Joining room '" + roomName + "'...");
            //var endpoint = new Twilio.Endpoint(data.token);
            var connectOptions = { name: roomName, logLevel: 'debug' };
            //connectOptions.video = false;
            //connectOptions.audio = false;
            if(data.userExist==0 && localStorage.getItem("connected")!=1){
                Twilio.Video.connect(data.token, {video: { width: 640 }, name: roomName, tracks: [] }).then(roomJoined, function(error) {
                    console.log('Could not connect to Twilio: ' + error.message);
                });
            }else{
                console.log("Already in room identified");
            }
            localStorage.setItem("connected", "1");
        } else {
            alert('Please enter a room name.');
        }
    });
}

// Successfully connected!
function roomJoined(room) {
    activeRoom = room;
    var partnerJoin=0;
    console.log(activeRoom);
    //var localDiv = document.getElementById('local-media');
    console.log("Track Dissa");
    log("Joined as '" + identity + "'");
    // When a participant joins, draw their video on screen
    //setTimeout(function(){
          
        activeRoom.on('participantConnected', function(participant) {
            log("Joining: '" + participant.identity + "'");
            $.getJSON(window.host + 'member/getMemberDetails/' + participant.identity + '/' + roomName, function(userdata) {
                $("#videoChat").modal('show');
                $("#remote-media111").append('<div class="callTimeCounter" style="display:none;"><i class="fa fa-clock-o" style="color: #fff;margin: 5px;"></i>0:0:4</div>').promise().done(function(){
                    $('.callTimeCounter').countimer({
                        autoStart : true,
                        leadingZeros: 2,
                        initHours : 0,
                        initMinutes : 0,
                        initSeconds: 1
                    });
                });
                play_rt();
                //$(".video-popup-leftBx").css({ 'background-image': 'url(' + userdata.picture + ')', 'background-repeat': 'no-repeat', 'background-position': 'center', 'min-height': '300px' });
                $('#imgsrcforvid').attr('src',userdata.picture)
                $("#videoChat111111 .modal-title").html('Incoming video call from ' + userdata.name);
                $('.video_call_name').html('<h4>'+userdata.name+'</h4>');
                $(".acceptCall").show();
                var isOldTitle = true;
                var oldTitle = "My-Missing-Rib";
                var newTitle = 'Incoming video call from ' + userdata.name;
                var interval = null;
                function changeTitle() {
                    document.title = isOldTitle ? oldTitle : newTitle;
                    isOldTitle = !isOldTitle;
                }
                interval = setInterval(changeTitle, 700);

                $(window).focus(function () {
                    clearInterval(interval);
                    $("title").text(oldTitle);
                });
            })
        });
    //},300)
    setTimeout(function(){
        if(window.acceptCall!=1){
            activeRoom.disconnect();
            activeRoom = null;
            location.reload();
        }
    },30000);
}

// document.getElementById('rejectCall').onclick = function() {
//     //alert(1);
//     location.reload();
// }

function play_rt() {
    //console.log("start");
    var source = "https://www.mymissingrib.com/public/skype_remix_2.mp3"
    window.audio = document.createElement("audio");
    //
    var audio=window.audio;
    audio.autoplay = true;
    audio.loop = true;
    //
    audio.load()
    audio.addEventListener("load", function() { 
        audio.play(); 
    }, true);
    audio.src = source;
 }

 function stop_rt() {
    if(window.audio!=''){
        console.log("stop");
        var audio=window.audio;
        audio.pause();
    }
    
 }

$(document).on('click','.rejectCall',function(){
    if(activeRoom){
        activeRoom.disconnect();
        activeRoom = null;
    }
    location.reload();
})
//document.getElementById('acceptCall').onclick = function() {
$(document).on('click','.acceptCall',function(){ 
    //alert("acceptCall");//displayedMode
    window.acceptCall = 1;
    var counterTime = $('.callTimeCounter').countimer('current');
    //$('.callTimeCounter').countimer('stop');
    //console.log(counterTime.displayedMode.unformatted);
    var Video = Twilio.Video;
    $('#videoChat').modal('hide');
    $('#videoChat111111').modal('show');
    $(".video-popup-leftBx").append('<div class="callTimeCounter-black"><i class="fa fa-clock-o" style="color: #fff;margin: 5px;"></i>0:0:4</div>').promise().done(function(){
        $('.callTimeCounter-black').countimer({
            autoStart : true,
            leadingZeros: 2,
            initHours : counterTime.displayedMode.unformatted.hours,
            initMinutes : counterTime.displayedMode.unformatted.minutes,
            initSeconds: counterTime.displayedMode.unformatted.seconds
        });
    });
    
    stop_rt();
    $(".video-popup-leftBx").css({ 'background-image': 'url()' });
    $(".acceptCall").hide();
    $(".rejectCall").text('End Call');
    $("#local-media.video-popup-smallBx").css({ 'top': 'unset' });
    //alert(2);
    Video.createLocalTracks({audio: true,video: { width: 1200,height:720 }}).then(function(localTracks) {
        var localMediaContainer = document.getElementById('local-media');
        localTracks.forEach(function(track) {
            activeRoom.localParticipant.addTrack(track);
            document.getElementById('local-media').appendChild(track.attach());
        });
    });
    $("#local-media video").css({ 'height': '100px' });
    $(".video-popup-smallBx").css({ 'bottom': '0', 'position': 'absolute', 'right': '0' });
    //console.log(activeRoom);
    activeRoom.participants.forEach(function(participant) {
        //activeRoom.disconnect();
        //location.reload();
        log("Already in Room1: '" + participant.identity + "'");
        var previewContainer = document.getElementById('remote-media');

        attachParticipantTracks(participant, previewContainer);
    });

    activeRoom.on('trackAdded', function(track, participant) {
        //alert(15);
        var counterTime = $('.callTimeCounter').countimer('current');
        $('.callTimeCounter').countimer('stop');
        $('#videoChat').modal('hide');
        $('#videoChat111111').modal('show');
        $(".video-popup-leftBx").remove(".callTimeCounter-black").append('<div class="callTimeCounter-black"><i class="fa fa-clock-o" style="color: #fff;margin: 5px;"></i>0:0:4</div>').promise().done(function(){
            $('.callTimeCounter-black').countimer({
                autoStart : true,
                leadingZeros: 2,
                initHours : counterTime.displayedMode.unformatted.hours,
                initMinutes : counterTime.displayedMode.unformatted.minutes,
                initSeconds: counterTime.displayedMode.unformatted.seconds
            });
        });
        stop_rt();
        log(participant.identity + " added track: " + track.kind);
        var previewContainer = document.getElementById('remote-media');
        attachTracks([track], previewContainer);
    });

    activeRoom.on('trackRemoved', function(track, participant) {
        log(participant.identity + " removed track: " + track.kind);
        detachTracks([track]);
    });

    // When a participant disconnects, note in log
    activeRoom.on('participantDisconnected', function(participant) {
        log("Participant '" + participant.identity + "' left the room");
        detachParticipantTracks(participant);
        activeRoom.disconnect();
        activeRoom = null;
        location.reload();
    });

    // When we are disconnected, stop capturing local video
    // Also remove media for all remote participants
    activeRoom.on('disconnected', function() {
        log('Left');
        detachParticipantTracks(activeRoom.localParticipant);
        activeRoom.participants.forEach(detachParticipantTracks);
        activeRoom.disconnect();
        activeRoom = null;
        $("#videoChat").modal('hide');
        stop_rt();
        $(".video-popup-leftBx").css({ 'background-image': 'url()' });
        location.reload();
    });
});
//};

function callUser(userRoom, imgUrl, userName, uidentity) {
    roomName = userRoom;
    //$(".video-popup-leftBx").css({ 'background-image': 'url(' + imgUrl + ')', 'background-repeat': 'no-repeat', 'background-position': 'center', 'min-height': '300px' });
    $('#imgsrcforvid').attr('src',imgUrl);
    $("#videoChat111111 .modal-title").html('Call to ' + userName);
    $('.video_call_name').html('<h4>'+userName+'</h4>');
    $(".acceptCall").hide();
    $.getJSON(window.host + 'webroot/tokenVideo.php?name=' + uidentity + '&room=' + roomName, function(data) {
        identity = data.identity;
        roomName = data.room;
        //console.log('roomName=' + roomName);
        if (roomName) {
            console.log("Joining room '" + roomName + "'...");
            var connectOptions = { name: roomName, logLevel: 'debug' };
            //connectOptions.video = false;
            //connectOptions.audio = false;
            Twilio.Video.connect(data.token, {video: { width: 1000 }, name: roomName, tracks: [] }).then(joinBypass, function(error) {
                console.log('Could not connect to Twilio: ' + error.message);
            }); //imgUrl
            $("#local-media video").css({ 'height': '100px' });
            //$(".video-popup-smallBx").css({ 'bottom': '0', 'position': 'absolute', 'right': '0' });
            console.log('----------------------');
            //setTimeout(function() { joinBypass(); }, 1000)
        } else {
            alert('Please enter a room name.');
        }
    });
}

function joinBypass(room) {
    var Video = Twilio.Video;
    var partnerJoin = 0;
    activeRoom = room;
    //$(".video-popup-leftBx").css({ 'background-image': 'url()' });
    $(".acceptCall").hide();
    $(".rejectCall").text('End Call');
    $("#remote-media111").append('<div class="callTimeCounter"><i class="fa fa-clock-o" style="color: #fff;margin: 5px;"></i>0:0:4</div>').promise().done(function(){
        $('.callTimeCounter').countimer({
            autoStart : true,
            leadingZeros: 2,
            initHours : 0,
            initMinutes : 0,
            initSeconds: 1
		});
    });

    Video.createLocalTracks({audio: true,video: { width: 1280,height:720 }}).then(function(localTracks) {
        //alert(1);
        var localMediaContainer = document.getElementById('local-media');
        localTracks.forEach(function(track) {
            activeRoom.localParticipant.addTrack(track);
            document.getElementById('local-media').appendChild(track.attach());
        });
    });
    $("#local-media video").css({ 'height': '100px' });
    $(".video-popup-smallBx").css({ 'bottom': '0', 'position': 'absolute', 'right': '0' });

    activeRoom.participants.forEach(function(participant) {
        //activeRoom.disconnect();
        //location.reload();
        log("Already in Room2: '" + participant.identity + "'");
        var previewContainer = document.getElementById('remote-media');
        attachParticipantTracks(participant, previewContainer);
    });

    activeRoom.on('trackAdded', function(track, participant) {
        //alert(16);
        $('#videoChat').modal('hide');
        $('#videoChat111111').modal('show');
        var counterTime = $('.callTimeCounter').countimer('current');
        $('.callTimeCounter').countimer('stop');
        $('#videoChat111111').modal('show');
        if($(".video-popup-leftBx").find(".callTimeCounter-black").length <= 0 ){
            $(".video-popup-leftBx").remove(".callTimeCounter-black").append('<div class="callTimeCounter-black"><i class="fa fa-clock-o" style="color: #fff;margin: 5px;"></i>0:0:4</div>').promise().done(function(){
                $('.callTimeCounter-black').countimer({
                    autoStart : true,
                    leadingZeros: 2,
                    initHours : counterTime.displayedMode.unformatted.hours,
                    initMinutes : counterTime.displayedMode.unformatted.minutes,
                    initSeconds: counterTime.displayedMode.unformatted.seconds
                });
            });
        }
        stop_rt();
        window.addTimerForVideo=setInterval(addTimerForVideo,60000);
        log(participant.identity + " added track: " + track.kind);
        $("#local-media.video-popup-smallBx").css({ 'top': 'unset' });
        $(".video-popup-leftBx").css({ 'background-image': 'url()' });
        var previewContainer = document.getElementById('remote-media');
        attachTracks([track], previewContainer);
        partnerJoin = 1;
    });

    activeRoom.on('trackRemoved', function(track, participant) {
        log(participant.identity + " removed track: " + track.kind);
        detachTracks([track]);
    });

    // When a participant disconnects, note in log
    activeRoom.on('participantDisconnected', function(participant) {
        log("Participant '" + participant.identity + "' left the room");
        detachParticipantTracks(participant);
        activeRoom.disconnect();
        location.reload();
    });

    // When we are disconnected, stop capturing local video
    // Also remove media for all remote participants
    activeRoom.on('disconnected', function() {
        log('Left');
        detachParticipantTracks(activeRoom.localParticipant);
        activeRoom.participants.forEach(detachParticipantTracks);
        activeRoom.disconnect();
        activeRoom = null;
        $("#videoChat").modal('hide');
        stop_rt();
        $(".video-popup-leftBx").css({ 'background-image': 'url()' });
        location.reload();
    });

    setTimeout(function(){
        if(partnerJoin!=1){
            detachParticipantTracks(activeRoom.localParticipant);
            activeRoom.participants.forEach(detachParticipantTracks);
            activeRoom.disconnect();
            activeRoom = null;
            location.reload();
        }
    },30000);
}

// Activity log
function log(message) {
    console.log(message);
}

function leaveRoomIfJoined() {
    if (activeRoom) {
        activeRoom.disconnect();
    }
    location.reload();
}