@extends('mconsole::app')

@section('title', trans('mconsole::sections.roles.title') . ' | Mconsole')
@section('page.title', trans('mconsole::sections.roles.title'))
@section('page.subtitle', trans('mconsole::sections.' . Request::segments()[count(Request::segments()) - 1]))

@section('content')

<div class="row">
	<div class="col-md-4 col-sm-6">
		<div class="form-body">
			@if (isset($item))
				{!! Form::model($item, ['method' => 'PUT', 'route' => ['mconsole.roles.update', $item->id]]) !!}
			@else
				{!! Form::open(['method' => 'POST', 'url' => '/mconsole/roles']) !!}
			@endif
			
			@include('mconsole::forms.text', [
				'label' => trans('mconsole::roles.form.name'),
				'name' => 'name',
				'placeholder' => 'Moderator'
			])
		</div>
		<div class="form-actions">
			@include('mconsole::forms.submit')
		</div>
		{!! Form::close() !!}
	</div>
</div>

@endsection