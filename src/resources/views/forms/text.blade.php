<div class="form-group">
    <label>{!! $label !!} @if (isset($popover) && strlen($popover) > 0) <i class="fa fa-question-circle popovers" data-container="body" data-trigger="hover" data-placement="top" data-content="{{ trans($popover) }}"></i> @endif</label>

    <input class="form-control {{ isset($class) ? $class : '' }}" type="text" autocomplete="off" placeholder="{{ isset($placeholder) ? $placeholder : null }}" name="{{ $name }}" value="{{ isset($value) ? $value : (is_null(old($name)) ? null : old($name)) }}">
</div>