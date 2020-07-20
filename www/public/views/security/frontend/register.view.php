@extend(templates/front)

@section(style)
<link rel="stylesheet" href="/assets/styles/frontend/register.css">
@endsection

@section(body)
<section class="wrapper">
    <a href="#" id="link">Link</a>
    <div class="register">
        <p class="title">S'incrire</p>
        {{ form }}

        <div class="text-center">
            <a class="small" href=" @path(app_user_login)"><strong>Vous avez déjà un compte ? Connectez-vous !</strong></a>
        </div>
        <hr>

    </div>
</section>
@endsection

@section(javascript)
<script>

    let item = document.getElementById("link");
    console.log(item.style);
</script>
<script type="javascript" src="assets/scripts/login.js"></script>
@endsection