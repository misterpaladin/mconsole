<div class="form-group">
	<label>{!! $label !!}</label>
	{!! Form::password($name, ['placeholder' => (isset($placeholder)) ? $placeholder : null, 'class' => 'form-control']) !!}
</div>