<div class="table-scrollable table-scrollable-borderless">
	@if (isset($items) && $items->count() > 0)
		<table class="table table-hover table-striped">
			<thead>
				<tr class="uppercase">
					@foreach ($items->first() as $key => $item)
						<th>{{ $key }}</th>
					@endforeach
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($items as $item)
					<tr>
						@foreach ($item as $key => $value)
							<td>{{ $value }}</td>
						@endforeach
						<td>
							{!! Form::open(['method' => 'DELETE', 'url' => Request::url() . '/' . $item['#']]) !!}
								<a href="{{ Request::url() }}/{{ $item['#'] }}/edit" class="btn btn-xs blue">{{ trans('mconsole::tables.edit') }}</a>
								{!! Form::submit(trans('mconsole::tables.delete'), ['class' => 'btn btn-xs btn-danger']) !!}
							{!! Form::close() !!}
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	@else
		<p class="align-center">Not found</p>
	@endif
</div>
