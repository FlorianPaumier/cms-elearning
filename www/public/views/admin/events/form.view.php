@extend(templates/back)

@section(body)

<a href="@path(admin_events_list)" type="button">Liste</a>

<div class="container">

{{ form }}
</div>

@endsection

@section(javascripts)
<script src="https://cdn.ckeditor.com/ckeditor5/17.0.0/classic/ckeditor.js"></script>
<script src="/assets/scripts/ckeditor.js"></script>
@endsection