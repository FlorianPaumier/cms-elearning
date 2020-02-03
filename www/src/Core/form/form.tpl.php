{% block input %}
<div class="form-group">
    <label for="{{prefix}}{{key}}">{{label}}</label>
    <input type="{{type}}"
           id="{{prefix}}{{key}}"
           class="{{class}} " placeholder="{{label}}"
           name="{{prefix}}{{key}}" value="{{value}}" {{ required|isRequired }}>
</div>
{% endblock %}

{% block textarea %}
    <div class="form-group">
        <label for="{{prefix}}{{key}}">{{label}}</label>
        <textarea type="text" id="{{prefix}}{{key}}" class="{{class}}" name="{{prefix}}{{key}}" {{ required|isRequired }}>{{value}}</textarea>
    </div>
{% endblock %}

{% block button %}
    <button id="{{prefix}}{{key}}" name="{{prefix}}{{key}}" type="{{type}}" class="{{class}}">{{label}}</button>
{% endblock %}

{% block select %}
    <div class="form-group">
        <label for="{{prefix}}{{key}}">{{label}}</label>
        <select id="{{prefix}}{{key}}" class="{{type}}" name="{{prefix}}{{key}}[]" {{ required|isRequired }} {{ multi|isMultiple }}>{{optionsHTML}}</select>
    </div>
{% endblock %}

{% block errors %}
    <div class="invalid-feedback">{{error}}</div>
{% endblock %}

{% block option %}
    <option value="{{key}}" {{selected|isSelected}}>{{value}}</option>
{% endblock %}

{% block captcha %}
<input type="text" value="Captcha">
{% endblock %}