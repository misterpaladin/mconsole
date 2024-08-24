<div class="form-group">
    {{-- @if(isset($options)){{ dd($options) }}@endif --}}
	@if (!empty($label))<label>{!! $label !!}</label>@endif
    <?php 
        $val = isset($value) ? $value : (is_null(old($name)) ? null : old($name))
    ?>
    <select class="form-control {{ isset($class) ? $class : '' }}" name="{{ $name }}">
        @if (isset($options) && is_array($options))
            @foreach ($options as $key => $option)
                <option value="{{ $key }}" {{ $val != $key ? '' : 'selected="selected"' }}>{{ $option }}</option>
            @endforeach
        @elseif (isset($type))
            {{-- {!! Form::select($name, [
                '1' => trans(sprintf('mconsole::forms.options.%s.enabled', $type)),
                '0' => trans(sprintf('mconsole::forms.options.%s.disabled', $type)),
            ], $val, ['class' => sprintf('form-control %s', isset($class) ? $class : null)]) !!} --}}
            <option value="1" {{ $val != 1 ? '' : 'selected="selected"' }}>{{ trans(sprintf('mconsole::forms.options.%s.enabled', $type)) }}</option>
            <option value="0" {{ $val != 0 ? '' : 'selected="selected"' }}>{{ trans(sprintf('mconsole::forms.options.%s.disabled', $type)) }}</option>
        @endif
    </select>
</div>