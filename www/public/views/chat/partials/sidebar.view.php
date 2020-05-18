<?php
    use App\Entity\ChatSession;
    use App\Entity\User;
?>
<div>
    sidebar
    <!-- Liste des utilisateurs -->
<!--    <ul>-->
<!--        --><?php
//        /** @var User $user */
//        foreach ($users as $user ) : ?>
<!--            <li>-->
<!--                --><?//= $user->getId(); ?>
<!--                --><?//= $user->getUsername() ?>
<!--            </li>-->
<!--        --><?php //endforeach; ?>
<!--    </ul>-->
    <!-- Lister les session -->
    <ul>
        <?php
            /** @var ChatSession $instance */
        foreach ( $chatSession as $instance ) : ?>
            <li>
                <?= $instance->getIdUser(); ?>
                <?= $instance->getIdSession(); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>