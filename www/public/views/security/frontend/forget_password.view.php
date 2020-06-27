@extend(templates/front)

@section(style)
<link rel="stylesheet" href="/assets/styles/frontend/forgetPassword.css">
@endsection

@section(body)
<section class="wrapper">
    <div class="forgetPass">
        <div class="text-center">
            <h1 class="h4 text-gray-900 mb-2">Mot de passe oublié ?</h1>
            <p class="mb-4">Il vous suffit d'entrer votre adresse email ci-dessous et nous vous enverrons un lien pour réinitialiser votre mot de passe !</p>
        </div>
        {{ form }}
        <hr>
        <div class="text-center">
            <a class="small" href="@path(app_user_register)"><strong>Créer un compte!</strong></a>
        </div>
        <div class="text-center">
            <a class="small" href="@path(app_user_login)"><strong>Vous avez déjà un compte ? Connectez-vous !</strong></a>
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