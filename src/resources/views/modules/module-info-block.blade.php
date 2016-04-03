@if (count($item->models) > 0)
    <strong>Models:</strong>
    <ul>
        @foreach ($item->models as $model)
            <li>{{ $model }}</li>
        @endforeach
    </ul>
@endif

@if (count($item->controllers) > 0)
    <strong>Controllers:</strong>
    <ul>
        @foreach ($item->controllers as $controller)
            <li>{{ $controller }}</li>
        @endforeach
    </ul>
@endif

@if (count($item->requests) > 0)
    <strong>Requests:</strong>
    <ul>
        @foreach ($item->requests as $request)
            <li>{{ $request }}</li>
        @endforeach
    </ul>
@endif

@if (count($item->views) > 0)
    <strong>Views:</strong>
    <ul>
        @foreach ($item->views as $view)
            <li>{{ $view }}</li>
        @endforeach
    </ul>
@endif

@if (count($item->migrations) > 0)
    <strong>Migrations:</strong>
    <ul>
        @foreach ($item->migrations as $migration)
            <li>{{ $migration }}</li>
        @endforeach
    </ul>
@endif
