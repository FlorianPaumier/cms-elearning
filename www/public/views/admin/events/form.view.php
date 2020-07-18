@extend(templates/back)

@section(body)

<a href="@path(admin_events_list)" type="button">Liste</a>

<div class="container">

{{ form }}
</div>

@endsection

@section(javascripts)
<script src="/assets/scripts/ckeditor.js"></script>
@endsection