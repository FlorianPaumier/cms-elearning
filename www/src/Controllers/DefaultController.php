<?php

namespace App\Controllers;

use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;

class DefaultController extends BaseController
{
    public function index(Request $request)
    {
        $class_name = "ContactType";
        $constraints = [
            [
                "title" => [
                    "empty" => false,
                    "required" => true,
                    "exists" => true,
                ]
            ],
            [
                "description" => [
                    "empty" => false,
                    "required" => true,
                    "exists" => true,
                ]
            ]
        ];
        $prefix = "contact_form";
        $form_fields = [
            "name" => [
               "type" => "textarea",
               "parameters" => [
                   "label" => "Title",
                   "required" => true,
                   "class" => "col-md-6 col-lg-6 col-sm-12",
               ]
            ],
            "first" => [
               "parameters" => [
                   "label" => "first",
                   "required" => true,
                   "class" => "col-md-6 col-lg-6 col-sm-12",
               ]
            ]
        ];

        $params = [$prefix, $form_fields, $constraints, $class_name];
        extract($params);
        ob_start();
        include ROOT_PATH."/src/Core/form/FormType.tpl.php";
        $view = ob_get_clean();
        file_put_contents(ROOT_PATH."/src/Form/".$class_name.".php",$view);
        return $this->renderer->render("home", [
            "method" => $request->getMethod(),
        ]);
    }

    public function doc()
    {
        return $this->renderer->render("doc");
    }
}