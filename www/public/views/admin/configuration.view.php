@extend(templates/back)

@section(body)

<section class="container">
    {{ form }}
</section>
@endsection

@section(javascripts)
<script>
    $(document).ready(function () {
        $("#app_form_server_mail_test").click(function () {
            fetch("@path(admin_test_mailer)")
            .then(res => {
                return res.json()
            }).then(res => {
                if (res.result) {
                    alert("Le mailer fonctionne")
                } else {
                    alert("Une erreur est survenue. Vérifier vos identifiant ou contacter le support")
                }
            })
        })
    })
</script>
@endsection