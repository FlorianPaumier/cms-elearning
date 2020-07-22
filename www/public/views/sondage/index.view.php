@extend(templates/front)

@section(body)
<style>
    ul input{
        position: relative;
        top: -17px;
    }
</style>
<section>
    <?php
        // If there is at least one survey
        if (count($sondages) > 0):
    ?>
    <ul class="cards" style="max-width: 50%; margin:auto;">
        <?php
            foreach($sondages as $sondage):
                // Retrieves the survey vote of the connected user
                $voteUser = $sondageVoteRepository->select('choix')->where('user_id = '.$userId)->andWhere('sondage_id = '.$sondage->getId())->fetch();

                // If he voted
                if (!is_null($voteUser)){
                    // Retrieves the number of votes for each choice in the survey
                    $votesChoixUn = $sondageVoteRepository->where('sondage_id = '.$sondage->getId())->andWhere('choix = 1')->count();
                    $votesChoixDeux = $sondageVoteRepository->where('sondage_id = '.$sondage->getId())->andWhere('choix = 2')->count();
                    $votesChoixTrois = $sondageVoteRepository->where('sondage_id = '.$sondage->getId())->andWhere('choix = 3')->count();
                    $votesChoixQuatre = $sondageVoteRepository->where('sondage_id = '.$sondage->getId())->andWhere('choix = 4')->count();

                    // The total number of votes
                    $votes = $votesChoixUn+$votesChoixDeux+$votesChoixTrois+$votesChoixQuatre;
        ?>
                    <li class="cards__item">
                        <div class="card">
                            <div class="card__content">
                                <div class="card__title"><?=$sondage->getQuestion();?></div>
                                <p>
                                    <br>
                                    <label><?=$sondage->getOptionOne();?> ( <?=($votesChoixUn/($votes))*100?>% )</label><input type="radio" disabled <?php echo $voteUser->getChoix() == 1 ? "checked" : ""?>><br>
                                    <label><?=$sondage->getOptionTwo();?> ( <?=($votesChoixDeux/($votes))*100?>% )</label><input type="radio" disabled <?php echo $voteUser->getChoix() == 2 ? "checked" : ""?>><br>
                                    <?php
                                    if ($sondage->getOptionThree() != ""): // If there is a third choice
                                        ?>
                                        <label><?=$sondage->getOptionThree();?> ( <?=($votesChoixTrois/($votes))*100?>% )</label><input type="radio" disabled <?php echo $voteUser->getChoix() == 3 ? "checked" : ""?>><br>
                                    <?php
                                    endif;
                                    if ($sondage->getOptionFour() != ""): // If there is a fourth choice
                                        ?>
                                        <label><?=$sondage->getOptionFour();?> ( <?=($votesChoixQuatre/($votes))*100?>% )</label><input type="radio" disabled <?php echo $voteUser->getChoix() == 4 ? "checked" : ""?>><br>
                                    <?php
                                    endif;
                                    ?>
                                </p>
                            </div>
                        </div>
                    </li>
        <?php
                } else { // If he did not vote
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
                                    if ($sondage->getOptionThree() != ""): // If there is a third choice
                                        ?>
                                        <label for="option3"><?=$sondage->getOptionThree();?></label><input type="radio" name="option" id="option3" value="3"><br>
                                    <?php
                                    endif;
                                    if ($sondage->getOptionFour() != ""): // If there is a fourth choice
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
                }
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