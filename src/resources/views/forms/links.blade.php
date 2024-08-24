@include('mconsole::forms.select', [
    'label' => trans('mconsole::forms.links.set'),
    'name' => 'linkable_id',
    'options' => $linkable_sets->transform(function ($linkable) use (&$model, &$item, &$attribute) {
        if ($linkable->linkable_type == $model) {
            if (!isset($item) || (isset($item) && $item->id != $linkable->linkable_id)) {
                return $model::find($linkable->linkable_id);
            }
        }
    })->reject(function ($instance) {
        return is_null($instance);
    })->pluck($attribute, 'id')->prepend(trans('mconsole::forms.options.notselected'), '0')->toArray(),
])
{{-- {{ dump($item->links) }} --}}
@include('mconsole::forms.hidden', [
    'name' => 'links',
    'value' => $item->links ?? null,
    'class' => 'links-editor',
])

@jstrans([
    'links-editor-title' => trans('mconsole::forms.links.title'),
    'links-editor-url' => trans('mconsole::forms.links.url'),
    'links-editor-enabled' => trans('mconsole::forms.links.enabled'),
])