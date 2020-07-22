@extend(templates/front)

@section(body)
<style>
    ul input{
        position: relative;
        top: -17px;
    }
    .div-canvas{
        max-width: 500px;
        max-height: 500px;
        margin: auto;
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

                    $nbVotes = [$votesChoixUn, $votesChoixDeux];

                    // Labels declaration
                    $labels = [$sondage->getOptionOne(), $sondage->getOptionTwo()];

                    if ($sondage->getOptionThree() != "") { // If option 3 is present
                        $labels[] = $sondage->getOptionThree();
                        $nbVotes[] = $votesChoixTrois;
                    }
                    if ($sondage->getOptionFour() != "") { // If option 4 is present
                        $labels[] = $sondage->getOptionFour();
                        $nbVotes[] = $votesChoixQuatre;
                    }
        ?>
                    <li class="cards__item">
                        <div class="card">
                            <div class="card__content">
                                <div class="card__title"><?=$sondage->getQuestion();?></div>
                                <div class="div-canvas">
                                    <canvas id="myChart<?=$sondage->getId();?>"></canvas>
                                    <script>
                                        $(document).ready(function () {
                                            var ctx = document.getElementById('myChart<?=$sondage->getId();?>').getContext('2d');
                                            var myChart = new Chart(ctx, {
                                                type: 'pie',
                                                data: {
                                                    labels: <?=json_encode($labels)?>,
                                                    datasets: [{
                                                        label: 'Nombre de votes du sondage',
                                                        data: <?=json_encode($nbVotes)?>,
                                                        backgroundColor: [
                                                            'rgba(255, 99, 132, 0.2)',
                                                            'rgba(54, 162, 235, 0.2)',
                                                            'rgba(255, 206, 86, 0.2)',
                                                            'rgba(75, 192, 192, 0.2)',
                                                        ],
                                                        borderColor: [
                                                            'rgba(255, 99, 132, 1)',
                                                            'rgba(54, 162, 235, 1)',
                                                            'rgba(255, 206, 86, 1)',
                                                            'rgba(75, 192, 192, 1)',
                                                        ],
                                                        borderWidth: 1
                                                    }],
                                                    options: {
                                                        responsive: true
                                                    }
                                                },
                                            });
                                        });
                                    </script>
                                </div>
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