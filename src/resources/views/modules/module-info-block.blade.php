@if (count($item->models) > 0)
    <li> {{ trans('mconsole::modules.table.models') }}
        <ul>
            @foreach ($item->models as $path)
                @foreach (File::allFiles($path) as $file)
                    <li data-jstree='{ "type" : "file" }'> {{ trim(str_replace($path, '', $file->getRealPath()), '/') }} </li>
                @endforeach
            @endforeach
        </ul>
    </li>
@endif

@if (count($item->controllers) > 0)
    <li> {{ trans('mconsole::modules.table.controllers') }}
        <ul>
            @foreach ($item->controllers as $path)
                @foreach (File::allFiles($path) as $file)
                    <li data-jstree='{ "type" : "file" }'> {{ trim(str_replace($path, '', $file->getRealPath()), '/') }} </li>
                @endforeach
            @endforeach
        </ul>
    </li>
@endif

@if (count($item->requests) > 0)
    <li> {{ trans('mconsole::modules.table.requests') }}
        <ul>
            @foreach ($item->requests as $path)
                @foreach (File::allFiles($path) as $file)
                    <li data-jstree='{ "type" : "file" }'> {{ trim(str_replace($path, '', $file->getRealPath()), '/') }} </li>
                @endforeach
            @endforeach
        </ul>
    </li>
@endif

@if (count($item->migrations) > 0)
    <li> {{ trans('mconsole::modules.table.migrations') }}
        <ul>
            @foreach ($item->migrations as $migration)
                {{-- <li data-jstree='{ "type" : "file" }'> {{ basename($migration) }} </li> --}}
            @endforeach
        </ul>
    </li>
@endif

@if (count($item->views) > 0)
    <li> {{ trans('mconsole::modules.table.views') }}
        <ul>
            @foreach ($item->views as $path)
                @foreach (File::allFiles($path) as $file)
                    <li data-jstree='{ "type" : "file" }'> {{ trim(str_replace($path, '', $file->getRealPath()), '/') }} </li>
                @endforeach
            @endforeach
        </ul>
    </li>
@endif

@if (count($item->translations) > 0)
    <li> {{ trans('mconsole::modules.table.translations') }}
        <ul>
            @foreach ($item->translations as $path)
                @foreach (File::allFiles($path) as $file)
                    <li data-jstree='{ "type" : "file" }'> {{ trim(str_replace($path, '', $file->getRealPath()), '/') }} </li>
                @endforeach
            @endforeach
        </ul>
    </li>
@endif
