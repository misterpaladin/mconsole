@if ($errors->any())
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                @include('mconsole::partials.notification', [
                    'type' => 'error',
                    'text' => $error,
                ])
            @endforeach
        @endif
@endif

@if (Session::has('status'))
    @include('mconsole::partials.notification', [
        'type' => 'info',
        'text' => Session::get('status'),
    ])
@endif