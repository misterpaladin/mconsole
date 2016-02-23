@if ($errors->any())
	<div class="alert alert-danger">
		<button class="close" data-close="alert"></button>
		@if (count($errors->all()) == 1)
			{{ $errors->all()[0] }}
		@else
			<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
			</ul>
		@endif
	</div>
@endif

@if (Session::has('status'))
	<div class="alert alert-success">
		<button class="close" data-close="alert"></button>
		{{ Session::get('status') }}
	</div>
@endif