<div class="bg-dark bg-font-dark variables-helper">
    <div class="helper-title sbold uppercase">Variables <span class="btn btn-xs default helper-close"><i class="fa fa-remove"></i></span></div>
    <div class="helper-body">
        <div class="list">
            @foreach ($variables as $variable)
                <div class="btn btn-xs bg-default bg-font-default variable-item" data-key="{{ $variable->key }}" data-value="{{ $variable->value }}">{{ $variable->key }}</div>
            @endforeach
        </div>
        <div class="variable-input">
            <div class="input-list"></div>
            <span class="btn btn-xs green-jungle variable-use">Use</span>
            <span class="btn btn-xs blue variable-copy">Copy</span>
            <span class="btn btn-xs default variable-back">Back</span>
        </div>
    </div>
</div>