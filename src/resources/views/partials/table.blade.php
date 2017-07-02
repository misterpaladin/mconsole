<div class="row">
	<div class="col-xs-12">
		<div class="portlet light">
            @include('mconsole::partials.portlet-title', [
                'filters' => (isset($filters) && count($filters) > 0) ? $filters : null,
                'back' => isset($back) ? $back : null,
                'title' => isset($title) ? $title : null,
                'actions' => isset($actions) ? $actions : null,
                'add' => isset($add) ? $add : null,
            ])
            @jstrans([
                'delete-modal-title' => trans('mconsole::tables.deletemodal.title'),
                'delete-modal-body' => trans('mconsole::tables.deletemodal.body'),
                'delete-modal-ok' => trans('mconsole::tables.deletemodal.ok'),
                'delete-modal-cancel' => trans('mconsole::tables.deletemodal.cancel'),
            ])
			<div class="portlet-body form">
				<div class="table-scrollable table-scrollable-borderless">
					@if (isset($items) && $items->count() > 0)
						<table class="table table-hover table-striped">
							<thead>
								<tr class="uppercase">
									@foreach ($items->first() as $key => $item)
                                        @if ($key == trans('mconsole::tables.state') || $key == trans('mconsole::tables.id'))
                                            <th style="width: 1%">{{ $key }}</th>
                                        @else
										    <th>{{ $key }}</th>
                                        @endif
									@endforeach
									<th>{{ trans('mconsole::tables.actions') }}</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($items as $item)
									<tr>
										@foreach ($item as $key => $value)
											<td>{!! $value !!}</td>
										@endforeach
										<td>
											{!! Form::open(['method' => 'DELETE', 'url' => Request::url() . '/' . $item->get('#')]) !!}
											@if ($edit) <a href="{{ Request::url() }}/{{ $item->get('#') }}/edit" class="btn btn-xs blue">{{ trans('mconsole::tables.edit') }}</a> @endif
											@if ($delete) {!! Form::submit(trans('mconsole::tables.delete'), ['class' => 'btn btn-xs btn-danger delete-confirm']) !!} @endif
											{!! Form::close() !!}
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					@else
						<p class="align-center">{{ trans('mconsole::tables.notfound') }}</p>
					@endif
				</div>
                @if (isset($paging))
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            {!! $paging->appends(Request::except('page'))->links() !!}
                        </div>
                    </div>
                @endif
			</div>
		</div>
	</div>
</div>

@if (isset($filters))
    <div class="modal fade" id="filters" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ Request::url() }}" method="GET" class="form-horizontal">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">{{ trans('mconsole::forms.filters.filter') }}</h4>
                    </div>
                    <div class="modal-body">
                        @include('mconsole::filters.form')
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm yellow-casablanca">{{ trans('mconsole::forms.filters.apply') }}</button>
        				<a href="{{ Request::url() }}" class="btn btn-sm">{{ trans('mconsole::forms.filters.reset') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif