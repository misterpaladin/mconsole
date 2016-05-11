@foreach ($items as $checkbox)
    <input type="hidden" name="{{ $checkbox['name'] }}" value="0" />
@endforeach
<div class="form-group">
    <div class="checkbox-list">
        @foreach ($items as $checkbox)
            <label class="checkbox-inline">{!! Form::checkbox($checkbox['name'], 1, (isset($checkbox['value'])) ? $checkbox['value'] : is_bool(Form::getValueAttribute($checkbox['name'])) ? (int) Form::getValueAttribute($checkbox['name']) : null) !!} {{ $checkbox['label'] }}</label>
        @endforeach
    </div>
</div>