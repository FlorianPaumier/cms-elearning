{% block input %}
<div class="form-group">
    <label for="{{prefix}}{{key}}">{{label}}</label>
    <input type="{{type}}"
           id="{{prefix}}{{key}}"
           class="{{ options|getClass }} " placeholder="{{label}}"
           name="{{prefix}}{{key}}" value="{{value}}" {{required}}>
    {{ options|errorFeedback }}
</div>
{% endblock %}

{% block textarea %}
    <div class="form-group">
        <label for="{{prefix}}{{key}}">{{label}}</label>
        <textarea type="text" id="{{prefix}}{{key}}" class="{{ options|getClass }}" name="{{prefix}}{{key}}" {{required}}>{{prefix}}{{key}}</textarea>
        {{ options|errorFeedback }}
    </div>
{% endblock %}

{% block button %}
    <button id="{{prefix}}{{key}}" name="{{prefix}}{{key}}" type="{{ options|getType }}" class="{{ options|getClass }}">{{label}}</button>
{% endblock %}

{% block select %}
    <div class="form-group">
        <label for="{{prefix}}{{key}}">{$label}</label>
        <select id="{{prefix}}{{key}}" class="{{ options|getType }}" name="{{prefix}}{{key}}[]" {{required}} {{multi}}>{{optionsHTML}}</select>
        {{ options|errorFeedback }}
    </div>
{% endblock %}

{% block errors %}
    <div class="invalid-feedback"> {{error}}</div>
{% endblock %}

{% block option %}
    <option value="{{key}}" {{selected}}>{{value}}</option>
{% endblock %}