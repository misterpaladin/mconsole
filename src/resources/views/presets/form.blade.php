@extends('mconsole::app')

@section('content')
	
	@if (isset($item))
		{!! Form::model($item, ['method' => 'PUT', 'route' => ['mconsole.presets.update', $item->id]]) !!}
	@else
		{!! Form::open(['method' => 'POST', 'url' => '/mconsole/presets']) !!}
	@endif
	<div class="row">
		<div class="col-md-8 col-sm-6">
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-blue sbold uppercase">{{ trans('mconsole::presets.form.main') }}</span>
					</div>
				</div>
				<div class="portlet-body form">
                    @include('mconsole::forms.text', [
                        'label' => trans('mconsole::presets.form.name'),
                        'name' => 'name',
                    ])
                    <div class="row">
                        <div class="col-sm-6">
                            @include('mconsole::forms.text', [
                                'label' => trans('mconsole::presets.form.path'),
                                'name' => 'path',
                            ])
                        </div>
                        <div class="col-sm-6">
                            @include('mconsole::forms.text', [
                                'label' => trans('mconsole::presets.form.quality'),
                                'name' => 'quality',
                            ])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            @include('mconsole::forms.text', [
                                'label' => trans('mconsole::presets.form.width'),
                                'name' => 'width',
                            ])
                        </div>
                        <div class="col-sm-6">
                            @include('mconsole::forms.text', [
                                'label' => trans('mconsole::presets.form.height'),
                                'name' => 'height',
                            ])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            @include('mconsole::forms.text', [
                                'label' => trans('mconsole::presets.form.watermark'),
                                'name' => 'watermark',
                            ])
                        </div>
                        <div class="col-sm-6">
                            @include('mconsole::forms.select', [
                                'label' => trans('mconsole::presets.form.position.label'),
                                'name' => 'position',
                                'options' => [
                                    'top-left (default)' => trans('mconsole::presets.form.position.options.topleft'),
                                    'top' => trans('mconsole::presets.form.position.options.top'),
                                    'top-right' => trans('mconsole::presets.form.position.options.topright'),
                                    'left' => trans('mconsole::presets.form.position.options.left'),
                                    'center' => trans('mconsole::presets.form.position.options.center'),
                                    'right' => trans('mconsole::presets.form.position.options.right'),
                                    'bottom-left' => trans('mconsole::presets.form.position.options.bottomleft'),
                                    'bottom' => trans('mconsole::presets.form.position.options.bottom'),
                                    'bottom-right' => trans('mconsole::presets.form.position.options.bottomright'),
                                ]
                            ])
                        </div>
                    </div>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-sm-6">
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-blue sbold uppercase">{{ trans('mconsole::presets.form.rules') }}</span>
					</div>
				</div>
				<div class="portlet-body form">
                    @include('mconsole::forms.text', [
                        'label' => trans('mconsole::presets.form.extensions'),
                        'name' => 'extensions',
                    ])
                    @include('mconsole::forms.text', [
                        'label' => trans('mconsole::presets.form.winwidth'),
                        'name' => 'min_width',
                    ])
                    @include('mconsole::forms.text', [
                        'label' => trans('mconsole::presets.form.minheight'),
                        'name' => 'min_height',
                    ])
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