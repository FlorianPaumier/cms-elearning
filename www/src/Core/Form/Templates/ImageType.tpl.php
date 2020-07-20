@block(input)
<div class="form-group">
    <label class="file-upload" for="{{prefix}}_{{key}}">{{label}}</label>
    <input type="file"
           id="{{prefix}}_{{key}}"
           class="{{class}} " placeholder="{{placeholder}}"
           name="{{name}}" @isRequired(required)>

    <?php if("{{value}}"): ?>
        <img src="{{value}}" alt="thumbnail">
    <?php endif; ?>
</div>
@endblock

<!-- @block(input)
<div class="form-group file-upload">
    <label for="{{prefix}}_{{key}}">
        <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add Image</button>
        <div class="image-upload-wrap">
            <input type="file"
                   id="{{prefix}}_{{key}}"
                   class="{{class}} file-upload-input" placeholder="{{placeholder}}"
                   onchange="readURL(this);"
                   name="{{name}}" @isRequired(required)>
            <div class="drag-text">
                <h3>Drag and drop a file or select add Image</h3>
            </div>
        </div>
        <span id="file-button">{{label}}</span>
        <div class="file-upload-content">
            <img class="file-upload-image" src="#" alt="your image" />
            <div class="image-title-wrap">
                <button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
            </div>
        </div>
    </label>
    <?php if("{{value}}"): ?>
        <img src="{{value}}" alt="thumbnail">
    <?php endif; ?>
</div>
@endblock
<script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script>

function readURL(input) {
    console.log(input)
    if (input.files && input.files[0]) {

        var reader = new FileReader();

        reader.onload = function(e) {
            $('.image-upload-wrap').hide();

            $('.file-upload-image').attr('src', e.target.result);
            $('.file-upload-content').show();

            $('.image-title').html(input.files[0].name);
        };

        reader.readAsDataURL(input.files[0]);

    } else {
        removeUpload();
    }
}

function removeUpload() {
    $('.file-upload-input').replaceWith($('.file-upload-input').clone());
    $('.file-upload-content').hide();
    $('.image-upload-wrap').show();
}
$('.image-upload-wrap').bind('dragover', function () {
    $('.image-upload-wrap').addClass('image-dropping');
});
$('.image-upload-wrap').bind('dragleave', function () {
    $('.image-upload-wrap').removeClass('image-dropping');
});

</script> -->