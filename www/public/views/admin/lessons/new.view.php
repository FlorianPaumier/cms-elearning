@extend(templates/back)

@section(styles)
<link rel="stylesheet" href="/assets/styles/admin/form.css">
@endsection

@section(body)
<section>
    <a href="@path(admin_lesson_list)" id="add-lesson" class="btn c-blue">Retour</a>
</section>
<section class="col-6">
    {{ form }}
</section>
@endsection

@section(javascripts)
<script src="/assets/scripts/ckeditor.js"></script>
@endsection