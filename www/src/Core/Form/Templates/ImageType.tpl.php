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

<script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
