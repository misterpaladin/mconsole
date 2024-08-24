@extends('mconsole::app')

@section('content')

<div class="row">
	<div class="col-xs-12">
        <form method="POST" action="{{ mconsole_url('settings') }}">
            @csrf
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
                                    <h4>{{ trans($groupName) }}</h4>
                                    <div class="row">
                                        @foreach ($groupOptions as $option)
                                            <div class="col-xs-12">
                                                @if ($option->type == 'text')
                                                    @include('mconsole::forms.text', [
                                                        'label' => trans($option->label),
                                                        'name' => $option->key,
                                                        'value' => $option->value,
                                                        'popover' => $option->help,
                                                    ])
                                                @elseif ($option->type == 'textarea')
                                                    @include('mconsole::forms.textarea', [
                                                        'label' => trans($option->label),
                                                        'name' => $option->key,
                                                        'value' => $option->value,
                                                        'popover' => $option->help,
                                                    ])
                                                @elseif ($option->type == 'checkbox')
                                                    @include('mconsole::forms.checkbox', [
                                                        'label' => trans($option->label),
                                                        'name' => $option->key,
                                                        'value' => $option->value,
                                                        'popover' => $option->help,
                                                    ])
                                                @elseif ($option->type == 'select')
                                                    @include('mconsole::forms.select', [
                                                        'label' => trans($option->label),
                                                        'name' => $option->key,
                                                        'options' => collect($option->options)->transform(function ($val, $key) {
                                                            return trans($val);
                                                        })->toArray(),
                                                        'value' => $option->value,
                                                        'popover' => $option->help,
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
                                            <div class="col-xs-12">
                                                @if ($option->type == 'text')
                                                    @include('mconsole::forms.text', [
                                                        'label' => trans($option->label),
                                                        'name' => $option->key,
                                                        'value' => $option->value,
                                                        'popover' => $help,
                                                    ])
                                                @elseif ($option->type == 'textarea')
                                                    @include('mconsole::forms.textarea', [
                                                        'label' => trans($option->label),
                                                        'name' => $option->key,
                                                        'value' => $option->value,
                                                    ])
                                                @elseif ($option->type == 'checkbox')
                                                    @include('mconsole::forms.checkbox', [
                                                        'label' => trans($option->label),
                                                        'name' => $option->key,
                                                        'value' => $option->value,
                                                    ])
                                                @elseif ($option->type == 'select')
                                                    @include('mconsole::forms.select', [
                                                        'label' => trans($option->label),
                                                        'name' => $option->key,
                                                        'options' => collect($option->options)->transform(function ($val, $key) {
                                                            return trans($val);
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
                                <a href="{{ mconsole_url('settings/reloadtrans') }}" class="btn blue form-control popovers" data-container="body" data-trigger="hover" data-placement="top" data-content="{{ trans('mconsole::settings.additional.translations.popover') }}">{{ trans('mconsole::settings.additional.translations.reload') }}</a>
                            </div>
                            <div class="form-group">
                                <a href="{{ mconsole_url('settings/clearcache') }}" class="btn btn-danger form-control popovers" data-container="body" data-trigger="hover" data-placement="top" data-content="{{ trans('mconsole::settings.additional.cache.popover') }}">{{ trans('mconsole::settings.additional.cache.clear') }}</a>
                            </div>
        				</div>
        			</div>
                </div>
            </div>
		</div>
		</form>
	</div>
</div>

@endsection