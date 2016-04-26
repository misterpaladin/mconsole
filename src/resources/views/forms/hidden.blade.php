<div class="form-group">
	{!! Form::hidden($name, isset($value) ? $value : null, ['placeholder' => (isset($placeholder)) ? $placeholder : null, 'class' => (isset($class)) ? $class : null]) !!}
</div>