@extends('mconsole::mconsole.app')

@section('title', trans('mconsole::sections.users') . ' | Mconsole')
@section('page.title', trans('mconsole::sections.users'))
@section('page.subtitle', trans('mconsole::sections.list'))

@section('content')

@include('mconsole::mconsole.partials.table')

<div class="row">
	<div class="col-xs-12 text-center">
		{!! $paging->links() !!}
	</div>
</div>

@endsection