@extend(templates/front)

@section(style)
<link rel="stylesheet" href="/assets/styles/frontend/login.css">
@endsection

@section(body)
<section class="wrapper">
    <a href="#" id="link">Link</a>
    <div class="login">
        <p class="title">Se connecter</p>
        {{ form }}
        <hr>
        <div class="text-center">
            <a class="small" href="@path(app_user_register)"><strong>Créer un compte!</strong></a>
        </div>
        <div class="text-center">
            <a class="small" href=" @path(app_user_forget_password)"><strong>Mot de passe oublié</strong></a>
        </div>
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