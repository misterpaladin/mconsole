@extends('mconsole::app')

@section('content')

<div class="row">
	<div class="col-md-4 col-sm-6">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-blue sbold uppercase">{{ trans('mconsole::presets.form.main') }}</span>
                </div>
            </div>
            <div class="portlet-body form">
        		@if (isset($item))
        			{!! Form::model($item, ['method' => 'PUT', 'route' => ['mconsole.users.update', $item->id]]) !!}
        		@else
        			{!! Form::open(['method' => 'POST', 'url' => '/mconsole/users']) !!}
        		@endif
    				@include('mconsole::forms.text', [
    					'label' => trans('mconsole::users.form.name.label'),
    					'name' => 'name',
    					'placeholder' => trans('mconsole::users.form.name.placeholder')
    				])
    				@include('mconsole::forms.text', [
    					'label' => trans('mconsole::users.form.email.label'),
    					'name' => 'email',
    					'placeholder' => trans('mconsole::users.form.email.placeholder')
    				])
    				@include('mconsole::forms.select', [
    					'label' => trans('mconsole::users.form.language'),
    					'name' => 'lang',
    					'options' => [
    						'ru' => 'ru',
    						'en' => 'en',
    					],
    				])
    				
                    @if (!isset($item) || $item->role->key != 'root')
                        @include('mconsole::forms.select', [
        					'label' => trans('mconsole::users.form.role'),
        					'name' => 'role_id',
        					'options' => $roles,
        				])
                    @endif
                    
    				@if (!isset($item))
    					@include('mconsole::forms.password', [
    						'label' => trans('mconsole::users.form.password.label'),
    						'name' => 'password',
    						'placeholder' => trans('mconsole::users.form.password.placeholder'),
    					])
    				@endif
        			<div class="form-actions">
        				@include('mconsole::forms.submit')
        			</div>
                </div>
            </div>
        </div>
		{!! Form::close() !!}
	</div>
</div>

@endsection