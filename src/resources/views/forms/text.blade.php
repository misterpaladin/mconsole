<div class="form-group">
    <label>{!! $label !!} @if (isset($popover) && strlen($popover) > 0) <i class="fa fa-question-circle popovers" data-container="body" data-trigger="hover" data-placement="top" data-content="{{ trans($popover) }}"></i> @endif</label>
	{!! Form::text($name, !is_null(Form::getValueAttribute($name)) ? null : isset($value) ? $value : null, ['placeholder' => (isset($placeholder)) ? $placeholder : null, 'class' => 'form-control']) !!}
</div>