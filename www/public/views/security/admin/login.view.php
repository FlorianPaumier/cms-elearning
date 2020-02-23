{{ @View/templates/front|extend }}
@section(style)
<link rel="stylesheet" href="assets/styles/login.css">
@endsection

@section(body)
<section class="wrapper">
    <div class="login">
        <p class="title">Log in</p>
        {{ form }}
    </div>
</section>
@endsection

@section(script)
<script type="javascript" src="assets/scripts/login.js"></script>
@endsection