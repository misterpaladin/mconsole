@extends('mconsole::app')

@section('content')
	
	@if (isset($item))
		{!! Form::model($item, ['method' => 'PUT', 'route' => ['mconsole.presets.update', $item->id]]) !!}
	@else
		{!! Form::open(['method' => 'POST', 'url' => '/mconsole/presets']) !!}
	@endif
	<div class="row">
        <div class="col-md-4 col-sm-6">
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-blue sbold uppercase">{{ trans('mconsole::presets.form.main') }}</span>
					</div>
				</div>
				<div class="portlet-body form">
                    @include('mconsole::forms.select', [
                        'label' => trans('mconsole::presets.form.type'),
                        'name' => 'type',
                        'options' => [
                            'image' => trans('mconsole::presets.types.image'),
                            'document' => trans('mconsole::presets.types.document'),
                        ],
                    ])
                    @include('mconsole::forms.text', [
                        'label' => trans('mconsole::presets.form.name'),
                        'name' => 'name',
                    ])
                    @include('mconsole::forms.text', [
                        'label' => trans('mconsole::presets.form.extensions'),
                        'name' => 'extensions',
                    ])
                    <span data-only="image">
                        @include('mconsole::forms.text', [
                            'label' => trans('mconsole::presets.form.minwidth'),
                            'name' => 'min_width',
                        ])
                        @include('mconsole::forms.text', [
                            'label' => trans('mconsole::presets.form.minheight'),
                            'name' => 'min_height',
                        ])
                    </span>
                    @include('mconsole::forms.text', [
                        'label' => trans('mconsole::presets.form.path'),
                        'name' => 'path',
                        'placeholder' => 'images/etc',
                    ])
                    <div class="form-actions">
        				@include('mconsole::forms.submit')
        			</div>
				</div>
			</div>
		</div>
		<div class="col-md-8 col-sm-6">
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-blue sbold uppercase">{{ trans('mconsole::presets.form.operations.title') }}</span>
					</div>
				</div>
                <div class="portlet-body form hide" data-only="document">
                    <p>{{ trans('mconsole::presets.form.imageonly') }}</p>
                </div>
				<div class="portlet-body form hide" data-only="image">
                    <div class="operations-list"></div>
                    <div class="help-block">{{ trans('mconsole::presets.form.sequence') }}</div>
                    <div class="btn btn-sm blue preset-add-operation">{{ trans('mconsole::presets.form.operations.add') }}</div>
                    @include('mconsole::forms.hidden', [
                        'name' => 'operations',
                    ])
				</div>
			</div>
		</div>
	</div>
	
	{!! Form::close() !!}
	
    <div class="preset-operation-template hide">
        
        <div data-type="types">
            <form>
                <div class="form-group">
                    <label>{{ trans('mconsole::presets.form.operations.type') }}</label>
                    <select name="operation" class="form-control">
                        <option value="">{{ trans('mconsole::presets.form.operations.types.notselected') }}</option>
                        <optgroup label="{{ trans('mconsole::presets.form.operations.types.groups.file') }}">
                            <option value="original">{{ trans('mconsole::presets.form.operations.types.loadoriginal') }}</option>
                            <option value="save">{{ trans('mconsole::presets.form.operations.types.save') }}</option>
                        </optgroup>
                        <optgroup label="{{ trans('mconsole::presets.form.operations.types.groups.actions') }}">
                            <option value="resize">{{ trans('mconsole::presets.form.operations.types.resize') }}</option>
                            <option value="watermark">{{ trans('mconsole::presets.form.operations.types.watermark') }}</option>
                        </optgroup>
                        <optgroup label="{{ trans('mconsole::presets.form.operations.types.groups.filters') }}">
                            <option value="greyscale">{{ trans('mconsole::presets.form.operations.types.greyscale') }}</option>
                        </optgroup>
                    </select>
                </div>
                <div class="operation-options"></div>
                <div class="text-right"><div class="btn btn-xs btn-danger remove-operation">{{ trans('mconsole::presets.form.operations.remove') }}</div></div>
            </form>
            <hr/>
        </div>
        
        <div data-type="resize">
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label>{{ trans('mconsole::presets.form.operations.resize.name') }}</label>
                        <select name="type" class="form-control input-sm">
                            <option value="ratio">{{ trans('mconsole::presets.form.operations.resize.ratio') }}</option>
                            <option value="center">{{ trans('mconsole::presets.form.operations.resize.center') }}</option>
                            <option value="fixed">{{ trans('mconsole::presets.form.operations.resize.fixed') }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>{{ trans('mconsole::presets.form.width') }}</label>
                        <input class="form-control input-sm" type="text" name="width">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('mconsole::presets.form.height') }}</label>
                        <input class="form-control input-sm" type="text" name="height">
                    </div>
                </div>
            </div>
        </div>
        
        <div data-type="save">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>{{ trans('mconsole::presets.form.operations.save.path') }} <i class="fa fa-question-circle popovers" data-container="body" data-trigger="hover" data-placement="top" data-content="{{ trans('mconsole::presets.form.operations.save.pathhelp') }}"></i></label>
                        <input class="form-control input-sm" type="text" name="path" placeholder="thumb/etc">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>{{ trans('mconsole::presets.form.operations.save.quality') }}</label>
                        <input class="form-control input-sm" type="text" name="quality" placeholder="95">
                    </div>
                </div>
            </div>
        </div>
        
        <div data-type="watermark">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        <select name="operation-type" class="form-control input-sm">
                            <option value="top">{{ trans('mconsole::presets.form.operations.watermark.top') }}</option>
                            <option value="center">{{ trans('mconsole::presets.form.operations.watermark.center') }}</option>
                            <option value="bottom">{{ trans('mconsole::presets.form.operations.watermark.bottom') }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        <input class="form-control input-sm" type="text" name="x" placeholder="0">
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        <select name="operation-type" class="form-control input-sm">
                            <option value="left">{{ trans('mconsole::presets.form.operations.watermark.left') }}</option>
                            <option value="center">{{ trans('mconsole::presets.form.operations.watermark.center') }}</option>
                            <option value="right">{{ trans('mconsole::presets.form.operations.watermark.right') }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        <input class="form-control input-sm" type="text" name="y" placeholder="0">
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
@endsection

@section('page.scripts')
    <script src="/massets/js/presets.js" type="text/javascript"></script>
@endsection