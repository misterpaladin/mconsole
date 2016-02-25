@extends('mconsole::app')

@section('title', trans('mconsole::sections.roles.title') . ' | Mconsole')
@section('page.title', trans('mconsole::sections.roles.title'))
@section('page.subtitle', trans('mconsole::sections.list'))

@section('content')

<div class="row">
	<div class="col-xs-12 text-right">
		<a href="/mconsole/roles/create" class="btn btn-sm blue">{{ trans('mconsole::tables.create') }}</a>
	</div>
</div>

@include('mconsole::partials.table')

@endsection