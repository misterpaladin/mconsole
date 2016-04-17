<div class="hide">
    @foreach ($lang as $key => $value)
        <input type="hidden" disabled="disabled" name="trans-{{ $key }}" value="{{ $value }}" />
    @endforeach
</div>