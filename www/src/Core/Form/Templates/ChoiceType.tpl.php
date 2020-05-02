@block(select)
<div class="form-group">
    <label for="{{prefix}}_{{key}}">{{label}}</label>
    <select id="{{prefix}}_{{key}}" class="{{type}}" name="{{name}}" @isRequired({{ required }})>{{optionsHTML}}</select>
</div>
@endblock

@block(option)
<option value="{{key}}" @isSelected({{ key }})>{{value}}</option>
@endblock