{!! Form::file("uploadable[0][files][]", ['multiple' => true]) !!}

@foreach (json_decode($presets) as $preset)
	<label>{!! Form::checkbox("uploadable[0][presets][]", $preset->id) !!} {{ $preset->name }}</label>
@endforeach