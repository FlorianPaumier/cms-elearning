<?php


namespace App\Controllers\Frontend;


use App\Core\Cache\ConfigHandler;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\ChatGlobal;
use App\Entity\ChatMessage;
use App\Entity\ChatSession;
use App\Form\ChatForm;
use App\Repository\ChatGlobalRepository;

class ChatController extends BaseController
{
    public function index(Request $request, ChatGlobalRepository $chat)
    {
        $this->getMessage($chat);
        $chat->findAll();

        $chatGlobal = new ChatGlobal();

        $form = $this->createForm(ChatForm::class, $chatGlobal);
        $form->handleRequest($request);

        if ($request->getMethod() == "POST" && $form->isValid()) {
            $em = ConfigHandler::get("entityManager");
            $chatGlobal->setUser($this->getUser());
            $em->persist($chatGlobal);
            $em->flush();
            $this->redirect->redirectToRoute("app_chat");
        }

        return $this->renderer->render("frontend/chat/global", [
                "form" => $form->createView(),
                "messages" => $chat,
                //"users" => $users
            ]
        );
    }

    public function session()
    {

    }

    public function chat()
    {

    }

    public function delete()
    {
        //si id utilisateur = id utilisateur message
    }

    public function report()
    {
        //faire un report d'un message
    }

    public function userVerified()
    {
        $user_id = $this->getUser()->getId();

        if(!empty($user_id) && isset($user_id)){
            return true;
        }
        return false;
    }

    public function getAnnonce(){
        $query = $this->entityManager->getPdo()->query("SELECT * FROM chat_annonce LIMIT 0,1");
        while ($data = $query->fetch())
            $json['annonce'] = $data['annonce_text'];
        $query->closeCursor();
    }

    public function getMessage(ChatGlobalRepository $repository) {
        $messages = $repository->leftJoin('user','u')->fetch();
            dump($messages);

        $query = $this->entityManager->getPdo()->prepare("
            SELECT message_id, message_user, message_time, message_text, account_id, account_login
            FROM chat_messages
            LEFT JOIN chat_accounts ON chat_accounts.account_id = chat_messages.message_user
            WHERE message_time >= :time
            ORDER BY message_time ASC LIMIT 0,100
        ");
        $query->execute(array(
            'time' => $_GET['dateConnexion']
        ));
        $count = $query->rowCount();
        if($count != 0) {
            $json['messages'] = '<div id="messages_content">';
            // On crée un tableau qui continendra notre...tableau
            // Afin de placer les emssages en bas du chat
            // On triche un peu mais c'est plus simple :D
            $json['messages'] .= '<table><tr><td style="height:500px;" valign="bottom">';
            $json['messages'] .= '<table style="width:100%">';

            $i = 1;
            $e = 0;
            $prev = 0;
            while ($data = $query->fetch()) {
                // Change la couleur dès que l'ID du membre est différent du précédent
                if($i != 1) {
                    $idNew = $data['message_user'];
                    if($idNew != $id) {
                        if($colId == 1) {
                            $color = '#077692';
                            $colId = 0;
                        } else {
                            $color = '#666';
                            $colId = 1;
                        }
                        $id = $idNew;
                    } else
                        $color = $color;
                } else {
                    $color = '#666';
                    $id = $data['message_user'];
                    $colId = 1;
                }


                $text .= '<tr><td style="width:15%" valign="top">';
                // Si le dernier message est du même membre, on écrit pas de nouveau son pseudo
                if($prev != $data['account_id']) {
                    // contenu du message
                    $text .= '<a href="#post" onclick="insertLogin(\''.addslashes($data['account_login']).'\')" style="color:black">';
                    $text .= date('[H:i]', $data['message_time']);
                    $text .= '&nbsp;<span style="color:'.$color.'">'.$data['account_login'].'</span>';
                    $text .= '</a>';
                }
                $text .= '</td>';
                $text .= '<td style="width:85%;padding-left:10px;" valign="top">';


                // On supprime les balises HTML
                $message = htmlspecialchars($data['message_text']);

                // On transforme les liens en URLs cliquables
                $message = urllink($message);

                // Si le nom apparaît suivi de >, on le colore en orange
                if(user_verified()){
                    if(preg_match('#'.$_SESSION['login'].'&gt;#is', $message)) {
                        $message = preg_replace('#'.$_SESSION['login'].'&gt;#is', '<b><span style="color:orange;">'.$_SESSION['login'].'&gt;</span></b>', $message);
                    }
                }

                // On ajoute le message en remplaçant les liens par des URLs cliquables
                $text .= $message.'<br />';
                $text .= '</td></tr>';

                $i++;
                $prev = $data['account_id'];
            }

            /* On crée la colonne messages dans le tableau json
            qui contient l'ensemble des messages */
            $json['messages'] = $text;

            $json['messages'] .= '</table>';
            $json['messages'] .= '</td></tr></table>';
            $json['messages'] .= '</div>';
        } else {
            $json['messages'] = 'Aucun message n\'a été envoyé pour le moment.';
        }
        $query->closeCursor();

    }
}