@extends('mconsole::mconsole.app')

@section('title', 'Users | Mconsole')

@section('content')

<div class="list-table">
	<table>
		<thead>
			<tr>
				<th>#</th>
				<th>Email</th>
				<th>Name</th>
				<th>Role</th>
				<th>&nbsp;&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($items as $item)
			<tr>
				<td>{{ $item->id }}</td>
				<td>{{ $item->email }}</td>
				<td>{{ $item->name }}</td>
				<td>{{ $item->role_id }}</td>
				<td>
					<a href="{{ Request::url() }}/{{ $item->id }}/edit" class="list-icon list-edit"></a>
					{!! Form::open(['method' => 'DELETE', 'url' => Request::url().'/'.$item->id]) !!}
						{!! Form::submit('delete') !!}
					{!! Form::close() !!}
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>

@endsection