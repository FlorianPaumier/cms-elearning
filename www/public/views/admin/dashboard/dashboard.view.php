@extend(templates/back)
@section(styles)
<link href="/assets/admin/dashboard.css"/>
@endsection
@section(body)

<section id="dashboard">
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
                                    //    $(document).ready(function ()
                                    //    {
                                    //        let max=0;
                                    //        const stats = <?//= json_encode($statsUser, true) ?>//;
                                    //        let keys=[], values=[];
                                    //        for(let stat in stats['data']){
                                    //            keys.push(stat)
                                    //            values.push(stats['data'][stat])
                                    //
                                    //
                                    //
                                    //        }
                                    //        let ctx = $('#data_user');
                                    //        var myLineChart = new Chart(ctx, {
                                    //            type: 'line',
                                    //            data: {
                                    //                labels: keys,
                                    //                datasets:[
                                    //                    {
                                    //                        label:'nombre d\'utilisateur',
                                    //                        data: values,
                                    //                        fill: false,
                                    //                        "borderColor": "rgb(75, 192, 192)", "lineTension": 1
                                    //                    }
                                    //
                                    //                ]
                                    //
                                    //            },
                                    //            options: {
                                    //                scales: {
                                    //                    yAxes: [{
                                    //                        ticks: {
                                    //                            max: Math.max(...values),
                                    //                            min: 0,
                                    //                            stepSize: 1
                                    //                        }
                                    //                    }]
                                    //                }
                                    //            }
                                    //
                                    //        });
                                    //    })
                                    //</script>
                                </div>
                            </div>
                        </div>
                        <div class="card__content card-dashboard-content active">
                            <div>
                                <p class="card__text card-dashboard-content-text">Cours</p>
                                <p class="card__text card-dashboard-content-price"><?= $statsLesson['total'] ?></p>
                            </div>
                            <div>
                                <div class="canva-div">
                                    <canvas id="data_lesson"></canvas>
                                    <script>
                                        //$(document).ready(function ()
                                        //{
                                        //    let max=0;
                                        //    const stats = <?//= json_encode($statsLesson, true) ?>//;
                                        //    let keys=[], values=[];
                                        //    for(let stat in stats['data']){
                                        //        keys.push(stat)
                                        //        values.push(stats['data'][stat])
                                        //
                                        //
                                        //
                                        //    }
                                        //    let ctx = $('#data_lesson');
                                        //    var myLineChart = new Chart(ctx, {
                                        //        type: 'line',
                                        //        data: {
                                        //            labels: keys,
                                        //            datasets:[
                                        //                {
                                        //                    label:'nombre de cours',
                                        //                    data: values,
                                        //                    fill: false,
                                        //                    "borderColor": "rgb(75, 192, 192)", "lineTension": 1
                                        //                }
                                        //
                                        //            ]
                                        //
                                        //        },
                                        //        options: {
                                        //            scales: {
                                        //                yAxes: [{
                                        //                    ticks: {
                                        //                        max: Math.max(...values),
                                        //                        min: 0,
                                        //                        stepSize: 1
                                        //                    }
                                        //                }]
                                        //            }
                                        //        }
                                        //
                                        //    });
                                        //})
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="card__content card-dashboard-content active">
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
</section>
@endsection
@section(javascripts)


<!-- Core plugin JavaScript-->


<script src="assets/scripts/global.js"></script>
<script src="assets/dist/fontawesome/js/all.min.js"></script>

@endsection