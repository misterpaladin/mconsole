@jstrans([
    'blade-helper-code' => trans('mconsole::widget.code'),
    'blade-helper-copied' => trans('mconsole::widget.copied'),
])
<div class="bg-dark bg-font-dark blade-helper">
    <div class="helper-title sbold uppercase">{{ trans('mconsole::widget.name') }} <span class="btn btn-xs default helper-close blade-helper-close"><i class="fa fa-remove"></i></span></div>
    <div class="helper-body">
        <div class="list">
            <div class="form-group"><strong>{{ trans('mconsole::widget.pick') }}</strong></div>
            @foreach ($variables as $variable)
                <div class="btn btn-xs bg-default bg-font-default blade-item" data-key="{{ $variable->key }}" data-value="{{ $variable->value }}">{{ $variable->key }}</div>
            @endforeach
        </div>
        <div class="blade-input">
            <div class="input-list"></div>
            <span class="btn btn-xs blue blade-copy">{{ trans('mconsole::widget.copy') }}</span>
            <span class="btn btn-xs default blade-back">{{ trans('mconsole::widget.back') }}</span>
        </div>
    </div>
    <div class="bg-dark bg-font-dark blade-helper-search">
        <div class="helper-title sbold uppercase">{{ trans('mconsole::widget.search') }} <span class="btn btn-xs default helper-close blade-helper-search-close"><i class="fa fa-remove"></i></span></div>
        <div class="helper-body">
            <div class="form-group">
                <div class="input-icon input-icon-sm right">
                    <i class="fa fa-spin"></i>
                    <input class="form-control input-sm" name="search" placeholder="{{ trans('mconsole::widget.placeholders.search') }}" type="text">
                </div>
            </div>
            <ul class="media-list blade-search-results">
                
            </ul>
        </div>
    </div>
</div>