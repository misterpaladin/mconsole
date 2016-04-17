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
						<option value="">{{ trans('mconsole::traits.filters.notselected') }}</option>
						@foreach ($filter['options'] as $key => $name)
							@if (Request::query($filter['key']) == $key)
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