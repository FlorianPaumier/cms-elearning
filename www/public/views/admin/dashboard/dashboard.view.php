@extend(templates/back)
@section(body)

<div class="card">
    <div class="left-side">
        <div>
            <div class="cards">
                <div class="cards__item cards-welcome">

                    <div class="card">
                        <div class="card__content card-welcome-content">



                            <p>Salut <?= $user->getUsername() ?>,</p>
                            <div class="card__title card-welcome-content-title">Bienvenu sur CMS E-LEARNING</div><br>
                            <p class="card__text card-welcome-content-text">Ceci est du contenu de description</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div>
            <div class="cards">
                <div class="cards__item cards-dashboard">
                    <div class="card">
                        <div class="card__content card-dashboard-content active">
                            <div>
                                <p class="card__text card-dashboard-content-text">Utilisateurs</p>
                                <p class="card__text card-dashboard-content-price"><?= $statsUser['total'] ?></p>
                            </div>
                            <div>
                                <div class="canva-div">
                                    <canvas id="data_user"></canvas>
                                    <script>
                                        $(document).ready(function ()
                                        {
                                            const stat = JSON.parse(<?= json_encode($statsUser, true) ?>);
                                            console.log(stat);
                                            var myLineChart = new Chart(ctx, {
                                                type: 'line',
                                                data: data,
                                                options: options
                                            });
                                        })
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="card__content card-dashboard-content">
                            <div>
                                <p class="card__text card-dashboard-content-text">Profits</p>
                                <p class="card__text card-dashboard-content-price">3092 €</p>
                            </div>
                            <div>
                                <div class="canva-div">
                                    <canvas id="data"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card__content card-dashboard-content">
                            <div>
                                <p class="card__text card-dashboard-content-text">Profits</p>
                                <p class="card__text card-dashboard-content-price">3092 €</p>
                            </div>
                            <div>
                                <div class="canva-div">
                                    <canvas id="data"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card__content card-dashboard-content">
                            <div>
                                <p class="card__text card-dashboard-content-text">Profits</p>
                                <p class="card__text card-dashboard-content-price">3092 €</p>
                            </div>
                            <div>
                                <div class="canva-div">
                                    <canvas id="data"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="cards">
                <div class="cards__item cards-multicards">
                    <div class="card">
                        <div class="card__content card-multicards-content">
                            <div class="card__title card-multicards-content-title">Profits</div>
                            <p class="card__text card-multicards-content-text">1000€</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card__content card-multicards-content">
                            <div class="card__title card-multicards-content-title">Utilisateurs</div>
                            <p class="card__text card-multicards-content-text"><?= $statsUser['total'] ?></p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card__content card-multicards-content">
                            <div class="card__title card-multicards-content-title">Vidéos en ligne</div>
                            <p class="card__text card-multicards-content-text">1000</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card__content card-multicards-content">
                            <div class="card__title card-multicards-content-title">Membres inscrit</div>
                            <p class="card__text card-multicards-content-text">1000</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="right-side">
        <div class="cards">
            <div class="cards__item cards-activities">
                <div class="card">
                    <div class="card__content card-activities-content">
                        <div class="card__title card-activities-content-title">Activities</div>
                        <div>
                            <div class="card-activities-content-text">
                                <div class="activities-image">
                                    <img class="cercle card-activities-content-image">
                                </div>
                                <div class="activities-content">
                                    <a href="" style="text-decoration: none"><span class="card-activities-content-user">Name</span></a>
                                    <span class="card-activities-content-time">à 20h</span>
                                    <span class="card-activities-content-description">Activity</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section(javascripts)
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>

<script src="assets/scripts/global.js"></script>
<script src="assets/dist/fontawesome/js/all.min.js"></script>
<script>
    var ctx = document.getElementById('data').getContext("2d");
    ctx.canvas.width = 400;
    ctx.canvas.height = 90;
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                "0",
                "1",
                "2",
                "3",
                "4",
                "5",
                "6",
                "7",
                "8",
                "9",
                "10",
                "11",
                "12",
                "13",
                "14",
                "15",
                "16",
                "17",
                "18",
                "19",
                "20",
                "21",
                "22",
                "23",
            ],
            datasets: [{
                data: [0, 100, 18,12,15,15,42,25,66,53,56,59,32,15,23,16,12,15,99,100,39,82,34,56],
                backgroundColor: [
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                ],
                hoverBackgroundColor: [
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                    "#364885",
                ]
            }]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    display: true,
                    ticks: {
                        min: 0
                    }
                }],
                yAxes: [{
                    display: true
                }],
            },
            responsive: true
        }
    });

</script>
@endsection