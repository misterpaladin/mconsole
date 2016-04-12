@if (count($item->models) > 0)
    <li> {{ trans('mconsole::modules.table.models') }}
        <ul>
            @foreach ($item->models as $model)
                <li data-jstree='{ "type" : "file" }'> {{ $model }} </li>
            @endforeach
        </ul>
    </li>
@endif

@if (count($item->controllers) > 0)
    <li> {{ trans('mconsole::modules.table.controllers') }}
        <ul>
            @foreach ($item->controllers as $controller)
                <li data-jstree='{ "type" : "file" }'> {{ $controller }} </li>
            @endforeach
        </ul>
    </li>
@endif

@if (count($item->requests) > 0)
    <li> {{ trans('mconsole::modules.table.requests') }}
        <ul>
            @foreach ($item->requests as $request)
                <li data-jstree='{ "type" : "file" }'> {{ $request }} </li>
            @endforeach
        </ul>
    </li>
@endif

@if (count($item->migrations) > 0)
    <li> {{ trans('mconsole::modules.table.migrations') }}
        <ul>
            @foreach ($item->migrations as $migration)
                <li data-jstree='{ "type" : "file" }'> {{ $migration }} </li>
            @endforeach
        </ul>
    </li>
@endif

@if (count($item->views) > 0)
    <li> {{ trans('mconsole::modules.table.views') }}
        <ul>
            @foreach ($item->views as $view)
                <li data-jstree='{ "type" : "file" }'> {{ $view }} </li>
            @endforeach
        </ul>
    </li>
@endif

@if (count($item->translations) > 0)
    <li> {{ trans('mconsole::modules.table.translations') }}
        <ul>
            @foreach ($item->translations as $translation)
                <li data-jstree='{ "type" : "file" }'> {{ $translation }} </li>
            @endforeach
        </ul>
    </li>
@endif
