@block(radio)
<div class="form-group">
    <label for="{{prefix}}_{{key}}">{{label}}</label>
    <input type="radio"
           id="{{prefix}}_{{key}}"
           class="{{class}} " placeholder="{{placeholder}}"
           name="{{name}}" value="{{value}}" @isRequired(required)>
</div>
@endblock

@block(checkbox)
<div class="form-group">
    <label class="switch" for="{{prefix}}_{{key}}">{{label}}
        <input type="hidden"
               id="{{prefix}}_{{key}}"
               class="{{class}} " placeholder="{{placeholder}}"
               name="{{name}}" value="null">
        <input type="checkbox"
               id="{{prefix}}_{{key}}"
               class="{{class}} " placeholder="{{placeholder}}"
               name="{{name}}" value="{{value}}" @isRequired(required) <?= $selected ? "checked" : "" ?>>

        <div class="slider round"></div>
    </label>
</div>
@endblock

@block(inputs)
<div class="container">
    <label for="{{prefix}}_{{key}}">{{label}}</label>
    {{inputs}}
</div>
@endblock