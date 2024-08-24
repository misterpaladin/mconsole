@include('mconsole::forms.checkbox', [
    'label' => trans('mconsole::settings.options.on'),
    'name' => 'enabled',
    'checked' => true,
    'value' => $item->enabled ?? null,
])