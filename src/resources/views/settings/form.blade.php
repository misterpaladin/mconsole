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
                        ])
        				<div class="portlet-body">
                            @foreach ($options->groupBy('group') as $groupName => $groupOptions)
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
                                                    'options' => $option->options,
                                                    'value' => $option->value,
                                                ])
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                <hr/>
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
                            <a href="{{ url('mconsole/settings/clearcache') }}" class="btn btn-danger form-control">{{ trans('mconsole::settings.additional.cacheclear') }}</a>
        				</div>
        			</div>
                </div>
            </div>
		</div>
		{!! Form::close() !!}
	</div>
</div>

@endsection