@extend(templates/front)

@section(body)
<style>
    input{
        position: relative;
        top: -17px;
    }
</style>
<section>
    <?php
        if (count($sondages) > 0):
    ?>
    <ul class="cards" style="max-width: 50%; margin:auto;">
        <?php
            foreach( $sondages as $sondage):
        ?>
            <li class="cards__item">
                <div class="card">
                    <div class="card__content">
                        <div class="card__title"><?=$sondage->getQuestion();?></div>
                            <p>
                                <br>
                                <form action="@path(frontend_sondage_vote, <?=$sondage->getId();?>)" method="POST">
                                    <label for="option1"><?=$sondage->getOptionOne();?></label><input type="radio" name="option" id="option1" value="1"><br>
                                    <label for="option2"><?=$sondage->getOptionTwo();?></label><input type="radio" name="option" id="option2" value="2"><br>
                                    <?php
                                    if ($sondage->getOptionThree() != ""):
                                        ?>
                                        <label for="option3"><?=$sondage->getOptionThree();?></label><input type="radio" name="option" id="option3" value="3"><br>
                                    <?php
                                    endif;
                                    if ($sondage->getOptionFour() != ""):
                                    
                                        ?>
                                        <label for="option4"><?=$sondage->getOptionFour();?></label><input type="radio" name="option" id="option4" value="4"><br>
                                    <?php
                                    endif;
                                    ?>
                                    <br>
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