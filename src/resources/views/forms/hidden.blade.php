<div class="form-group">
    @if (isset($hidden))
        @foreach ($hidden as $hKey => $hVal)
            <input type="hidden" name="hidden-input-{{ $hKey }}" value="{{ $hVal }}">
        @endforeach
    @endif
	{!! Form::hidden($name, null, ['placeholder' => (isset($placeholder)) ? $placeholder : null, 'class' => (isset($class)) ? $class : null]) !!}
</div>