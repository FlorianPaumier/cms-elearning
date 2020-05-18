@extend(templates/front)

@section(body)
<section>
    <table class="table">
        <thead>
        <tr>
            <th>Questions</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach( $questions as $question):
            ?>
            <tr>
                <td><?= $question->getQuestion(); ?></td>
                <td>
                    <a href="/faq/show/<?=$question->getId()?>">
                        <button id="edit-faq" class="btn btn-info">Afficher</button>
                    </a>
                </td>
            </tr>
        <?php
        endforeach;
        ?>
        </tbody>
    </table>
</section>
@endsection