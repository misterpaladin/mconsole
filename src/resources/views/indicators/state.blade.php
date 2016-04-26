@if ($enabled)
    <span class="label bg-green-meadow bg-font-green-meadow">{{ trans('mconsole::tables.state.on') }}</span>
@else
    <span class="label label-default">{{ trans('mconsole::tables.state.off') }}</span>
@endif