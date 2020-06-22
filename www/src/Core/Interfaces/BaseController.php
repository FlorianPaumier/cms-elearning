<?php
namespace App\Core\Interfaces;

use App\Core\Cache\ConfigHandler;
use App\Core\Database\Table;
use App\Core\Form\FormBuilder;
use App\Core\Form\Validator\Validator;
use App\Core\Render\RenderView;
use App\Core\Request\RedirectionHandler;
use App\Core\Request\Request;
use App\Core\Security\UserManager;
use App\Core\Session\PHPSession;

/**
 * Class BaseController
 * @package App\Core\Interfaces
 */
abstract class BaseController
{
    /**
     * @var RenderView
     *
     * @deprected use render function
     *
     */
    protected $renderer;

    /**
     * @var Table
     */
    protected $repository;

    /**
     * @var UserManager
     */
    protected $userManager;

    /**
     * @var Request
     */
    protected $query;

    /**
     * @var RedirectionHandler
     */
    protected $redirect;

    /**
     * @var FormBuilder $form
     */
    protected $form;

    /**
     * @var PHPSession
     */
    protected $session;


    public function __construct()
    {
        /**
         * @deprected use render function
         */
        $this->renderer = new RenderView();
        $this->repository = ConfigHandler::get('repository');
        $this->userManager = ConfigHandler::get("userManager");
        $this->query = ConfigHandler::get("request");
        $this->session = ConfigHandler::get("session");
        $this->redirect = new RedirectionHandler();
    }

    /** Return current log in user */
    protected function getUser(){
        dump($_SESSION);
        return $this->session->offsetGet("app.user");
    }

    /**
     * Creates and returns a Form instance from the type of the form.
     */
    protected function createForm(string $type, &$data = null, array $options = []): FormBuilder
    {
        if (!class_exists($type)) {
            throw new \Exception();
        }

        $form = (new $type);
        $formBuilder = (new FormBuilder($data))->setParent($type)->setFormType($form);
        return $form->buildForm($formBuilder);
    }

    protected function render(string $view, array $data = []){
        return (new RenderView())->render($view, $data);
    }
}
