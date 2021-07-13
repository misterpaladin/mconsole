<div class="form-group">
    <label for="multiple" class="control-label">{{ trans('mconsole::forms.tags.label') }}</label>
    <select name="tags[]" class="form-control tags-select" multiple data-lang-placeholder="{{ trans('mconsole::forms.tags.placeholder') }}">
        @foreach ($allTags as $tag)
            @if (!isset($categories) || isset($categories) && in_array($tag->category, $categories))
                <option data-color="{{ $tag->color }}" value="{{ $tag->id }}"
                    @if (
                        (isset($tags) && $tags->where('id', $tag->id)->count() > 0)
                        ||
                        old('tags') !== null && in_array($tag->id, old('tags'))
                    )
                     selected="selected"
                    @endif
                >{{ $tag->name }}</option>
            @endif
        @endforeach
    </select>
</div>