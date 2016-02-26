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
				])
				
				@include('mconsole::forms.select', [
					'label' => trans('mconsole::pages.form.hide_heading.name'),
					'name' => 'hide_heading',
					'options' => [
						'1' => trans('mconsole::pages.form.hide_heading.true'),
						'0' => trans('mconsole::pages.form.hide_heading.false'),
					],
				])
				@include('mconsole::forms.select', [
					'label' => trans('mconsole::pages.form.fullwidth.name'),
					'name' => 'fullwidth',
					'options' => [
						'0' => trans('mconsole::pages.form.fullwidth.false'),
						'1' => trans('mconsole::pages.form.fullwidth.true'),
					],
				])
				@include('mconsole::forms.select', [
					'label' => trans('mconsole::pages.form.enabled.name'),
					'name' => 'enabled',
					'options' => [
						'1' => trans('mconsole::pages.form.enabled.true'),
						'0' => trans('mconsole::pages.form.enabled.false'),
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