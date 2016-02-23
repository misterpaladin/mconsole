@extends('mconsole::app')

@section('title', 'Pages | Mconsole')
@section('page.title', 'Pages')
@section('page.subtitle', 'List')

@section('content')

@section('content')

@include('mconsole::mconsole::partials.table')

<div class="row">
	<div class="col-xs-12 text-center">
		{!! $items->links() !!}
	</div>
</div>

@endsection