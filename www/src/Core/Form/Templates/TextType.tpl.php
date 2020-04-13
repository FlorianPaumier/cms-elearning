{% block input %}
<div class="form-group">
    <label for="{{prefix}}_{{key}}">{{label}}</label>
    <input type="{{type}}"
           id="{{prefix}}_{{key}}"
           class="{{class}} " placeholder="{{label}}"
           name="{{name}}" value="{{value}}" @isRequired(required)>
</div>
{% endblock %}