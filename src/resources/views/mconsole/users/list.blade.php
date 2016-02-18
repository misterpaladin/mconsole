@extends('mconsole::mconsole.app')

@section('title', trans('mconsole::sections.users.title') . ' | Mconsole')
@section('page.title', trans('mconsole::sections.users.title'))
@section('page.subtitle', trans('mconsole::sections.users.list'))

@section('content')

@include('mconsole::mconsole.partials.table')

<div class="row">
	<div class="col-xs-12 text-center">
		{!! $paging->links() !!}
	</div>
</div>

@endsection