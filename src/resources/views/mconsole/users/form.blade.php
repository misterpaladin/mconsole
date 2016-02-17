@extends('mconsole::mconsole.app')

@section('title', trans('mconsole::sections.users') . ' | Mconsole')
@section('page.title', trans('mconsole::sections.users'))
@section('page.subtitle', trans('mconsole::sections.create'))

@section('content')

<div class="row">
	<div class="col-md-4 col-sm-6">
		@if (isset($item))
			{!! Form::model($item, ['method' => 'PUT', 'route' => ['mconsole.users.update', $item->id]]) !!}
		@else
			{!! Form::open(['method' => 'POST', 'url' => '/mconsole/users']) !!}
		@endif
			<div class="form-body">
				@include('mconsole::mconsole.forms.text', [
					'label' => 'Name',
					'name' => 'name',
					'placeholder' => 'John Appleseed'
				])
				@include('mconsole::mconsole.forms.text', [
					'label' => 'Email',
					'name' => 'email',
					'placeholder' => 'example@milax.com'
				])
				@include('mconsole::mconsole.forms.select', [
					'label' => 'Language',
					'name' => 'lang',
					'options' => [
						'ru' => 'ru',
						'en' => 'en',
					],
				])
				
				@if (!isset($item))
					@include('mconsole::mconsole.forms.password', [
						'name' => 'password',
						'label' => 'Password',
						'placeholder' => 'Password',
					])
				@endif
				
			</div>
			<div class="form-actions">
				@include('mconsole::mconsole.forms.submit')
			</div>
		{!! Form::close() !!}
	</div>
</div>

@endsection