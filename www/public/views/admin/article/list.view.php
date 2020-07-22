@extend(templates/back)

@section(styles)
@endsection

@section(body)

<section>
    <a href="/admin/article/new">Ajouter</a>
    <div>
        <table>
            <tr>
                <th><input type="checkbox"></th>
                <th>id</th>
                <th>title</th>
                <th>date add</th>
                <th>date edit</th>
                <th>visible</th>
                <th>action</th>
            </tr>
            <?php if($articles['data'][0] !== null): ?>
            <?php foreach( $articles['data'] as $article):
                $id = $article->getId()?>
                <tr>
                    <td class="list-content"><input type="checkbox"></td>
                    <td class="list-content"><?= $id ?></td>
                    <td class="list-content"><?= $article->getTitle(); ?></td>
                    <td class="list-content"><?= $article->getCreatedAt()->format('d/m/Y'); ?></td>
                    <td class="list-content"><?= $article->getUpdatedAt()->format('d/m/Y'); ?></td>
                    <td class="list-content"><?= $article->getVisible() ?></td>
                    <td class="list-content">
                        <a href="/admin/article/edit/<?= $id; ?>">
                            <button class="btn btn-succes">Modifier</button>
                        </a>
                        <a href="/admin/article/delete/<?= $id; ?>">
                            <button id="delete-lesson" class="btn btn-danger">Delete</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php endif; ?>

            <?= $articles['link']; ?>

        </table>
    </div>
</section>

@endsection

