// Get handle to the chat div 
var $chatWindow = $('#messages');

// Our interface to the Chat service
var chatClient;

// A handle to the "general" chat channel - the one and only channel we
// will have in this sample app
var generalChannel;

// The server will assign the client a random username - store that value
// here
var username;
var thisroom;
// Helper function to print info messages to the chat window
function print(infoMessage, asHtml) {
    var $msg = $('<div class="info">');
    if (asHtml) {
        $msg.html(infoMessage);
    } else {
        $msg.text(infoMessage);
    }
    $chatWindow.append($msg);
}

// Helper function to print chat message to the chat window
function printMessage(fromUser, message, updatedon) {
    var addedClass = '',
        image = 'chat-w1.jpg';
    if (fromUser === username) {
        addedClass = 'rightChrt';
        image = 'chat-w2.jpg';
    }
    var messageHtml = '<li class="' + addedClass + '"> <span class="image"> <img src="images/' + image + '" class="" alt=""> </span> <span class="time" style="display:none;">' + updatedon.toLocaleTimeString() + '</span><div class="text left"> ' + message + ' </div></li>';

    $(".inner-chat-section" + thisroom).append(messageHtml);

    $(".inner-chat-section" + thisroom).scrollTop($(".inner-chat-section" + thisroom)[0].scrollHeight);

}

// Set up channel after it has been found
function setupChannel() {
    // Join the general channel
    generalChannel.join().then(function(channel) {
        channel.getMessages().then(function(messages) {
            const totalMessages = messages.items.length;
            $(".inner-chat-section" + thisroom).html('');
            for (i = 0; i < totalMessages; i++) {
                const message = messages.items[i];
                console.log(message);
                printMessage(message.author, message.body, message.dateUpdated);
            }
        });
    });

    // Listen for new messages sent to the channel
    generalChannel.on('messageAdded', function(message) {
        printMessage(message.author, message.body, message.dateUpdated);
    });
}

function createOrJoinGeneralChannel(chatClient, roomname) {
    // Get the general chat channel, which is where all the messages are
    // sent in this simple application
    //console.log('Attempting to join "' + roomname + '" chat channel...');
    var promise = chatClient.getChannelByUniqueName(roomname);
    promise.then(function(channel) {
        generalChannel = channel;
        //console.log('Found general channel:');
        //console.log(generalChannel);
        setupChannel();
    }).catch(function() {
        // If it doesn't exist, let's create it
        //console.log('Creating general channel');
        chatClient.createChannel({
            uniqueName: roomname,
            friendlyName: 'General Chat Channel'
        }).then(function(channel) {
            console.log('Created general channel:');
            console.log(channel);
            generalChannel = channel;
            setupChannel();
        });
    });
}

function functionCall(roomname, memberid) {
    $.getJSON(window.host + 'webroot/token.php', {
        device: 'browser',
        memberid: memberid
    }, function(data) {
        // Alert the user they have been assigned a random username
        username = data.identity;
        new Twilio.Chat.Client.create(data.token).then(function(chatClient) {
            //joinChannels(chatClient);
            console.log('__________________');
            createOrJoinGeneralChannel(chatClient, roomname);
            thisroom = roomname;
        });
    });
}

$(function() {
    // Send a new message to the general channel
    var $input = $('.messageToSend');
    $input.on('keydown', function(e) {
        if (e.keyCode == 13) {
            generalChannel.sendMessage($input.val())
            $input.val('');
        }
    });
});