<div class="form-group">
	<label>{{ $label }}</label>
	{!! Form::hidden($name, (isset($value)) ? $value : '#0088cc', ['class' => 'form-control color-picker']) !!}
</div>