@extends('mconsole::app')

@section('content')
	
	@variable('fuck')
	
	{!! Form::open(['method' => 'POST', 'url' => '/mconsole/test', 'files' => true]) !!}
	
	{!! Form::submit() !!}
	
	{!! Form::close() !!}
@endsection