@extends('mconsole::app')

@section('content')
    @if ($beforeList)
        {!! $beforeList !!}
    @endif

    @include('mconsole::partials.table', $tableOptions)
   
    @if ($afterList)
        {!! $afterList !!}
    @endif
@endsection