@extends('mconsole::app')

@section('title', trans('mconsole::sections.pages.title') . ' | Mconsole')
@section('page.title', trans('mconsole::sections.pages.title'))
@section('page.subtitle', trans('mconsole::sections.' . Request::segments()[count(Request::segments()) - 1]))

@section('content')

<div class="row">
	<div class="col-sm-6">
		@if (isset($item))
			{!! Form::model($item, ['method' => 'PUT', 'route' => ['mconsole.pages.update', $item->id]]) !!}
		@else
			{!! Form::open(['method' => 'POST', 'url' => '/mconsole/pages']) !!}
		@endif
			<div class="form-body">
				@include('mconsole::forms.text', [
					'label' => trans('mconsole::pages.form.heading'),
					'name' => 'heading',
				])
				@include('mconsole::forms.text', [
					'label' => trans('mconsole::pages.form.slug'),
					'name' => 'slug',
				])
				@include('mconsole::forms.text', [
					'label' => trans('mconsole::pages.form.title'),
					'name' => 'title',
				])
				
				@include('mconsole::forms.textarea', [
					'label' => trans('mconsole::pages.form.preview'),
					'name' => 'preview',
				])
				@include('mconsole::forms.textarea', [
					'label' => trans('mconsole::pages.form.text'),
					'name' => 'text',
				])
				@include('mconsole::forms.textarea', [
					'label' => trans('mconsole::pages.form.description'),
					'name' => 'description',
					'placeholder' => 'Описание для поиска',
				])
				
				@include('mconsole::forms.select', [
					'label' => trans('mconsole::users.form.hide_heading'),
					'name' => 'hide_heading',
					'options' => [
						'1' => 'Not hide',
						'0' => 'Hide',
					],
				])
				@include('mconsole::forms.select', [
					'label' => trans('mconsole::users.form.fullwidth'),
					'name' => 'fullwidth',
					'options' => [
						'0' => 'Not fullwidth',
						'1' => 'Fullwidth',
					],
				])
				@include('mconsole::forms.select', [
					'label' => trans('mconsole::users.form.enabled'),
					'name' => 'enabled',
					'options' => [
						'1' => 'Enabled',
						'0' => 'Disabled',
					],
				])
				
			</div>
			<div class="form-actions">
				@include('mconsole::forms.submit')
			</div>
		{!! Form::close() !!}
	</div>
</div>

@endsection