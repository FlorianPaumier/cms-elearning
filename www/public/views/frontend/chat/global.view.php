@extend(templates/front)

@section(styles)
<link type="text/css" rel="stylesheet" href="../../../assets/styles/frontend/chat.css">
@endsection

@section(javascript)
<script src="/assets/scripts/chat.js"></script>
@endsection

@section(body)

@include(frontend/chat/partials/sidebar)
@include(frontend/chat/partials/content)

@endsection