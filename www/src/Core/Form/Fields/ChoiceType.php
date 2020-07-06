<?php


namespace App\Core\Form\Fields;


class ChoiceType extends AbstractType
{

    private $blockName;

    private static $template;

    public static function getTemplate()
    {
        return self::$template;
    }

    public function translate(array $options){
        if($options["expanded"]){
           if($options["multiple"]){
               self::$template = CheckboxType::getTemplate();
               $this->blockName = "checkbox";
           }else {
                self::$template = RadioType::getTemplate();
                $this->blockName = "radio";
           }
        }else{
            self::$template = SelectType::getTemplate();
            $this->blockName = "select";
        }

        return true;
    }

    public function getBlockName(){
        return $this->blockName;
    }

}