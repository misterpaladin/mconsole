<div class="form-group">
	<label>{!! $label !!}</label>
	<textarea class="form-control ckeditor" name="{{ $name }}">{{ isset($value) ? $value : (is_null(old($name)) ? null : old($name)) }}</textarea>
</div>