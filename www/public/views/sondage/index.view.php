@extend(templates/front)

@section(body)
<section>
    <table class="table" width="80%" style="margin: auto;">
        <tbody>
        <?php
        foreach( $questions as $question):
            ?>
            <tr>
                <td>
                    <button type="button" class="collapsible"><?= $question->getQuestion(); ?></button>
                    <div class="content">
                        <article>
                            <h1><?=$question->getQuestion();?></h1>
                            <aside>
                                <?=$question->getDate();?>
                            </aside>
                        </article>
                    </div>
                </td>
            </tr>
        <?php
        endforeach;
        ?>
        </tbody>
    </table>
</section>
@endsection