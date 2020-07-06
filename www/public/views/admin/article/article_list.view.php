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
            <tr>
                <td class="list-content list-checkbox">
                    <label>
                        <input type="checkbox">
                    </label>
                </td>
                <td class="list-content list-id">
                    1
                </td>
                <td class="list-content list-title">
                    Article 1
                </td>
                <td class="list-content list-date">
                    10/01/2020
                </td>
                <td class="list-content list-date">
                    10/01/2020
                </td>
                <td class="list-content list-visible">
                    true
                </td>
                <td>
                    <a href="#">
                        edit
                    </a>
                    <a href="#">
                        delete
                    </a>
                </td>
            </tr>
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

