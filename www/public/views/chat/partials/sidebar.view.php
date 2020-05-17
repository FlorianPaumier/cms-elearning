<div>
    sidebar
    <!-- Lister les utilisateurs -->
    <ul>
        <?php foreach ( $chatSession as $instance ) : ?>
            <li>
                <?= $instance->getIdUser(); ?>
                <?= $instance->getIdSession(); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>