<div class="form-group">
    @if (!is_null(Form::getValueAttribute($name)) && is_bool(Form::getValueAttribute($name)))
	       <input type="hidden" name="{{ $name }}" value="{{ (int) !Form::getValueAttribute($name) }}" />
    @endif
    <div class="checkbox-list">
        <label class="checkbox">{!! Form::checkbox($name, 1, (isset($value)) ? $value : is_bool(Form::getValueAttribute($name)) ? (int) Form::getValueAttribute($name) : null) !!} {{ $label }}</label>
    </div>
</div>