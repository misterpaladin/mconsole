<div class="row">
	<div class="col-xs-12">
        @if (isset($item))
            {!! Form::model($item, ['method' => 'PUT', 'route' => ['mconsole.roles.update', $item->id]]) !!}
        @else
            {!! Form::open(['method' => 'POST', 'url' => '/mconsole/roles']) !!}
        @endif
		<div class="form-body">
			<div class="row">
                <div class="col-md-4">
                    <div class="portlet light">
                        @include('mconsole::partials.portlet-title', [
                            'back' => '/mconsole/roles',
                            'title' => trans('mconsole::roles.form.main'),
                        ])
        				<div class="portlet-body form">
                            @include('mconsole::forms.text', [
                                'label' => trans('mconsole::roles.form.name'),
                                'name' => 'name',
                                'placeholder' => trans('mconsole::roles.form.placeholder')
                            ])
                            @include('mconsole::forms.select', [
                                'label' => trans('mconsole::roles.form.widget'),
                                'name' => 'widget',
                                'type' => MX_SELECT_STATE,
                            ])
                            @include('mconsole::forms.select', [
                                'label' => trans('mconsole::roles.form.search'),
                                'name' => 'search',
                                'type' => MX_SELECT_STATE,
                            ])
        				</div>
        			</div>
                    <div class="form-actions">
            			@include('mconsole::forms.submit')
            		</div>
                </div>
                <div class="col-md-8">
                    <div class="portlet light">
        				<div class="portlet-title">
        					<div class="caption">
        						<span class="caption-subject font-blue sbold uppercase">{{ trans('mconsole::roles.form.permissions') }}</span>
        					</div>
        				</div>
        				<div class="portlet-body form">
                            <div class="form-group row">
                                <div class="col-xs-12">
                                    <select multiple="multiple" class="multi-select grouped" name="routes[]">
                                        @foreach ($acl as $aclGroup => $aclItems)
                                            <optgroup label="{{ $aclGroup }}">
                                                @foreach ($aclItems as $aclItem)
                                                    <option @if(isset($item) && in_array($aclItem->route, $item->routes)) selected="selected" @endif value="{{ $aclItem->route }}">{{ $aclItem->action }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
        				</div>
        			</div>
                </div>
            </div>
		</div>
		{!! Form::close() !!}
	</div>
</div>