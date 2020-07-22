<?php


namespace App\Controllers\Frontend;


use App\Core\Cache\ConfigHandler;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\ChatGlobal;
use App\Entity\ChatMessage;
use App\Entity\ChatOnline;
use App\Entity\ChatSession;
use App\Form\ChatForm;
use App\Form\ChatStatusForm;
use App\Repository\ChatAnnonceRepository;
use App\Repository\ChatGlobalRepository;
use App\Repository\ChatOnlineRepository;

class ChatController extends BaseController
{
    public function index(Request $request, ChatGlobalRepository $chat)
    {
        $chat->findAll();

        $formMessage = $this->createForm(ChatForm::class);
        $formStatus = $this->createForm(ChatStatusForm::class);

        return $this->renderer->render("frontend/chat/global", [
                "formMessage" => $formMessage->createView(),
                "formStatus" => $formStatus->createView(),
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

    public function online(ChatOnlineRepository $repository, ChatOnline $online) {
        $this->setOnline($repository);
        $this->checkConnect($online);
        return $this->getOnline($repository);
    }

    public function setOnline(ChatOnlineRepository $repository) {
        $user = $repository->findOneBy(['user_id' => $this->getUser()->getId()]);
        $em = ConfigHandler::get("entityManager");
        if($user === null) {
            $user = new ChatOnline();
            $user->setUser($this->getUser());
            $user->setIp($_SERVER["REMOTE_ADDR"]);
            $user->setStatus(2);
        }
        $user->setTime(time());

        $em->persist($user);
        $em->flush();
    }

    public function getOnline(ChatOnlineRepository $repository) {
        $onlines = $repository->leftJoin('user','u')->orderBy("time", "ASC")->fetch();

        $i = 0;
        if(is_array($onlines)) {
            foreach ($onlines as $online) {
                $status = $this->status($online->getStatus());

                $infos["status"] = $status;
                $infos["login"] = $online->getUser()->getUsername();

                $accounts[$i] = $infos;
                $i++;
            }
        } else {
            $status = $this->status($onlines->getStatus());

            $infos["status"] = $status;
            $infos["login"] = $onlines->getUser()->getUsername();

            $accounts[$i] = $infos;
        }
        $json['list'] = $accounts;

        // Encodage de la variable tableau json et affichage
        return json_encode($json);
    }

    public function status($status)  {
        switch ($status) {
            case '0':
                return 'inactive';
                break;
            case '1':
                return 'busy';
                break;
            case '2':
                return 'active';
                break;
            default :
                return null;
        }
    }

    public function getMessage(ChatGlobalRepository $repository) {
        $messages = $repository->leftJoin('user','u')->orderBy("time", "ASC")->fetch();

        if($messages !== null) {
            $json['messages'] = '<div id="messages_content">';
            $json['messages'] .= '<table><tr><td style="height:500px;" valign="bottom">';
            $json['messages'] .= '<table style="width:100%">';

            $content = '';
            $prev = '';
            if(is_array($messages)) {
                foreach ( $messages as $message ) {
                    $content .= '<tr><td style="width:15%;vertical-align: top">';

                    if($prev !== $message->getUser()->getId()){
                        $content .= '<a href="#post" onclick="insertLogin(\''.addslashes('#').'\')" style="color:black">';
                        $content .= $message->getTime();
                        $content .= '<span>'.$message->getUser()->getUsername().'</span>';
                        $content .= '</a>';
                    }
                    $content .= '</td>';
                    $content .= '<td style="width:85%;padding-left:10px;vertical-align: top">';

                    $content .= htmlspecialchars($message->getMessage());
                    $content .= '</td></tr>';

                    $prev = $message->getUser()->getUsername();
                }
            } else {
                $content .= '<tr><td style="width:15%;vertical-align: top">';

                if($prev !== $messages->getUser()->getId()){
                    $content .= '<a href="#post" onclick="insertLogin(\''.addslashes('#').'\')" style="color:black">';
                    $content .= $messages->getTime();
                    $content .= '<span>'.$messages->getUser()->getUsername().'</span>';
                    $content .= '</a>';
                }
                $content .= '</td>';
                $content .= '<td style="width:85%;padding-left:10px;vertical-align: top">';

                $content .= htmlspecialchars($messages->getMessage());
                $content .= '</td></tr>';

                $prev = $messages->getUser()->getUsername();
            }

            $json['messages'] = $content;

            $json['messages'] .= '</table>';
            $json['messages'] .= '</td></tr></table>';
            $json['messages'] .= '</div>';
        } else {
            $json['messages'] = 'Aucun message n\'a été envoyé pour le moment.';
        }

        return json_encode($json);
    }

    public function checkConnect(ChatOnline $online) {
        $time_out = time()-5;
        $this->entityManager->delete($online, 'time < :time',["time" => $time_out]);
    }

    public function changeStatus(Request $request, ChatOnlineRepository $repository, ChatOnline $online)
    {
        $user = $repository->findBy(['user_id' => $this->getUser()->getId()]);

        $data = $request->getRequest()->all();

        if (!empty($data['status'])) {
            $em = ConfigHandler::get("entityManager");
            $user->setStatus(!empty($data['status']));
            $em->persist($user);
            $em->flush();
            $this->redirect->redirectToRoute("admin_article_list");
        }

        return 'Status changed';
    }

    public function sendMessage(Request $request) {
        $chatGlobal = new ChatGlobal();

        $data = $request->getRequest()->all();

        if(!empty($data['message'])){
            $em = ConfigHandler::get("entityManager");
            $chatGlobal->setMessage($data['message']);
            $chatGlobal->setUser($this->getUser());
            $chatGlobal->setTime(time());
            $em->persist($chatGlobal);
            $em->flush();
        }

        return 'Message send';
    }
}