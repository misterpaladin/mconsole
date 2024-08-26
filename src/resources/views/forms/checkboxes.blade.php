@foreach ($items as $checkbox)
    <input type="hidden" name="{{ $checkbox['name'] }}" value="0" />
@endforeach
<div class="form-group">
    <div class="checkbox-list">
        @foreach ($items as $checkbox)
            @php
                $isChecked = !is_null($checkbox['value']) ? ($checkbox['value'] == true ? true : false)
                    : (isset($checkbox['checked']) && !is_null($checkbox['checked']) && $checkbox['checked'] == true ? true : false);
            @endphp
            <label class="checkbox-inline"><input {{ $isChecked != 1 ? '' : 'checked="checked"' }} name="{{ $checkbox['name'] }}" type="checkbox" value="1"> {{ $checkbox['label'] }}</label>
        @endforeach
    </div>
</div>