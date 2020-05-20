@extend(templates/front)

@section(style)

<style>
    #container-calendar{
        width: 90vw;
        margin: auto;
    }
    .calendar-header {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .row{
        display: flex;
        flex-direction: row;
        justify-content: end;
    }

    .header-day {
        min-width: 5vw;
        text-align: center;
    }
    .day {
        width: 5vw;
        height: 5vh;
        border: 1px solid black;
        z-index: 0;
    }

    .event {
        z-index: 3;
        background-color: red;
    }

    .today {
        background-color: rgba(0,0,100, 0.5);
    }
</style>

@endsection

@section(body)

    <section id="container-calendar"></section>
@endsection

@section(javascript)
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.25.3/moment-with-locales.min.js"></script>
<script src="/assets/scripts/core/calendar/calendar.js"></script>

<script>
    $(document).ready(function() {
        let calendar = new Calendar("#container-calendar");
        calendar.render();
    })
</script>
@endsection