<?php


namespace App\Core\Form;


use App\Core\Interfaces\FormTypeInterface;

/**
 * Class AbstractForm
 * @package App\Core\Form
 */
abstract class AbstractForm implements FormTypeInterface
{
    #region field
    /**
     * @var string
     */
    protected $prefix = "";

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var
     */
    protected $parent;

    /**
     * @var
     */
    protected $parentPrefix;

    #endregion

    /**
     * AbstractForm constructor.
     */
    public function __construct()
    {
        $this->configureOptions();
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param string|null $prefix
     */
    public function setBlockPrefix(string $prefix = null) {
        $this->prefix = $prefix;
    }

    /**
     * @return mixed
     */
    public function getParent(){
        return $this->parent;
    }
    /**
     * @return mixed
     */
    public function setParent($parent){
        $this->parent = $parent;
        return $this;
    }
    /**
     * @return mixed
     */
    public function setParentPrefix($parent){
        $this->parentPrefix = $parent;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getParentPrefix(){
        return $this->parentPrefix;
    }
}