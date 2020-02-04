{{ @View/templates/back|extend }}
@section(style)
<link type="text/css" href="assets/styles/login.css"/>
@endsection

@section(body)
<div class="container">

    {{ form }}

</div>
@endsection

@section(script)
<script type="javascript" src="assets/scripts/login.js"></script>
@endsection