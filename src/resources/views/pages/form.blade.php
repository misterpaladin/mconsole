@extends('mconsole::app')

@section('title', trans('mconsole::sections.pages.title') . ' | Mconsole')
@section('page.title', trans('mconsole::sections.pages.title'))
@section('page.subtitle', trans('mconsole::sections.' . Request::segments()[count(Request::segments()) - 1]))

@section('content')
	
	@if (isset($item))
		{!! Form::model($item, ['method' => 'PUT', 'route' => ['mconsole.pages.update', $item->id]]) !!}
	@else
		{!! Form::open(['method' => 'POST', 'url' => '/mconsole/pages']) !!}
	@endif
	<div class="row">
		<div class="col-md-8 col-sm-6">
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-blue sbold uppercase">{{ trans('mconsole::pages.form.main') }}</span>
					</div>
				</div>
				<div class="portlet-body form">
					@include('mconsole::forms.text', [
						'label' => trans('mconsole::pages.form.heading'),
						'name' => 'heading',
					])
					@include('mconsole::forms.text', [
						'label' => trans('mconsole::pages.form.slug'),
						'name' => 'slug',
					])
					
					@include('mconsole::forms.ckeditor', [
						'label' => trans('mconsole::pages.form.preview'),
						'name' => 'preview',
					])
					{{-- @include('mconsole::forms.textarea', [
						'label' => trans('mconsole::pages.form.text'),
						'name' => 'text',
					]) --}}
					@include('mconsole::forms.ckeditor', [
						'label' => trans('mconsole::pages.form.text'),
						'name' => 'text',
					])
				</div>
			</div>
		</div>
		<div class="col-md-4 col-sm-6">
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-blue sbold uppercase">{{ trans('mconsole::pages.form.additional') }}</span>
					</div>
				</div>
				<div class="portlet-body form">
					
					<div class="tabbable-line">
						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#tab_1" data-toggle="tab"> {{ trans('mconsole::pages.form.seo') }}  </a>
							</li>
							<li>
								<a href="#tab_2" data-toggle="tab"> {{ trans('mconsole::pages.form.options') }} </a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane fade active in" id="tab_1">
								@include('mconsole::forms.text', [
									'label' => trans('mconsole::pages.form.title'),
									'name' => 'title',
								])
								@include('mconsole::forms.textarea', [
									'label' => trans('mconsole::pages.form.description'),
									'name' => 'description',
								])
								@include('mconsole::forms.hidden', [
									'label' => trans('mconsole::pages.form.links'),
									'name' => 'links',
									'class' => 'links-editor'
								])
							</div>
							<div class="tab-pane fade" id="tab_2">
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
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-4">
			<div class="form-actions">
				@include('mconsole::forms.submit')
			</div>
		</div>
	</div>
	
	{!! Form::close() !!}
	
@endsection