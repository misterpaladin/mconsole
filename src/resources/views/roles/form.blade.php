@extends('mconsole::app')

@section('content')

<div class="row">
	<div class="col-xs-12">
        @if (isset($item))
            {!! Form::model($item, ['method' => 'PUT', 'route' => ['mconsole.roles.update', $item->id]]) !!}
        @else
            {!! Form::open(['method' => 'POST', 'url' => '/mconsole/roles']) !!}
        @endif
		<div class="form-body">
			<div class="row">
                <div class="col-md-4">
                    <div class="portlet light">
        				<div class="portlet-title">
        					<div class="caption">
        						<span class="caption-subject font-blue sbold uppercase">{{ trans('mconsole::roles.form.main') }}</span>
        					</div>
        				</div>
        				<div class="portlet-body form">
                			@include('mconsole::forms.text', [
                				'label' => trans('mconsole::roles.form.name'),
                				'name' => 'name',
                				'placeholder' => 'Moderator'
                			])
        				</div>
        			</div>
                    <div class="form-actions">
            			@include('mconsole::forms.submit')
            		</div>
                </div>
                <div class="col-md-8">
                    <div class="portlet light">
        				<div class="portlet-title">
        					<div class="caption">
        						<span class="caption-subject font-blue sbold uppercase">{{ trans('mconsole::roles.form.permissions') }}</span>
        					</div>
        				</div>
        				<div class="portlet-body form">
                            <table class="table table-hover table-striped">
            					<thead>
            						<tr class="uppercase">
                                        <th></th>
            							<th>Page name</th>
            							<th>Description</th>
            						</tr>
            					</thead>
            					<tbody>
            						@foreach ($menu as $menuItem)
            							<tr>
                                            <td>
                                                @if (!empty($menuItem->route))
                                                    <label><input type="checkbox" name="routes[{{ $menuItem->route }}]" class="form-control" @if (isset($item) && in_array($menuItem->route, $item->routes)) checked @endif></label>
                                                @endif
                                            </td>
            								<td>{{ trans('mconsole::' . $menuItem->translation) }}</td>
            								<td>{{ trans('mconsole::' . $menuItem->description) }}</td>
            							</tr>
            						@endforeach
            					</tbody>
            				</table>
        				</div>
        			</div>
                </div>
            </div>
		</div>
		{!! Form::close() !!}
	</div>
</div>

@endsection