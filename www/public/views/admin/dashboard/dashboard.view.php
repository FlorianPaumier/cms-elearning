{{ @View/admin/partials/sidebar|include }}
{{ @View/admin/partials/titlebar|include }}
<link rel="stylesheet" href="../../../assets/styles/dashboard.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<div class="card">
    <div class="left-side">
        <div>
            <div class="cards">
                <div class="cards__item cards-welcome">
                    <div class="card">
                        <div class="card__content card-welcome-content">
                            <p class="card__text card-welcome-content-text">Salut Jean,</p>
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
                        <div class="card__content card-dashboard-content">
                            <div>
                                <p class="card__text card-dashboard-content-text">Profits</p>
                                <p class="card__text card-dashboard-content-price">3092 €</p>
                            </div>
                            <div>
                                <div class="date-selector">
                                    <i class="fas fa-caret-left"></i>
                                    15 janvier
                                    <i class="fas fa-caret-right"></i>
                                </div>
                                <ul class="time">
                                    <li><button>Hour</button></li>
                                    <li><button>Day</button></li>
                                    <li><button>Week</button></li>
                                    <li><button>Month</button></li>
                                    <li><button>Year</button></li>
                                </ul>
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
                            <div class="card__title card-multicards-content-title">Visiteurs</div>
                            <p class="card__text card-multicards-content-text">1000</p>
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