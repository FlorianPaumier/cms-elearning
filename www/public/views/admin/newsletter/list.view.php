@extend(templates/back)

@section(styles)
@endsection

@section(body)

<section>
    <div>
        <table>
            <tr>
                <th><input type="checkbox"></th>
                <th>id</th>
                <th>title</th>
                <th>content</th>
                <th>date add</th>
                <th>date edit</th>
                <th>action</th>
            </tr>
            <?php foreach( $newsletters['data'] as $newsletter):
                $id = $newsletter->getId()?>
                <tr>
                    <td class="list-content"><input type="checkbox"></td>
                    <td class="list-content"><?= $newsletter->getId()?></td>
                    <td class="list-content"><?= $newsletter->getTitle(); ?></td>
                    <td class="list-content"><?= $newsletter->getContent(); ?></td>
                    <td class="list-content"><?= $newsletter->getCreatedAt()->format("d-m-Y"); ?></td>
                    <td class="list-content"><?= $newsletter->getUpdatedAt()->format("d-m-Y"); ?></td>
                    <td class="list-content">
                        <a href="/admin/newsletter/edit/<?= $id; ?>">
                            <button class="btn btn-succes">Modifier</button>
                        </a>
                        <a href="/admin/newsletter/delete/<?= $id; ?>">
                            <button id="delete-newsletter" class="btn btn-danger">Delete</button>
                        </a>
                        <a href="/admin/newsletter/send/<?= $id; ?>">
                            <button id="send-newsletter" class="btn btn-danger">Send</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?= $newsletters["links"] ?>
    </div>
</section>

@endsection

