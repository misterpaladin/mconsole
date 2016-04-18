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

@if (Session::has('warning'))
    @if (is_array(Session::get('warning')) && count(Session::get('warning')) > 0)
        @foreach (Session::get('warning') as $warning)
            @include('mconsole::partials.notification', [
                'type' => 'warning',
                'text' => $warning,
            ])
        @endforeach
    @elseif (strlen(Session::get('warning')) > 0)
        @include('mconsole::partials.notification', [
            'type' => 'warning',
            'text' => Session::get('warning'),
        ])
    @endif
@endif