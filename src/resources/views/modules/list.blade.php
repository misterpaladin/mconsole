@extends('mconsole::app')

@section('content')
    
    <div class="row">
    	<div class="col-xs-12">
    		<div class="portlet light">
                @include('mconsole::partials.portlet-title', [
                    'actions' => '<a href="javascript:;" class="btn btn-xs btn-circle blue reload-translations popovers" data-lang-process="' . trans('mconsole::modules.table.reloadtransprocess') . '" data-container="body" data-trigger="hover" data-placement="top" data-title="' . trans('mconsole::modules.table.reloadtrans.title') . '" data-content="' . trans('mconsole::modules.table.reloadtrans.content') . '"><i class="fa fa-refresh"></i></a>'
                ])
    			<div class="portlet-body form">
    				<div class="table-scrollable table-scrollable-borderless">
    					@if (isset($items) && $items->count() > 0)
    						<table id="modules-table" class="table table-striped">
    							<thead>
    								<tr class="uppercase">
                                        <th width="1%"></th>
                                        <th>{{ trans('mconsole::modules.table.info') }}</th>
    									<th width="30%">{{ trans('mconsole::tables.actions') }}</th>
    								</tr>
    							</thead>
    							<tbody>
    								@foreach ($items as $item)
                                        <tr data-identifier="{{ $item->identifier }}">
                                            <td>
                                                <i class="fa fa-cubes popovers" data-container="body" data-trigger="hover" data-placement="top" data-content="{{ trans('mconsole::tables.modules.module') }}" data-original-title="{{ $item->name }}"></i>
                                            </td>
                                            <td>
                                                <p>
                                                    <strong>{{ $item->name }}</strong> <span class="small">[{{ $item->identifier }}]</span>
                                                </p>
                                                <p class="">{{ trans($item->description) }}</p>
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="jstree small">
                                                            <ul>
                                                                <li data-jstree='{ "icon" : "fa fa-cubes" }'>
                                                                    {{ trans('mconsole::modules.table.components') }}
                                                                    <ul>@include('mconsole::modules.module-info-block', ['item' => $item])</ul>
                                                                </li>
                                                                @if ($item->type == 'extended')
                                                                    <li data-jstree='{ "icon" : "fa fa-plus" }'>
                                                                        {{ trans('mconsole::modules.table.extended') }}
                                                                        <ul>@include('mconsole::modules.module-info-block', ['item' => $item->extend])</ul>
                                                                    </li>
                                                                    <li data-jstree='{ "icon" : "fa fa-cube" }'>
                                                                        {{ trans('mconsole::modules.table.base') }}
                                                                        <ul>@include('mconsole::modules.module-info-block', ['item' => $item->original])</ul>
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
    										<td>
                                                <span class="btn btn-xs btn-danger uninstall-module popovers @if (!$item->installed) hide @endif" data-container="body" data-trigger="hover" data-placement="top" data-content="{{ trans('mconsole::modules.table.uninstall.info') }}" data-modal-title="{{ trans('mconsole::modules.table.uninstall.modal.title') }}" data-modal-content="{{ trans('mconsole::modules.table.uninstall.modal.content') }}" data-modal-cancel="{{ trans('mconsole::modules.table.uninstall.modal.cancel') }}" data-modal-uninstall="{{ trans('mconsole::modules.table.uninstall.modal.uninstall') }}" data-lang-process="{{ trans('mconsole::modules.table.uninstall.process') }}"><i class="fa fa-close"></i> {{ trans('mconsole::modules.table.buttons.uninstall') }}</span>
                                                <span class="btn btn-xs green-jungle install-module popovers @if ($item->installed) hide @endif" data-container="body" data-trigger="hover" data-placement="top" data-content="{{ trans('mconsole::modules.table.install.info') }}" data-lang-process="{{ trans('mconsole::modules.table.install.process') }}"><i class="fa fa-download"></i> {{ trans('mconsole::modules.table.buttons.install') }}</span>
                                                @if ($item->type == 'custom')
                                                    <span class="btn btn-xs btn-success extend-module disabled popovers" data-container="body" data-trigger="hover" data-placement="top" data-content="{{ trans('mconsole::modules.table.extend.custom') }}"><i class="fa fa-plus"></i> {{ trans('mconsole::modules.table.buttons.extend') }}</span>
                                                @elseif ($item->type == 'extended')
                                                    <span class="btn btn-xs btn-success extend-module disabled popovers" data-container="body" data-trigger="hover" data-placement="top" data-content="{{ trans('mconsole::modules.table.extend.extended') }}"><i class="fa fa-plus"></i> {{ trans('mconsole::modules.table.buttons.extend') }}</span>
                                                @else
                                                    <span class="btn btn-xs btn-success extend-module popovers" data-container="body" data-trigger="hover" data-placement="top" data-content="{{ trans('mconsole::modules.table.extend.base') }}" data-lang-process="{{ trans('mconsole::modules.table.extend.process') }}"><i class="fa fa-plus"></i> {{ trans('mconsole::modules.table.buttons.extend') }}</span>
                                                @endif
    										</td>
    									</tr>
    								@endforeach
    							</tbody>
    						</table>
    					@else
    						<p class="align-center">{{ trans('mconsole::tables.notfound') }}</p>
    					@endif
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
@endsection

@section('page.scripts')
    <script src="/massets/global/plugins/jstree/dist/jstree.min.js" type="text/javascript"></script>
    <script src="/massets/js/modules.js"></script>
    <script>
        $(function () {
            $('.jstree').jstree({
                "core" : {
                    "themes" : {
                        "responsive": true
                    }
                },
                "types" : {
                    "default" : {
                        "icon" : "fa fa-folder icon-state-default icon-lg"
                    },
                    "file" : {
                        "icon" : "fa fa-file icon-state-default icon-lg"
                    }
                },
                "plugins": ["types"]
            });
        });
    </script>
@endsection