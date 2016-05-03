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
						    <option value="-1" selected="selected">{{ trans('mconsole::forms.filters.notselected') }}</option>
                        @else
                            <option value="-1">{{ trans('mconsole::forms.filters.notselected') }}</option>
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
            @elseif ($filter['type'] == 'date')
                <div class="col-sm-6">
                    <div class='input-group datepicker'>
                        <input name="{{ $filter['key'] }}" class="form-control" placeholder="" type="text" value="{{ Request::query($filter['key']) }}">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
				</div>
			@elseif ($filter['type'] == 'daterange')
                <div class="col-sm-6">
                    <div class='input-group datepicker'>
                        <input name="{{ $filter['key'] }}[from]" class="form-control" placeholder="" type="text" value="{{ array_get(Request::query($filter['key']), 'from') }}">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                    <div class='input-group datepicker'>
                        <input name="{{ $filter['key'] }}[to]" class="form-control" placeholder="" type="text" value="{{ array_get(Request::query($filter['key']), 'to') }}">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
				</div>
            @endif
		</div>
	@endforeach
</div>