@include('mconsole::forms.select', [
    'label' => trans('mconsole::settings.options.enabled'),
    'options' => ['1' => trans('mconsole::settings.options.on'), '0' => trans('mconsole::settings.options.off')],
    'name' => 'enabled',
])