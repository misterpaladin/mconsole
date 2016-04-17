@extends('mconsole::app')

@section('page.styles')
    <link href="/massets/global/plugins/jquery-nestable/jquery.nestable.css" rel="stylesheet" type="text/css">
    <link href="/massets/css/menu-editor.css" rel="stylesheet" type="text/css">
@endsection

@section('content')

<div class="row">
	<div class="col-md-4 col-sm-6">
        <div class="portlet light">
            @include('mconsole::partials.portlet-title', [
                    'back' => '/mconsole/menus',
                    'title' => trans('mconsole::menus.form.main'),
                ])
            <div class="portlet-body form">
            		<div class="form-body">
                        @if (isset($item))
                			{!! Form::model($item, ['method' => 'PUT', 'route' => ['mconsole.menus.update', $item->id]]) !!}
                		@else
                			{!! Form::open(['method' => 'POST', 'url' => '/mconsole/menus']) !!}
                		@endif
        				@include('mconsole::forms.text', [
        					'label' => trans('mconsole::menus.form.name.label'),
        					'name' => 'name',
        					'placeholder' => trans('mconsole::menus.form.name.placeholder')
        				])
                        @include('mconsole::forms.state')
                    </div>
                    
        			<div class="form-actions">
        				@include('mconsole::forms.submit')
        			</div>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-6">
            <div class="portlet light">
                @include('mconsole::partials.portlet-title', [
                    'name' => 'tree',
                    'title' => trans('mconsole::menus.form.tree'),
                ])
                <div class="portlet-body form">
            		<div class="form-body">
        				@include('mconsole::forms.hidden', [
        					'name' => 'tree',
        				])
                        @include('mconsole::partials.trans', [
                            'lang' => [
                                'menu-editor-text' => trans('mconsole::menus.form.placeholders.text'),
                                'menu-editor-link' => trans('mconsole::menus.form.placeholders.link'),
                                'menu-editor-blank' => trans('mconsole::menus.form.placeholders.blank'),
                            ],
                        ])
                    </div>
                </div>
            </div>
        </div>
		{!! Form::close() !!}
	</div>
</div>

@endsection

@section('page.scripts')
    <script src="/massets/global/plugins/jquery-nestable/jquery.nestable.js" type="text/javascript"></script>
    <script src="/massets/js/menu-editor.js" type="text/javascript"></script>
    <script>
        $('input[name="tree"]').menuEditor();
    </script>
@endsection