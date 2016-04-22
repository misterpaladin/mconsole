@extends('mconsole::app')

@section('content')

<div class="row">
	<div class="col-md-4 col-sm-6">
        <div class="portlet light">
            @include('mconsole::partials.portlet-title', [
                    'back' => '/mconsole/tags',
                    'title' => trans('mconsole::tags.form.main'),
                ])
            <div class="portlet-body form">
            		<div class="form-body">
                        @if (isset($item))
                			{!! Form::model($item, ['method' => 'PUT', 'route' => ['mconsole.tags.update', $item->id]]) !!}
                		@else
                			{!! Form::open(['method' => 'POST', 'url' => '/mconsole/tags']) !!}
                		@endif
        				@include('mconsole::forms.text', [
        					'label' => trans('mconsole::tags.form.name'),
        					'name' => 'name',
        					'placeholder' => trans('mconsole::tags.form.placeholder')
        				])
                        
                        @include('mconsole::forms.colorpicker', [
                            'label' => trans('mconsole::tags.form.color'),
                            'name' => 'color',
                        ])
                        
                    </div>
                    
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

@section('page.scripts')
    <script src="/massets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js" type="text/javascript"></script>
    <script src="/massets/global/plugins/jquery-minicolors/jquery.minicolors.min.js" type="text/javascript"></script>
    <script>
        $('.color-picker').minicolors({
            defaultValue: '#0088cc',
            theme: 'bootstrap'
        });
    </script>
@endsection