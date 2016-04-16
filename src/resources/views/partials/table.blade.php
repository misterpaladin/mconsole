<div class="row">
	<div class="col-xs-12">
		<div class="portlet light">
                @include('mconsole::partials.portlet-title', [
                    'title' => isset($title) ? $title : '',
                    'actions' => isset($actions) ? $actions : '',
                ])
			<div class="portlet-body form">
				<div class="table-scrollable table-scrollable-borderless">
					@if (isset($items) && $items->count() > 0)
						<table class="table table-hover table-striped">
							<thead>
								<tr class="uppercase">
									@foreach ($items->first() as $key => $item)
										<th>{{ $key }}</th>
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
											{!! Form::open(['method' => 'DELETE', 'url' => Request::url() . '/' . $item->values()->first()]) !!}
											<a href="{{ Request::url() }}/{{ $item->values()->first() }}/edit" class="btn btn-xs blue">{{ trans('mconsole::tables.edit') }}</a>
											{!! Form::submit(trans('mconsole::tables.delete'), ['class' => 'btn btn-xs btn-danger']) !!}
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
			</div>
		</div>
	</div>
</div>