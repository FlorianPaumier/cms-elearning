{{ @View/partials/header|include }}
{{ @View/admin/partials/sidebar|include }}
{{ @View/admin/partials/titlebar|include }}
<link rel="stylesheet" href="../../../assets/styles/dashboard.css">
<div class="card">
    <div class="card-left">
        <div class="card card-welcome">
            Welcome card
            <div></div>
        </div>
        <div class="card card-stat">
            Card with chartjs
        </div>

        <div class="card card-multiple">
            <div class="card-multiple-1"></div>
        </div>
    </div>
    <div class="card-right">
        <div class=" card card-activity">
            Activity Card
        </div>
        <div>
            <button class="btn btn-danger">
                orange
            </button>
            orange
        </div>
    </div>
</div>
{{ @View/partials/modal|include }}
{{ @View/partials/footer|include }}

