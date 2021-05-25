@if (app('API')->options->getByKey('textareatype') == 'codemirror' && Auth::user()->editor == 1)
	<div class="form-group">
		<label>{!! $label !!}</label>
		{!! Form::textarea($name, null, ['class' => 'form-control codemirror', 'data-mode' => isset($mode) ? $mode : 'htmlmixed']) !!}
	</div>
@elseif (app('API')->options->getByKey('textareatype') == 'ckeditor' && Auth::user()->editor == 1)
	<div class="form-group">
		<label>{!! $label !!}</label>
		{!! Form::textarea($name, null, ['placeholder' => (isset($placeholder)) ? $placeholder : null, 'class' => 'form-control ckeditor']) !!}
	</div>
@else
	<div class="form-group">
		<label>{!! $label !!}</label>
		{!! Form::textarea($name, (isset($value)) ? $value : null, ['placeholder' => (isset($placeholder)) ? $placeholder : null, 'class' => 'form-control', 'size' => (isset($size)) ? $size : '50x10']) !!}
	</div>
@endif