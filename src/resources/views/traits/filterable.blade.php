<form action="" method="GET" class="form-horizontal">
	<div class="form-body">
		@foreach ($filterable as $filter)
			<div class="form-group">
				<label class="col-md-3 control-label">{{ $filter['label'] }}</label>
				@if ($filter['type'] == 'text')
					<div class="col-md-4">
						<input name="{{ $filter['key'] }}" class="form-control" placeholder="" type="text" value="{{ Request::query($filter['key']) }}">
					</div>
				@elseif ($filter['type'] == 'select')
					<div class="col-md-4">
						<select name="{{ $filter['key'] }}" class="form-control">
							<option value="">{{ trans('mconsole::traits.filterable.notselected') }}</option>
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
	<div class="form-actions">
		<div class="row">
			<div class="col-md-offset-3 col-md-9">
				<button type="submit" class="btn btn-sm blue">{{ trans('mconsole::traits.filterable.apply') }}</button>
				<a href="#" class="btn btn-sm">{{ trans('mconsole::traits.filterable.reset') }}</a>
			</div>
		</div>
	</div>
</form>