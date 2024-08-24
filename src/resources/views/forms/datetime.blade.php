<div class="form-group">
	<label>{!! $label !!}</label>
    <div class='input-group datetimepicker'>
        <input class="form-control {{ isset($class) ? $class : '' }}" name="{{ $name }}" type="text" placeholder="{{ isset($placeholder) ? $placeholder : null }}" value="{{ isset($value) ? $value : (is_null(old($name)) ? null : old($name)) }}">
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
    </div>
</div>