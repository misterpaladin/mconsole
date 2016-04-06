<div class="form-group">
	<label>{{ $label }}</label>
	{!! Form::textarea($name, null, ['placeholder' => (isset($placeholder)) ? $placeholder : null, 'class' => 'form-control', 'size' => (isset($size)) ? $size : '50x10']) !!}
</div>