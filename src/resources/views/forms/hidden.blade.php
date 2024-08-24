<div class="form-group hide">
	<input type="hidden" name="{{ $name }}" {{ isset($class) ? sprintf('class="%s"', $class) : '' }} value="{{ $value ?? null }}">
</div>