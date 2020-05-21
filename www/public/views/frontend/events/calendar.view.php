@extend(templates/front)

@section(style)

<link rel="stylesheet" href="/assets/styles/frontend/events.css">

@endsection

@section(body)

    <section id="container-calendar"></section>

    @include(partials/modal)
@endsection

@section(javascript)
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.25.3/moment-with-locales.min.js"></script>
<script src="/assets/scripts/core/calendar/calendar.js"></script>

<script>
    $(document).ready(function() {
        let calendar = new Calendar("#container-calendar",{{events}})
        calendar.render();
    })
</script>
@endsection