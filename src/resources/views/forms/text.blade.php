<div class="form-group">
	<label>{{ $label }}</label>
	{!! Form::text($name, (isset($value)) ? $value : null, ['placeholder' => (isset($placeholder)) ? $placeholder : null, 'class' => 'form-control']) !!}
</div>