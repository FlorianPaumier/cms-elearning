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
                        <div class="card__content card-dashboard-content active" id="show_user" style="display: none">
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
                                            let max=0;
                                            const stats = <?= json_encode($statsUser, true) ?>;
                                            let keys=[], values=[];
                                            for(let stat in stats['data']){
                                                keys.push(stat)
                                                values.push(stats['data'][stat])



                                            }
                                            let ctx = $('#data_user');
                                            var myLineChart = new Chart(ctx, {
                                                type: 'line',
                                                data: {
                                                    labels: keys,
                                                    datasets:[
                                                        {
                                                            label:'nombre d\'utilisateur',
                                                            data: values,
                                                            fill: false,
                                                            "borderColor": "rgb(75, 192, 192)", "lineTension": 1
                                                        }

                                                    ]

                                                },
                                                options: {
                                                    scales: {
                                                        yAxes: [{
                                                            ticks: {
                                                                max: Math.max(...values),
                                                                min: 0,
                                                                stepSize: 1
                                                            }
                                                        }]
                                                    }
                                                }

                                            });
                                        })
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="card__content card-dashboard-content active" id="show_lesson" style="display: none">
                            <div>
                                <p class="card__text card-dashboard-content-text">Cours</p>
                                <p class="card__text card-dashboard-content-price"><?= $statsLesson['total'] ?></p>
                            </div>
                            <div>
                                <div class="canva-div">
                                    <canvas id="data_lesson"></canvas>
                                    <script>
                                        $(document).ready(function ()
                                        {
                                            let max=0;
                                            const stats = <?= json_encode($statsLesson, true) ?>;
                                            let keys=[], values=[];
                                            for(let stat in stats['data']){
                                                keys.push(stat)
                                                values.push(stats['data'][stat])



                                            }
                                            let ctx = $('#data_lesson');
                                            var myLineChart = new Chart(ctx, {
                                                type: 'line',
                                                data: {
                                                    labels: keys,
                                                    datasets:[
                                                        {
                                                            label:'nombre de cours',
                                                            data: values,
                                                            fill: false,
                                                            "borderColor": "rgb(75, 192, 192)", "lineTension": 1
                                                        }

                                                    ]

                                                },
                                                options: {
                                                    scales: {
                                                        yAxes: [{
                                                            ticks: {
                                                                max: Math.max(...values),
                                                                min: 0,
                                                                stepSize: 1
                                                            }
                                                        }]
                                                    }
                                                }

                                            });
                                        })
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="card__content card-dashboard-content active" id="show_article" style="display: none">
                            <div>
                                <p class="card__text card-dashboard-content-text">Articles</p>
                                <p class="card__text card-dashboard-content-price"><?= $statsArticle['total'] ?></p>
                            </div>
                            <div>
                                <div class="canva-div">
                                    <canvas id="data_article"></canvas>
                                    <script>
                                        $(document).ready(function ()
                                        {
                                            let max=0;
                                            const stats = <?= json_encode($statsArticle, true) ?>;
                                            let keys=[], values=[];
                                            for(let stat in stats['data']){
                                                keys.push(stat)
                                                values.push(stats['data'][stat])



                                            }
                                            let ctx = $('#data_article');
                                            var myLineChart = new Chart(ctx, {
                                                type: 'line',
                                                data: {
                                                    labels: keys,
                                                    datasets:[
                                                        {
                                                            label:'nombre d\'article',
                                                            data: values,
                                                            fill: false,
                                                            "borderColor": "rgb(75, 192, 192)", "lineTension": 1
                                                        }

                                                    ]

                                                },
                                                options: {
                                                    scales: {
                                                        yAxes: [{
                                                            ticks: {
                                                                max: Math.max(...values),
                                                                min: 0,
                                                                stepSize: 1
                                                            }
                                                        }]
                                                    }
                                                }

                                            });
                                        })
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="card__content card-dashboard-content active" id="shwo_contact" style="display: none">
                            <div>
                                <p class="card__text card-dashboard-content-text">Contacts</p>
                                <p class="card__text card-dashboard-content-price"><?= $statsContact['total'] ?></p>
                            </div>
                            <div>
                                <div class="canva-div">
                                    <canvas id="data_contact"></canvas>
                                    <script>
                                        $(document).ready(function ()
                                        {
                                            let max=0;
                                            const stats = <?= json_encode($statsContact, true) ?>;
                                            let keys=[], values=[];
                                            for(let stat in stats['data']){
                                                keys.push(stat)
                                                values.push(stats['data'][stat])



                                            }
                                            let ctx = $('#data_contact');
                                            var myLineChart = new Chart(ctx, {
                                                type: 'line',
                                                data: {
                                                    labels: keys,
                                                    datasets:[
                                                        {
                                                            label:'nombre de contact',
                                                            data: values,
                                                            fill: false,
                                                            "borderColor": "rgb(75, 192, 192)", "lineTension": 1
                                                        }

                                                    ]

                                                },
                                                options: {
                                                    scales: {
                                                        yAxes: [{
                                                            ticks: {
                                                                max: Math.max(...values),
                                                                min: 0,
                                                                stepSize: 1
                                                            }
                                                        }]
                                                    }
                                                }

                                            });
                                        })
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="cards">
                <script>
                    function user_button() {
                        var article = document.getElementById("show_user");

                        if (article.style.display === "none"){
                            article.style.display = "block";
                        }else{
                            article.style.display = "none";
                        }
                    }

                    function article_button() {
                        var article = document.getElementById("show_article");

                        if (article.style.display === "none"){
                            article.style.display = "block";
                        }else{
                            article.style.display = "none";
                        }
                    }

                    function lesson_button() {
                        var article = document.getElementById("show_lesson");

                        if (article.style.display === "none"){
                            article.style.display = "block";
                        }else{
                            article.style.display = "none";
                        }
                    }

                    function contact_button() {
                        var article = document.getElementById("shwo_contact");

                        if (article.style.display === "none"){
                            article.style.display = "block";
                        }else{
                            article.style.display = "none";
                        }
                    }




                </script>
                <div class="cards__item cards-multicards">
                    <div class="card">
                        <div class="card__content card-multicards-content">
                            <div class="card__title card-multicards-content-title">Utilisateurs</div>
                            <a  href="#" onclick="user_button()" class="card__text card-multicards-content-text"><?= $statsUser['total'] ?></a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card__content card-multicards-content">
                            <div class="card__title card-multicards-content-title">Articles</div>
                            <a  href="#" onclick="article_button()" class="card__text card-multicards-content-text"><?= $statsArticle['total'] ?></a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card__content card-multicards-content">
                            <div class="card__title card-multicards-content-title">Cours</div>
                            <a  href="#" onclick="lesson_button()" class="card__text card-multicards-content-text"><?= $statsLesson['total'] ?></a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card__content card-multicards-content">
                            <div class="card__title card-multicards-content-title">Contacts</div>
                            <a  href="#" onclick="contact_button()" class="card__text card-multicards-content-text"><?= $statsContact['total'] ?></a>
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