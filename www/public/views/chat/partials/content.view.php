<div>
    chat
    <?php foreach ( $messages as $message ):?>
        <div class="
            <?php
                if ($message->getId() === $_SESSION['user_id']) {
                    echo 'left-chat';
                } else {
                    echo 'right-chat';
                } ?>">
            <div><?= $message->getIdUser(); ?></div>
            <div><?= $message->getMessageDate(); ?></div>
            <div><?= $message->getMessage(); ?></div>
        </div>
    <?php endforeach;?>

    {{ form }}
</div>