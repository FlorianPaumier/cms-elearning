var reloadTime = 1000;
var scrollBar = false;

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

$(document).ready(function() {
    if(document.getElementsByClassName('chat-message')) {
        window.setInterval(getMessages, reloadTime);
        window.setInterval(getOnlineUsers, reloadTime);
        $(".chat-message").focus();
    }
});

function getOnlineUsers() {
    // On lance la requête ajax
    $.getJSON('/chat/online', function(data) {
        // Si data['error'] renvoi 0, alors ça veut dire que personne n'est en ligne
        // ce qui n'est pas normal d'ailleurs
        if(data['error'] === undefined) {
            var online = '', i = 1, image, text;
            // On parcours le tableau inscrit dans
            // la colonne [list] du tableau JSON
            for (var id in data['list']) {

                // On met dans la variable text le statut en toute lettre
                // Et dans la variable image le lien de l'image
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
                // On affiche d'abord le lien pour insérer le pseudo dans la zone de texte
                online += '<a href="#post" onclick="insertLogin(\''+data['list'][id]["login"]+'\')" title="'+text+'">';
                // Ensuite on affiche l'image
                online += '<img src="status-'+image+'.png" /> ';
                // Enfin on affiche le pseudo
                online += data['list'][id]["login"]+'</a>';
                // Si i vaut 1, ça veut dire qu'on a affiché un membre
                // et qu'on doit aller à la ligne
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

function rmResponse() {
    $("#statusResponse").html('');
}

$('.chat-message-submit').on('click',(
    function(){
        postMessage();
        return false;
    }
));

$('.chat-status-select').on('change',(
    function(){
        setStatus();
        return false;
    }
));