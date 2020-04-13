<?php

namespace App\Core\Interfaces;

use App\Core\Cache\ConfigHandler;
use App\Core\Database\Table;
use App\Core\Form\FormBuilder;
use App\Core\Validator\Validator;
use App\Core\Render\RenderView;
use App\Core\request\RedirectionHandler;
use App\Core\Request\Request;
use App\Core\Security\UserManager;
use App\Core\Session\PHPSession;

abstract class BaseController
{
    /**
     * @var RenderView
     */
    protected $renderer;

    /**
     * @var Table
     */
    protected $entityManager;

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
     * @var PHPSession
     */
    protected $session;

    protected $validator;

    public function __construct()
    {
        $this->renderer = new RenderView();
        $this->repository = ConfigHandler::get('repository');
        $this->userManager = ConfigHandler::get("userManager");
        $this->query = ConfigHandler::get("request");
        $this->form = new FormBuilder();
        $this->session = ConfigHandler::get("session");
        $this->redirect = new RedirectionHandler();
    }

    protected function getValidator(FormTypeInterface $formType)
    {
        return new Validator($formType);
    }

    /**
     * Creates and returns a Form instance from the type of the form.
     */
    protected function create(string $type, $data = null, array $options = []): FormInterface
    {
        return  ConfigHandler::get('form.factory')->create($type, $data, $options);
    }
}