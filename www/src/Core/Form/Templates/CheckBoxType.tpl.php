{% block checkbox %}
<div class="form-group">
    <ul class="tg-list">
        <li class="tg-list-item row">
            <span>{{label}}</span>
            <input class="{{class}} tgl tgl-skewed"
                   type="{{type}}"
                   id="{{prefix}}_{{key}}" placeholder="{{label}}"
                   name="{{name}}" value="{{value}}" @isRequired(required)>
            <label class="tgl-btn pl-5 " data-tg-off="OFF" data-tg-on="ON" for="{{prefix}}_{{key}}"></label>
        </li>
    </ul>
</div>
{% endblock %}