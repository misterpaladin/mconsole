@foreach ($items as $checkbox)
    @if (!is_null(Form::getValueAttribute($checkbox['name'])) && is_bool(Form::getValueAttribute($checkbox['name'])))
        <input type="hidden" name="{{ $checkbox['name'] }}" value="{{ (int) !Form::getValueAttribute($checkbox['name']) }}" />
    @else
        <input type="hidden" name="{{ $checkbox['name'] }}" value="0" />
    @endif
@endforeach
<div class="form-group">
    <div class="checkbox-list">
        @foreach ($items as $checkbox)
            <label class="checkbox-inline">{!! Form::checkbox($checkbox['name'], 1, (isset($checkbox['value'])) ? $checkbox['value'] : is_bool(Form::getValueAttribute($checkbox['name'])) ? (int) Form::getValueAttribute($checkbox['name']) : null) !!} {{ $checkbox['label'] }}</label>
        @endforeach
    </div>
</div>