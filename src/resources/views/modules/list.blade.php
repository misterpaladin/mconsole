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
                                        <th width="90%">{{ trans('mconsole::tables.modules.info') }}</th>
    									<th>{{ trans('mconsole::tables.actions') }}</th>
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
                                                    @if ($item->type == 'extended')
                                                        <small class="text-success">{{ trans('mconsole::tables.modules.types.extended') }}</small>
                                                    @elseif ($item->type == 'custom')
                                                        <small class="text-primary">{{ trans('mconsole::tables.modules.types.custom') }}</small>
                                                    @else
                                                        <small class="text-muted">{{ trans('mconsole::tables.modules.types.base') }}</small>
                                                    @endif
                                                </p>
                                                <p class="small">{{ $item->description }}</p>
                                                <div class="row small module-info hide">
                                                    <div class="col-xs-12">
                                                        <hr>
                                                        <p><strong><i class="fa fa-cube"></i> Module components</strong></p>
                                                        
                                                        @include('mconsole::modules.module-info-block', ['item' => $item])
                                                        
                                                        @if ($item->type == 'extended')
                                                            <hr/>
                                                            <p class="text-success"><strong><i class="fa fa-plus"></i> Extended module custom components</strong></p>
                                                            @include('mconsole::modules.module-info-block', ['item' => $item->extend])
                                                            
                                                            <hr/>
                                                            <p><strong><i class="fa fa-cube"></i> Base module components</strong></p>
                                                            @include('mconsole::modules.module-info-block', ['item' => $item->original])
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
    										<td>
                                                <span class="btn btn-xs btn blue show-module-info"><i class="fa fa-info"></i> Info</span>
                                                <span class="btn btn-xs btn-danger uninstall-module @if (!$item->installed) hide @endif"><i class="fa fa-close"></i> Uninstall</span>
                                                <span class="btn btn-xs btn green-jungle install-module @if ($item->installed) hide @endif"><i class="fa fa-download"></i> Install</span>
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
    <script src="/massets/js/modules.js"></script>
@endsection