@block(input)
<div class="form-group">
    <label for="{{prefix}}_{{key}}">{{label}}</label>
    <input type="file"
           id="{{prefix}}_{{key}}"
           class="{{class}} " placeholder="{{placeholder}}"
           name="{{name}}" @isRequired(required)>

    <?php if("{{value}}"): ?>
        <img src="{{value}}" alt="thumbnail">
    <?php endif; ?>
</div>
@endblock