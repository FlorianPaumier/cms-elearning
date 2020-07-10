@extend(templates/front)

@section(body)
<section>
    <?php
        if (count($questions) > 0):
    ?>
    <ul class="cards" style="max-width: 50%; margin:auto;">
        <?php
            foreach( $questions as $question):
        ?>
            <li class="cards__item">
                <div class="card">
                    <div class="card__content">
                        <div class="card__title"><?=$question->getQuestion();?></div>
                            <p class="padding-top:50px; padding-bottom: 50px;">
                                <form action="" method="POST">
                                    <label for="option1"><?=$question->getOptionOne();?></label><input type="radio" name="option" id="option1" value="1"><br>
                                    <label for="option2"><?=$question->getOptionTwo();?></label><input type="radio" name="option" id="option2" value="2"><br>
                                    <?php
                                    if ($question->getOptionThree() != ""):
                                        ?>
                                        <label for="option3"><?=$question->getOptionThree();?></label><input type="radio" name="option" id="option3" value="3"><br>
                                    <?php
                                    endif;
                                    if ($question->getOptionFour() != ""):
                                        ?>
                                        <label for="option4"><?=$question->getOptionFour();?></label><input type="radio" name="option" id="option4" value="4"><br>
                                    <?php
                                    endif;
                                    ?>
                                  <input type="submit" value="Voter !">
                                </form>
                            </p>
                        </div>
                    </div>
                </div>
            </li>
        <?php
            endforeach;
        ?>
    </ul>
    <?php
        else:
    ?>
        <p align="center">Aucun sondage disponible.</p>
    <?php
        endif;
    ?>
</section>
@endsection