@if (count($views) > 0)
    <hr/>
    @foreach ($views as $view)
        {!! $view !!}
    @endforeach
@endif