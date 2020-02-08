<?php
namespace App\Core\Interfaces;

use App\Core\Database\QueryBuilder;
use App\Core\Database\Table;
use App\Core\Form\Form;
use App\Core\Renderer\RenderView;
use App\Core\request\RedirectionHandler;
use App\Core\Request\Request;
use App\Core\Security\UserManager;
use App\Core\Session\PHPSession;
use App\Core\Validator\Validator;
use App\Core\Kernel\Kernel;

/**
 * Class BaseController
 * @package App\Core\Interfaces
 * Object with basic element for the controller
 */
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
     * @var Form $form 
     */
    protected $form;

    /**
     * @var PHPSession
     */
    protected $session;

    /** @var Validator */
    protected $validator;

    /*
     * Retrieve all the object needed for a controller
     * Todo : Change some element to autowiring
     */
    public function __construct()
    {
        $this->renderer = new RenderView();
        $this->entityManager = Kernel::get("entityManager");
        $this->repository = Kernel::get('repository');
        $this->userManager = Kernel::get("userManager");
        $this->query = Kernel::get("request");
        $this->form = new Form();
        $this->session = Kernel::get("session");

    }

    /**
     * Create a new Form Validator
     * @return Validator
     */
    protected function getValidator()
    {
        return new Validator($this->query->getRequest());
    }

    /*
     * At the end, render the view
     */
    public function __destruct()
    {
        $this->renderer->compile();
    }
}