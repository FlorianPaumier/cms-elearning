@block(textarea)
<div class="form-group">
    <label for="{{prefix}}_{{key}}">{{label}}</label>
    <textarea type="text" id="{{prefix}}_{{key}}" class="{{class}}" name="{{name}}" @isRequired(required)>{{value}}</textarea>
</div>
@endblock