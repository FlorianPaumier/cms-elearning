@extend(templates/install)

@section(body)
<section class="container">
    <div id="wrapper">
        <h1>{{ title }}</h1>
        {{ form }}
    </div>
</section>

@endsection