@extends('mconsole::app')

@section('title', trans('mconsole::sections.permissions.title') . ' | Mconsole')
@section('page.title', trans('mconsole::sections.permissions.title'))
@section('page.subtitle', trans('mconsole::sections.' . Request::segments()[count(Request::segments()) - 1]))

@section('content')
	
	<div class="row">
		<div class="col-xs-12">
			{!! Form::open(['url' => '/mconsole/permissions', 'method' => 'POST']) !!}
			
			<div class="table-scrollable table-scrollable-borderless">
				<table class="table table-hover table-striped">
					<thead>
						<tr class="uppercase">
							<th>Page name</th>
							<th>URL</th>
							<th>Permissions</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($menu as $item)
							<tr>
								<td>{{ trans('mconsole::' . $item->translation) }}</td>
								<td>{{ $item->url }}</td>
								<td>
									@foreach ($roles as $role)
										@if ($role->key != 'root' && strlen($item->url) > 0)
											@if ($role->menus->where('id', $item->id)->first())
												<label><input type="checkbox" name="roles[{{ $item->id }}][{{ $role->id }}]" class="form-control" checked="checked">{{ $role->name }}</label>
											@else
												<label><input type="checkbox" name="roles[{{ $item->id }}][{{ $role->id }}]" class="form-control">{{ $role->name }}</label>
											@endif
										@endif
									@endforeach
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			
			<div class="row">
				<div class="col-sm-4 col-xs-12 pull-right">
					@include('mconsole::forms.submit')
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
	
@endsection