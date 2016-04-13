<div class="portlet-title">
    @if (isset($title))
        <div class="caption">
			<span class="caption-subject font-blue sbold uppercase">{{ $title }}</span>
		</div>
    @endif
    <div class="actions">
        @if (isset($actions))
            {!! $actions !!}
        @endif
        @if (isset($fullscreen) && $fullscreen == true)
            <a title="" data-original-title="{{ trans('mconsole::mconsole.fullscreen') }}" class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;"> </a>
        @endif
    </div>
</div>