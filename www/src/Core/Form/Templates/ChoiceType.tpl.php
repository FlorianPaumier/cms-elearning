@block(select)
<div class="form-group">
    <label for="{{prefix}}_{{key}}">{{label}}</label>
    <select id="{{prefix}}_{{key}}" class="{{type}}" name="{{name}}" @isRequired(required) {{ multi|isMultiple }}>{{optionsHTML}}</select>
</div>
@endblock

@block(option)
<option value="{{key}}" {{selected|isSelected}}>{{value}}</option>
@endblock