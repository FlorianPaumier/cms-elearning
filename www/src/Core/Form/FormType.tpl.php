<?= "<?php\n" ?>

namespace App\Form;

use App\Core\Form\FormBuilder;
use App\Core\Interfaces\FormTypeInterface;

class <?= $class_name ?> extends FormBuilder implements FormTypeInterface
{
    /**
    * @inheritDoc
    */
    public static function getConstraint(): array
    {
        return <?= var_export($constraints, true) ?> ;
    }
    public function buildForm(): FormBuilder
    {
        return $this
        <?php foreach ($form_fields as $form_field => $typeOptions): ?>
            <?php if (null === $typeOptions['type'] && !$typeOptions['options_code']): ?>
                ->input('<?= $form_field ?>', <?= var_export($typeOptions["parameters"], true) ?>)
            <?php else: ?>
                -><?= $typeOptions["type"] ?>('<?= $form_field ?>', <?= var_export($typeOptions["parameters"], true) ?>)
            <?php endif; ?>
        <?php endforeach; ?>
        ;
    }


    /**
    * @inheritDoc
    */
    public function setBlockPrefix(): void
    {
        $this->prefix = "<?= $prefix ?>";
    }

    public function getBlockPrefix(): string
    {
        return $this->prefix;
    }


}