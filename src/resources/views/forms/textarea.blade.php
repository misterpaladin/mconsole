@if ((isset($editor) && $editor == 'codemirror') || (app('API')->options->getByKey('textareatype') == 'codemirror' && Auth::user()->editor == 1))
	<div class="form-group">
		<label>{!! $label !!}</label>
		<textarea class="form-control codemirror" name="{{ $name }}" data-mode="{{ isset($mode) ? $mode : 'htmlmixed' }}">{{ isset($value) ? $value : (is_null(old($name)) ? null : old($name)) }}</textarea>
	</div>
@elseif ((isset($editor) && $editor == 'ckeditor') || (app('API')->options->getByKey('textareatype') == 'ckeditor' && Auth::user()->editor == 1))
	<div class="form-group">
		<label>{!! $label !!}</label>
		<textarea class="form-control ckeditor" name="{{ $name }}">{{ isset($value) ? $value : (is_null(old($name)) ? null : old($name)) }}</textarea>
	</div>
@else
	<div class="form-group">
		<label>{!! $label !!}</label>
		<textarea class="form-control" name="{{ $name }}" cols="{{ isset($size) ? explode('x', $size)[0] : '50' }}" rows="{{ isset($size) ? explode('x', $size)[1] : '50' }}">{{ isset($value) ? $value : (is_null(old($name)) ? null : old($name)) }}</textarea>
	</div>
@endif