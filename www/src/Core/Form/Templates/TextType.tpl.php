@block(input)
<div class="form-group">
    <label for="{{prefix}}_{{key}}">{{label}}</label>
    <input type="{{type}}"
           id="{{prefix}}_{{key}}"
           class="{{class}} " placeholder="{{placeholder}}"
           name="{{name}}" value="{{value}}" @isRequired(required)>
</div>
@endblock

@block(hidden)
    <input type="hidden" name="input_token_csrf" value="{{value}}" @isRequired(required)>
@endblock