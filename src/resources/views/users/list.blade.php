@extends('mconsole::app')

@section('content')

@include('mconsole::partials.table', [
    'actions' => '<a href="/mconsole/users/create" class="btn btn-circle green-jungle "><i class="fa fa-plus"></i> ' . trans('mconsole::tables.create') . ' </a>',
])

@endsection