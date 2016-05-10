<div class="form-group">
	<label>{{ $label }}</label>
    @if (isset($options) && is_array($options))
        {!! Form::select($name, $options, (isset($value)) ? $value : null, ['class' => 'form-control']) !!}
    @elseif (isset($type))
        {!! Form::select($name, [
            TRUE => trans(sprintf('mconsole::forms.options.%s.enabled', $type)),
            FALSE => trans(sprintf('mconsole::forms.options.%s.disabled', $type)),
        ], (isset($value)) ? $value : null, ['class' => 'form-control']) !!}
    @endif
</div>