<div class="form-group">
	<label>{!! $label !!}</label>
    <div class='input-group datetimepicker'>
    	{!! Form::text($name, null, ['placeholder' => (isset($placeholder)) ? $placeholder : null, 'class' => 'form-control']) !!}
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
    </div>
</div>