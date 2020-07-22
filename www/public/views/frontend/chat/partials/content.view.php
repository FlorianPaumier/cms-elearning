<div>
    chat
    <?php /*foreach ( $messages as $message ):*/?><!--
        <div class="
            <?php
/*                if ($message->getId() === $_SESSION['user_id']) {
                    echo 'left-chat';
                } else {
                    echo 'right-chat';
                } */?>">
            <div><?/*= $message->getIdUser(); */?></div>
            <div><?/*= $message->getMessageDate(); */?></div>
            <div><?/*= $message->getMessage(); */?></div>
        </div>
    --><?php /*endforeach;*/?>
    <div id="container">
        <h1>Mon super chat</h1>

        <!-- Statut //////////////////////////////////////////////////////// -->
        <table class="status">
            <tr>
                <td>
                    <span id="statusResponse"></span>
                    <select name="status" id="status" style="width:200px;" onchange="setStatus(this)">
                        <option value="0">Absent</option>
                        <option value="1">Occup&eacute;</option>
                        <option value="2" selected>En ligne</option>
                    </select>
                </td>
            </tr>
        </table>
        <table class="chat">
            <tr>
                <!-- zone des messages -->
                <td valign="top" id="text-td">
                    <div id="annonce"></div>
                    <div id="text">
                        <div id="loading">
                            <center>
                                <span class="info" id="info">Chargement du chat en cours...</span><br />
                                <img src="ajax-loader.gif" alt="patientez...">
                            </center>
                        </div>
                    </div>
                </td>

                <!-- colonne avec les membres connectés au chat -->
                <td valign="top" id="users-td"><div id="users">Chargement</div></td>
            </tr>
        </table>
        <a name="post"></a>
        <table class="post_message"><tr>
                <td>
                    <form action="" method="" onsubmit="envoyer(); return false;">
                        <input type="text" id="message" maxlength="255" />
                        <input type="button" onclick="envoyer()" value="Envoyer" id="post" />
                    </form>
                    <div id="responsePost" style="display:none"></div>
                </td>
            </tr></table>
    </div>


    {{ form }}
</div>