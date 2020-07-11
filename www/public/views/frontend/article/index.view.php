@extend(templates/front)

@section(body)

<section>
    <div>
        <table>
            <tr>
                <th>id</th>
                <th>title</th>
                <th>date add</th>
                <th>date edit</th>
            </tr>
            <?php foreach( $articles['data'] as $article):
                $id = $article->getId()?>
                <tr>
                    <td class="list-content"><?= $article->getId()?></td>
                    <td class="list-content"><?= $article->getTitle(); ?></td>
                    <td class="list-content"><?= $article->getCreateDate(); ?></td>
                    <td class="list-content"><?= $article->getEditDate(); ?></td>
                </tr>
            <?php endforeach; ?>
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

