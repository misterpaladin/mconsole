@if (count($item->models) > 0)
    <li> Models
        <ul>
            @foreach ($item->models as $model)
                <li data-jstree='{ "type" : "file" }'> {{ $model }} </li>
            @endforeach
        </ul>
    </li>
@endif

@if (count($item->controllers) > 0)
    <li> Controllers
        <ul>
            @foreach ($item->controllers as $controller)
                <li data-jstree='{ "type" : "file" }'> {{ $controller }} </li>
            @endforeach
        </ul>
    </li>
@endif

@if (count($item->requests) > 0)
    <li> Requests
        <ul>
            @foreach ($item->requests as $request)
                <li data-jstree='{ "type" : "file" }'> {{ $request }} </li>
            @endforeach
        </ul>
    </li>
@endif

@if (count($item->migrations) > 0)
    <li> Migrations
        <ul>
            @foreach ($item->migrations as $migration)
                <li data-jstree='{ "type" : "file" }'> {{ $migration }} </li>
            @endforeach
        </ul>
    </li>
@endif

@if (count($item->views) > 0)
    <li> Views
        <ul>
            @foreach ($item->views as $view)
                <li data-jstree='{ "type" : "file" }'> {{ $view }} </li>
            @endforeach
        </ul>
    </li>
@endif

@if (count($item->translations) > 0)
    <li> Translations
        <ul>
            @foreach ($item->translations as $translation)
                <li data-jstree='{ "type" : "file" }'> {{ $translation }} </li>
            @endforeach
        </ul>
    </li>
@endif
