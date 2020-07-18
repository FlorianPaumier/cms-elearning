@extend(templates/back)

@section(styles)
@endsection

@section(body)
<section>
    <a href="@path(admin_article_new)" id="add-article" class="btn c-blue">Ajout</a>
</section>
<section>
    <table class="table">
        <thead>
        <tr>
            <th>Id</th>
            <th>title</th>
            <th>action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach( $articles['data'] as $article):
            $id = $article->getId()?>
            <tr>
                <td><?= $article->getId()?></td>
                <td><?= $article->getTitle(); ?></td>
                <td class="row">
                    <a href="@path(admin_article_edit, <?= $id; ?>)">
                        <button class="btn btn-succes">Modifier</button>
                    </a>
                    <form action="/admin/article/delete<?= $id; ?>">
                        <button id="delete-lesson" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>

@endsection

