{{ @View/templates/back|extend }}

@section(body)
<section class="wrapper">
    <div class="login">
        <p class="title">Log in</p>
        {{ form }}
    </div>
    <footer><a target="blank" href="http://boudra.me/">boudra.me</a></footer>

</section>
@endsection