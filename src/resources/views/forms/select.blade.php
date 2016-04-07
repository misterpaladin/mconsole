<div class="form-group">
	<label>{{ $label }}</label>
	{!! Form::select($name, $options, (isset($value)) ? $value : null, ['class' => 'form-control']) !!}
</div>