<div class="form-group">
	<label>{{ $label }}</label>
    @if (isset($options) && is_array($options))
        {!! Form::select($name, $options, (isset($value)) ? $value : is_bool(Form::getValueAttribute($name)) ? (int) Form::getValueAttribute($name) : null, ['class' => 'form-control']) !!}
    @elseif (isset($type))
        {!! Form::select($name, [
            '1' => trans(sprintf('mconsole::forms.options.%s.enabled', $type)),
            '0' => trans(sprintf('mconsole::forms.options.%s.disabled', $type)),
        ], (isset($value)) ? $value : is_bool(Form::getValueAttribute($name)) ? (int) Form::getValueAttribute($name) : null, ['class' => 'form-control']) !!}
    @endif
</div>