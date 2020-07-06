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
        <a href="{{ app_home|path }}" class="btn btn-google btn-user btn-block">
            <i class="fab fa-google fa-fw"></i><strong>S'inscrire avec Google</strong>
        </a>
        <a href="{{ app_home|path }}" class="btn btn-facebook btn-user btn-block">
            <i class="fab fa-facebook-f fa-fw"></i><strong>S'inscrire avec Facebook</strong>
        </a>
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