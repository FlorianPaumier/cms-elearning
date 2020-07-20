@extend(templates/back)

@section(styles)
<link rel="stylesheet" href="../../../assets/styles/admin/pagination.css">
@endsection

@section(body)

<section>
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
            <?php foreach( $articles['data'] as $article):
                $id = $article->getId()?>
                <tr>
                    <td class="list-content"><input type="checkbox"></td>
                    <td class="list-content"><?= $article->getId()?></td>
                    <td class="list-content"><?= $article->getTitle(); ?></td>
                    <td class="list-content"><?= $article->getCreateDate(); ?></td>
                    <td class="list-content"><?= $article->getEditDate(); ?></td>
                    <td class="list-content"><?= 'ok' ?></td>
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
            <?php /* ?>
                foreach( $articles as $key => $article  ) {
                    <div>
                        <?= $article['id'] ?>
                    </div>
                    <div>
                        <?= $article['title'] ?>
                    </div>
                    <div>
                        <?= $article['date_add'] ?>
                    </div>
                    <div>
                        <?= $article['date_edit'] ?>
                    </div>
                    <div>
                        <?= $article['visible'] ?>
                    </div>
                    <div>
                        <a href="/admin/article/modify/<?= $article['id'] ?>">
                            edit
                        </a>
                        <a href="/admin/article/destroy/<?= $article['id'] ?>">
                            delete
                        </a>
                    </div>
                }
            <?php */ ?>
        </table>
        <div class="pagination-section">
            <ul class="pagination second">
                <li><a href="#">Prev</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#">Next</a></li>
            </ul>
        </div>
    </div>
</section>

@endsection

