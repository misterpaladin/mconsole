@extends('mconsole::app')

@section('content')

<div class="row">
	<div class="col-xs-12">
        {!! Form::open(['method' => 'POST', 'url' => '/mconsole/settings']) !!}
		<div class="form-body">
			<div class="row">
                <div class="col-md-8 col-sm-6">
                    <div class="portlet light">
        				@include('mconsole::partials.portlet-title', [
                            'title' => trans('mconsole::settings.main'),
                            'fullscreen' => true,
                        ])
        				<div class="portlet-body">
                            @foreach ($options->groupBy('group') as $groupName => $groupOptions)
                                @if (strlen($groupName) > 0)
                                    <h4>{{ trans(sprintf('mconsole::%s', $groupName)) }}</h4>
                                    <div class="row">
                                        @foreach ($groupOptions as $option)
                                            <div class="col-lg-4 col-md-6 col-xs-12">
                                                @if ($option->type == 'text')
                                                    @include('mconsole::forms.text', [
                                                        'label' => trans('mconsole::' . $option->label),
                                                        'name' => $option->key,
                                                        'value' => $option->value,
                                                    ])
                                                @elseif ($option->type == 'textarea')
                                                    @include('mconsole::forms.textarea', [
                                                        'label' => trans('mconsole::' . $option->label),
                                                        'name' => $option->key,
                                                        'value' => $option->value,
                                                    ])
                                                @elseif ($option->type == 'checkbox')
                                                    @include('mconsole::forms.checkbox', [
                                                        'label' => trans('mconsole::' . $option->label),
                                                        'name' => $option->key,
                                                        'value' => $option->value,
                                                    ])
                                                @elseif ($option->type == 'select')
                                                    @include('mconsole::forms.select', [
                                                        'label' => trans('mconsole::' . $option->label),
                                                        'name' => $option->key,
                                                        'options' => collect($option->options)->transform(function ($val, $key) {
                                                            return trans(sprintf('mconsole::%s', $val));
                                                        })->toArray(),
                                                        'value' => $option->value,
                                                    ])
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                    <hr/>
                                @endif
                            @endforeach
                            
                            @foreach ($options->groupBy('group') as $groupName => $groupOptions)
                                @if (strlen($groupName) == 0)
                                    <h4>{{ trans('mconsole::settings.options.group.other') }}</h4>
                                    <div class="row">
                                        @foreach ($groupOptions as $option)
                                            <div class="col-lg-4 col-md-6 col-xs-12">
                                                @if ($option->type == 'text')
                                                    @include('mconsole::forms.text', [
                                                        'label' => trans('mconsole::' . $option->label),
                                                        'name' => $option->key,
                                                        'value' => $option->value,
                                                    ])
                                                @elseif ($option->type == 'textarea')
                                                    @include('mconsole::forms.textarea', [
                                                        'label' => trans('mconsole::' . $option->label),
                                                        'name' => $option->key,
                                                        'value' => $option->value,
                                                    ])
                                                @elseif ($option->type == 'checkbox')
                                                    @include('mconsole::forms.checkbox', [
                                                        'label' => trans('mconsole::' . $option->label),
                                                        'name' => $option->key,
                                                        'value' => $option->value,
                                                    ])
                                                @elseif ($option->type == 'select')
                                                    @include('mconsole::forms.select', [
                                                        'label' => trans('mconsole::' . $option->label),
                                                        'name' => $option->key,
                                                        'options' => collect($option->options)->transform(function ($val, $key) {
                                                            return trans(sprintf('mconsole::%s', $val));
                                                        })->toArray(),
                                                        'value' => $option->value,
                                                    ])
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                    <hr/>
                                @endif
                            @endforeach
                            <div class="form-actions">
                    			@include('mconsole::forms.submit')
                    		</div>
        				</div>
        			</div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="portlet light">
        				@include('mconsole::partials.portlet-title', [
                            'title' => trans('mconsole::settings.additional.name'),
                        ])
        				<div class="portlet-body">
                            <div class="form-group">
                                <a href="{{ url('mconsole/settings/reloadtrans') }}" class="btn blue form-control popovers" data-lang-process="{{ trans('mconsole::settings.reloadtransprocess') }}" data-container="body" data-trigger="hover" data-placement="top" data-content="{{ trans('mconsole::settings.reloadtrans.content') }}">{{ trans('mconsole::settings.reloadtrans.title') }}</a>
                            </div>
                            <div class="form-group">
                                <a href="{{ url('mconsole/settings/clearcache') }}" class="btn btn-danger form-control">{{ trans('mconsole::settings.additional.cacheclear') }}</a>
                            </div>
        				</div>
        			</div>
                </div>
            </div>
		</div>
		{!! Form::close() !!}
	</div>
</div>

@endsection