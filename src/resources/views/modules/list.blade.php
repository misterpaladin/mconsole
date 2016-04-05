@extends('mconsole::app')

@section('content')

    <div class="row">
    	<div class="col-xs-12">
    		<div class="portlet light">
    			<div class="portlet-body form">
    				<div class="table-scrollable table-scrollable-borderless">
    					@if (isset($items) && $items->count() > 0)
    						<table id="modules-table" class="table table-striped">
    							<thead>
    								<tr class="uppercase">
                                        <th width="1%"></th>
                                        <th>{{ trans('mconsole::tables.modules.info') }}</th>
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
                                                <p class="">{{ $item->description }}</p>
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="jstree small">
                                                            <ul>
                                                                <li data-jstree='{ "icon" : "fa fa-cubes" }'>
                                                                    Module components
                                                                    <ul>@include('mconsole::modules.module-info-block', ['item' => $item])</ul>
                                                                </li>
                                                                @if ($item->type == 'extended')
                                                                    <li data-jstree='{ "icon" : "fa fa-plus" }'>
                                                                        Extended module custom components
                                                                        <ul>@include('mconsole::modules.module-info-block', ['item' => $item->extend])</ul>
                                                                    </li>
                                                                    <li data-jstree='{ "icon" : "fa fa-cube" }'>
                                                                        Base module components
                                                                        <ul>@include('mconsole::modules.module-info-block', ['item' => $item->original])</ul>
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
    										<td>
                                                <span class="btn btn-xs btn-danger uninstall-module popovers @if (!$item->installed) hide @endif" data-container="body" data-trigger="hover" data-placement="top" data-content="{{ trans('mconsole::tables.modules.uninstall.info') }}" data-modal-title="{{ trans('mconsole::tables.modules.uninstall.modal.title') }}" data-modal-content="{{ trans('mconsole::tables.modules.uninstall.modal.content') }}" data-modal-cancel="{{ trans('mconsole::tables.modules.uninstall.modal.cancel') }}" data-modal-uninstall="{{ trans('mconsole::tables.modules.uninstall.modal.uninstall') }}"><i class="fa fa-close"></i> Uninstall</span>
                                                <span class="btn btn-xs green-jungle install-module popovers @if ($item->installed) hide @endif" data-container="body" data-trigger="hover" data-placement="top" data-content="{{ trans('mconsole::tables.modules.install.info') }}"><i class="fa fa-download"></i> Install</span>
                                                @if ($item->type == 'custom')
                                                    <span class="btn btn-xs btn-success extend-module disabled popovers" data-container="body" data-trigger="hover" data-placement="top" data-content="{{ trans('mconsole::tables.modules.extend.custom') }}"><i class="fa fa-plus"></i> Extend</span>
                                                @elseif ($item->type == 'extended')
                                                    <span class="btn btn-xs btn-success extend-module disabled popovers" data-container="body" data-trigger="hover" data-placement="top" data-content="{{ trans('mconsole::tables.modules.extend.extended') }}"><i class="fa fa-plus"></i> Extend</span>
                                                @else
                                                    <span class="btn btn-xs btn-success extend-module popovers" data-container="body" data-trigger="hover" data-placement="top" data-content="{{ trans('mconsole::tables.modules.extend.base') }}"><i class="fa fa-plus"></i> Extend</span>
                                                @endif
    										</td>
    									</tr>
    								@endforeach
    							</tbody>
    						</table>
    					@else
    						<p class="align-center">Not found</p>
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