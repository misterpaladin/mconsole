<div class="form-group">
    <input type="hidden" name="{{ $name }}" value="0" />
    <div class="checkbox-list">
        @php
            $isChecked = !is_null($value) ? ($value == true ? true : false)
                : (isset($checked) && !is_null($checked) && $checked == true ? true : false);
        @endphp
        <label class="checkbox"><input {{ $isChecked == true ? 'checked="checked"' : '' }} name="{{ $name }}" type="checkbox" value="1"> {{ $label }}</label>
    </div>
</div>