@extend(templates/front)

@section(style)
<link rel="stylesheet" href="/assets/styles/frontend/forgetPassword.css">
@endsection

@section(body)
<section class="wrapper">
    <div class="forgetPass">
        {{ form }}
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