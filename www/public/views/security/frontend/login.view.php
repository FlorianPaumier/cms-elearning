@extend(templates/front)

@section(style)
<link rel="stylesheet" href="assets/styles/admin/login.css">
@endsection

@section(body)
<section class="wrapper">
    <a href="#" id="link">Link</a>
    <div class="login">
        <p class="title">Log in</p>
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