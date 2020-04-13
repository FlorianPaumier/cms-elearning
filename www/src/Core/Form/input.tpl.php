{% block input %}
<div class="form-group">
    <label for="{{prefix}}_{{key}}">{{label}}</label>
    <input type="{{type}}"
           id="{{prefix}}_{{key}}"
           class="{{class}} " placeholder="{{label}}"
           name="{{prefix}}_{{key}}" value="{{value}}" @isRequired(required)>
</div>
{% endblock %}

{% block checkbox %}
<div class="form-group">
    <ul class="tg-list">
        <li class="tg-list-item row">
            <span>{{label}}</span>
            <input class="{{class}} tgl tgl-skewed"
                   type="{{type}}"
                   id="{{prefix}}_{{key}}"placeholder="{{label}}"
                   name="{{prefix}}_{{key}}" value="{{value}}" @isRequired(required)>
            <label class="tgl-btn pl-5 " data-tg-off="OFF" data-tg-on="ON" for="{{prefix}}_{{key}}"></label>
        </li>
    </ul>
</div>
{% endblock %}

{% block textarea %}
    <div class="form-group">
        <label for="{{prefix}}_{{key}}">{{label}}</label>
        <textarea type="text" id="{{prefix}}_{{key}}" class="{{class}}" name="{{prefix}}_{{key}}" @isRequired(required)>{{value}}</textarea>
    </div>
{% endblock %}

{% block button %}
    <button id="{{prefix}}_{{key}}" name="{{prefix}}_{{key}}" type="{{ type }}" class="{{class}}">{{label}}</button>
{% endblock %}

{% block select %}
    <div class="form-group">
        <label for="{{prefix}}_{{key}}">{{label}}</label>
        <select id="{{prefix}}_{{key}}" class="{{type}}" name="{{prefix}}_{{key}}[]" @isRequired(required) {{ multi|isMultiple }}>{{optionsHTML}}</select>
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