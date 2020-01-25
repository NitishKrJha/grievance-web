var activeRoom;
var previewTracks;
var identity;
var roomName;

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
function letsJoinRoom(){
    var uidentity = window.loginas;
    roomName = 'room_' + uidentity;
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

            Twilio.Video.connect(data.token, { name: roomName, tracks: [] }).then(roomJoined, function(error) {
                console.log('Could not connect to Twilio: ' + error.message);
            });
        } else {
            alert('Please enter a room name.');
        }
    });
}

// Successfully connected!
function roomJoined(room) {
    activeRoom = room;

    //var localDiv = document.getElementById('local-media');
    console.log("Track Dissa");

    log("Joined as '" + identity + "'");
    // Draw local video, if not already previewing
    //var previewContainer = document.getElementById('local-media');
    //if (!previewContainer.querySelector('video')) {
    //    attachParticipantTracks(room.localParticipant, previewContainer);
    //}



    // When a participant joins, draw their video on screen
    room.on('participantConnected', function(participant) {
        log("Joining: '" + participant.identity + "'");
        $.getJSON(window.host + 'member/getMemberDetails/' + participant.identity + '/' + roomName, function(userdata) {
            $("#videoChat").modal('show');
            $(".video-popup-leftBx").css({ 'background-image': 'url(' + userdata.picture + ')', 'background-repeat': 'no-repeat', 'background-position': 'center', 'min-height': '300px' });
            $("#videoChat .modal-title").html('Incoming video call from ' + userdata.name);
            $(".acceptCall").show();

            //alert('start');
        })

    });


}


//  Local video preview
/*document.getElementById('button-preview').onclick = function() {
    var localTracksPromise = previewTracks ?
        Promise.resolve(previewTracks) :
        Twilio.Video.createLocalTracks();

    localTracksPromise.then(function(tracks) {
        previewTracks = tracks;
        var previewContainer = document.getElementById('local-media');
        if (!previewContainer.querySelector('video')) {
            attachTracks(tracks, previewContainer);
        }

    }, function(error) {
        console.error('Unable to access local media', error);
        log('Unable to access Camera and Microphone');
    });
};*/

document.getElementById('rejectCall').onclick = function() {
    location.reload();
}
document.getElementById('acceptCall').onclick = function() {
    //alert("acceptCall");
    var Video = Twilio.Video;
    $(".video-popup-leftBx").css({ 'background-image': 'url()' });
    $(".acceptCall").hide();
    $(".rejectCall").text('End Call');
    $("#local-media.video-popup-smallBx").css({ 'top': 'unset' });
    Video.createLocalTracks().then(function(localTracks) {
        var localMediaContainer = document.getElementById('local-media');
        localTracks.forEach(function(track) {
            activeRoom.localParticipant.addTrack(track);
            document.getElementById('local-media').appendChild(track.attach());
        });
    });
    $("#local-media video").css({ 'height': '100px' });
    $(".video-popup-smallBx").css({ 'bottom': '0', 'position': 'absolute', 'right': '0' });

    activeRoom.participants.forEach(function(participant) {
        log("Already in Room: '" + participant.identity + "'");
        var previewContainer = document.getElementById('remote-media');
        attachParticipantTracks(participant, previewContainer);
    });

    activeRoom.on('trackAdded', function(track, participant) {
        //alert(15);
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
        location.reload();
    });

    // When we are disconnected, stop capturing local video
    // Also remove media for all remote participants
    activeRoom.on('disconnected', function() {
        log('Left');
        detachParticipantTracks(activeRoom.localParticipant);
        activeRoom.participants.forEach(detachParticipantTracks);
        activeRoom = null;
        $("#videoChat").modal('hide');
        $(".video-popup-leftBx").css({ 'background-image': 'url()' });
        location.reload();
    });

};

function callUser(userRoom, imgUrl, userName, uidentity) {
    roomName = userRoom;
    alert(uidentity); 
    $(".video-popup-leftBx").css({ 'background-image': 'url(' + imgUrl + ')', 'background-repeat': 'no-repeat', 'background-position': 'center', 'min-height': '300px' });
    $("#videoChat .modal-title").html('Call to ' + userName);

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
            Twilio.Video.connect(data.token, { name: roomName, tracks: [] }).then(joinBypass, function(error) {
                console.log('Could not connect to Twilio: ' + error.message);
            }); //imgUrl
            $("#local-media video").css({ 'height': '100px' });
            $(".video-popup-smallBx").css({ 'bottom': '0', 'position': 'absolute', 'right': '0' });
            console.log('----------------------');
            //setTimeout(function() { joinBypass(); }, 1000)

        } else {
            alert('Please enter a room name.');
        }
    });
}

function joinBypass(room) {
    var Video = Twilio.Video;
    activeRoom = room;
    //$(".video-popup-leftBx").css({ 'background-image': 'url()' });
    $(".acceptCall").hide();
    $(".rejectCall").text('End Call');

    Video.createLocalTracks().then(function(localTracks) {
        var localMediaContainer = document.getElementById('local-media');
        localTracks.forEach(function(track) {
            activeRoom.localParticipant.addTrack(track);
            document.getElementById('local-media').appendChild(track.attach());
        });
    });
    $("#local-media video").css({ 'height': '100px' });
    $(".video-popup-smallBx").css({ 'bottom': '0', 'position': 'absolute', 'right': '0' });

    activeRoom.participants.forEach(function(participant) {
        log("Already in Room: '" + participant.identity + "'");
        var previewContainer = document.getElementById('remote-media');
        attachParticipantTracks(participant, previewContainer);
    });

    activeRoom.on('trackAdded', function(track, participant) {
        //alert(16);
        window.addTimerForVideo=setInterval(addTimerForVideo,60000);
        log(participant.identity + " added track: " + track.kind);
        $("#local-media.video-popup-smallBx").css({ 'top': 'unset' });
        $(".video-popup-leftBx").css({ 'background-image': 'url()' });
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
        location.reload();
    });

    // When we are disconnected, stop capturing local video
    // Also remove media for all remote participants
    activeRoom.on('disconnected', function() {
        log('Left');
        detachParticipantTracks(activeRoom.localParticipant);
        activeRoom.participants.forEach(detachParticipantTracks);
        activeRoom = null;
        $("#videoChat").modal('hide');
        $(".video-popup-leftBx").css({ 'background-image': 'url()' });
        location.reload();
    });
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