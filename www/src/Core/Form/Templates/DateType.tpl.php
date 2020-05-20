@block(date)
<div class="form-group">
    <label for="{{prefix}}_{{key}}">{{label}}</label>
    <input type="date"
           id="{{prefix}}_{{key}}"
           class="{{class}} datetime-picker" placeholder="{{label}}"
           name="{{name}}" value="{{value}}" @isRequired(required)>
</div>
@endblock