@extend(templates/back)

@section(styles)
@endsection

@section(body)
<section>
    <a href="@path(admin_category_new)" id="add-article" class="btn c-blue">Ajout</a>
</section>
<section>
    <table class="table">
        <thead>
        <tr>
            <th>Id</th>
            <th>category</th>
            <th>action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach( $categories['data'] as $category):
            $id = $category->getId()?>
            <tr>
                <td><?= $category->getId()?></td>
                <td><?= $category->getCategory(); ?></td>
                <td class="row">
                    <a href="admin/category/edit/<?= $id; ?>">
                        <button class="btn btn-succes">Modifier</button>
                    </a>
                    <form action="/admin/category/delete<?= $id; ?>">
                        <button id="delete-lesson" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>

@endsection

