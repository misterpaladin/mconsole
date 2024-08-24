@foreach ($items as $checkbox)
    <input type="hidden" name="{{ $checkbox['name'] }}" value="0" />
@endforeach
<div class="form-group">
    <div class="checkbox-list">
        @foreach ($items as $checkbox)
            @php
                $isChecked = !is_null($checkbox['name'])
                    ? (int) $checkbox['name']
                    : (int) (isset($checkbox['checked']) && $checkbox['checked'] == true)
            @endphp
            <label class="checkbox-inline"><input {{ $isChecked != 1 ? '' : 'checked="checked"' }} name="{{ $checkbox['name'] }}" type="checkbox" value="1"> {{ $checkbox['label'] }}</label>
        @endforeach
    </div>
</div>