<div class="form-body">
	@foreach ($filters as $filter)
		<div class="form-group">
			<label class="col-sm-3 control-label">{{ $filter['label'] }}</label>
			@if ($filter['type'] == 'text')
				<div class="col-sm-6">
					<input name="{{ $filter['key'] }}" class="form-control" placeholder="" type="text" value="{{ Request::query($filter['key']) }}">
				</div>
			@elseif ($filter['type'] == 'select')
				<div class="col-sm-6">
					<select name="{{ $filter['key'] }}" class="form-control">
                        @if (!Request::has($filter['key']))
						    <option value="-1" selected="selected">{{ trans('mconsole::traits.filters.notselected') }}</option>
                        @else
                            <option value="-1">{{ trans('mconsole::traits.filters.notselected') }}</option>
                        @endif
                        @foreach ($filter['options'] as $key => $name)
							@if (Request::has($filter['key']) && Request::query($filter['key']) == $key)
								<option value="{{ $key }}" selected="selected">{{ $name }}</option>
							@else
								<option value="{{ $key }}">{{ $name }}</option>
							@endif
						@endforeach
					</select>
				</div>
			@endif
		</div>
	@endforeach
</div>