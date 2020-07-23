var reloadTime = 1000;
var scrollBar = false;

/**
 * @function getMessages()
 * @description get all message;
 */
function getMessages() {
    $.getJSON('/chat/message', function(data) {
        if(data['error'] === undefined) {
            var container = $('#text');
            var content = $('#messages_content');
            var height = content.height()-500;
            var toBottom;

            toBottom = container[0].scrollTop === height;
            $("#text").html(data['messages']);

            content = $('#messages_content');
            height = content.height()-500;

            if(toBottom === true)
                container[0].scrollTop = content.height();

            if(scrollBar !== true) {
                container[0].scrollTop = content.height();
                scrollBar = true;
            }
        } else if(data['error'] === 'unlog') {
            $("#text").html('');
            $(location).attr('href',"chat.php");
        }
    });
}

/**
 * @function getMessages()
 * @description get all messages;
 */
function postMessage() {
    var message = encodeURIComponent($(".chat-message").val());

    if(message.trim() !== "") {
        $.ajax({
            type: "POST",
            url: "/chat/send",
            data: "message="+message,
            success: function () {
                getMessages();
            },
            error: function () {
                //gérer une erreur.
            }
        });
        $(".chat-message").val('');
    }

}

/**
 * @description reload message and user status
 */
$(document).ready(function() {
    if(document.getElementsByClassName('chat-message')) {
        window.setInterval(getMessages, reloadTime);
        window.setInterval(getOnlineUsers, reloadTime);
        $(".chat-message").focus();
    }
});

/**
 * @function getOnlineUsers()
 * @description get user status and list of users online;
 */
function getOnlineUsers() {
    $.getJSON('/chat/online', function(data) {
        if(data['error'] === undefined) {
            var online = '', i = 1, image, text;
            for (var id in data['list']) {

                if(data["list"][id]["status"] === 'busy') {
                    text = 'Occupé';
                    image = 'busy';
                } else if(data["list"][id]["status"] === 'inactive') {
                    text = 'Absent';
                    image = 'inactive';
                } else {
                    text = 'En ligne';
                    image = 'active';
                }
                online += '<a href="#post" onclick="insertLogin(\''+data['list'][id]["login"]+'\')" title="'+text+'">';
                online += '<img src="status-'+image+'.png" /> ';
                online += data['list'][id]["login"]+'</a>';
                if(i === 1) {
                    i = 0;
                    online += '<br>';
                }
                i++;
            }
            $("#users").html(online);
        } else if(data['error'] == '1')
            $("#users").html('<span style="color:gray;">Aucun utilisateur connect&eacute;.</span>');
    });
}

/**
 * @function getStatus()
 * @description change user status
 */
function setStatus() {
    var status = encodeURIComponent($(".chat-status-select").val());
    $.ajax({
        type: "POST",
        url: "/chat/status",
        data: "status="+status,
        success: function(msg){
            // On affiche la réponse
            console.log(status);
            $("#statusResponse").html('<span style="color:green">Le statut a &eacute;t&eacute; mis &agrave; jour</span>');
            setTimeout(rmResponse, 3000);
        },
        error: function(msg){
            // On affiche l'erreur dans la zone de réponse
            $("#statusResponse").html('<span style="color:orange">Erreur</span>');
            setTimeout(rmResponse, 3000);
        }
    });
}

/**
 * @function rmResponse()
 * @description clear status response
 */
function rmResponse() {
    $("#statusResponse").html('');
}

/**
 * @description send message on click
 */
$('.chat-message-submit').on('click',(
    function(){
        postMessage();
        return false;
    }
));

/**
 * @description update status on change
 */
$('.chat-status-select').on('change',(
    function(){
        setStatus();
        return false;
    }
));