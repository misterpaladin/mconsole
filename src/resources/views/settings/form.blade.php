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
                            'title' => 'Настройки',
                        ])
        				<div class="portlet-body">
                            @foreach ($options as $option)
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
                            @endforeach
                            <div class="form-actions">
                    			@include('mconsole::forms.submit')
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