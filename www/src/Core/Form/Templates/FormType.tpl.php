<?= "<?php\n" ?>

namespace App\Form;

use App\Core\Form\FormBuilder;
use App\Core\Form\AbstractForm;
<?php foreach ($usesType as  $useType): ?>
use <?= $useType ?>;
<?php endforeach; ?>


class <?= $class_name ?> extends AbstractForm
{

    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder
        <?php foreach ($form_fields as $form_field => $typeOptions): ?>
                ->add('<?= $form_field ?>', <?= $typeOptions["type"] ?> , <?= var_export($typeOptions["parameters"]) ?>)
        <?php endforeach; ?>
        ;
    }


    /**
    * @inheritDoc
    */
    public function setBlockPrefix(string $prefix = null)
    {
        $this->prefix = "<?= $prefix ?>";
    }

    public function getBlockPrefix(): string
    {
        return $this->prefix;
    }


}