<div class="form-group">
    <input type="hidden" name="{{ $name }}" value="0" />
    <div class="checkbox-list">
        <label class="checkbox">{!! Form::checkbox($name, 1, !is_null(Form::getValueAttribute($name)) ? (int) Form::getValueAttribute($name) : (int) (isset($checked) && $checked == true)) !!} {!! $label !!}</label>
    </div>
</div>