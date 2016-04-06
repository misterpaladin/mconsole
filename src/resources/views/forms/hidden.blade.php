<div class="form-group">
	<label>{{ $label }}</label>
    @if ($hidden)
        @foreach ($hidden as $hKey => $hVal)
            <input type="hidden" name="hidden-input-{{ $hKey }}" value="{{ $hVal }}">
        @endforeach
    @endif
	{!! Form::hidden($name, null, ['placeholder' => (isset($placeholder)) ? $placeholder : null, 'class' => 'form-control ' . isset($class) ? $class : null]) !!}
</div>