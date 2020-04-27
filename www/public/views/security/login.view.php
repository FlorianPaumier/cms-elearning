@extend(templates/front)

@section(body)

<div class="container">
    <a href="#" id="link">Link</a>
    {{ form }}
    <hr>
     <div class="text-center">
         <a class="small" href="forget_password@path(app_forget_password)">Forget Password?</a>
 </div>
</div>
@endsection

@section(javascripts)

<script type="javascript" src="assets/scripts/login.js"></script>
@endsection
