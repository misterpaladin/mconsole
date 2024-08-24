<div class="form-group">
	<label>{!! $label !!}</label>
	<input class="form-control color-picker" name="{{ $name }}" type="hidden" value="{{ isset($value) ? $value : (is_null(old($name)) ? null : old($name)) }}">
</div>