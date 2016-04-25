@extends('mconsole::app')

@section('page.styles')
    @foreach ($styles as $style)
        <link href="{{ $style }}" rel="stylesheet" type="text/css" />
    @endforeach
@endsection

@section('content')
    
    {!! $content !!}

@endsection

@section('page.scripts')
    @foreach ($scripts as $script)
        <script src="{{ $script }}" type="text/javascript"></script>
    @endforeach
@endsection