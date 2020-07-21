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
                <th>email</th>
                <th>action</th>
            </tr>
            <?php foreach( $emails['data'] as $email):
                $id = $email->getId()?>
                <tr>
                    <td class="list-content"><input type="checkbox"></td>
                    <td class="list-content"><?= $email->getId()?></td>
                    <td class="list-content"><?= $email->getEmail(); ?></td>
                    <td class="list-content">
                        <a href="/admin/newsletteremail/edit/<?= $id; ?>">
                            <button class="btn btn-succes">Modifier</button>
                        </a>
                        <a href="/admin/newsletteremail/delete/<?= $id; ?>">
                            <button id="delete-newsletter" class="btn btn-danger">Delete</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?= $emails["links"] ?>
    </div>
</section>

@endsection

