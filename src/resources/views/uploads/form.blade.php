@if (isset($item))
    {!! Form::model($item, ['method' => 'PUT', 'url' => mconsole_url(sprintf('uploads/%s', $item->id))]) !!}
@else
    {!! Form::open(['method' => 'POST', 'url' => mconsole_url('uploads')]) !!}
@endif

<div class="row">
	<div class="col-lg-7 col-md-6">
        <div class="portlet light">
            @include('mconsole::partials.portlet-title', [
                'back' => mconsole_url('uploads'),
                'title' => trans('mconsole::forms.tabs.main'),
                'fullscreen' => true,
            ])
            <div class="portlet-body form">
    			<div class="form-body">
                    @include('mconsole::forms.select', [
                        'label' => trans('mconsole::uploads.form.language'),
                        'name' => 'language_id',
                        'options' => $languages,
                    ])
    				@include('mconsole::forms.text', [
    					'label' => trans('mconsole::uploads.form.title'),
    					'name' => 'title',
                    ])
                    @include('mconsole::forms.text', [
    					'label' => trans('mconsole::uploads.form.link'),
    					'name' => 'link',
    				])
                    @include('mconsole::forms.textarea', [
                        'label' => trans('mconsole::uploads.form.description'),
                        'name' => 'description',
                        'size' => '50x4',
                    ])
    			</div>
                <div class="form-actions">
                    @include('mconsole::forms.submit')
                </div>
            </div>
        </div>
	</div>
    
    <div class="col-lg-5 col-md-6">
        <div class="portlet light">
			<div class="portlet-title">
				<div class="caption">
					<span class="caption-subject font-blue sbold uppercase">{{ trans('mconsole::uploads.table.copies') }}</span>
				</div>
			</div>
			<div class="portlet-body form">
                @if (isset($item))
                    <div class="row">
                    @foreach($item->getCopies(true) as $key => $copy)
                        <div class="col-sm-6 col-md-4">
                            <div class="thumbnail">
                            <img src="{{ $copy }}" alt="">
                            <div class="caption">
                                @if(substr(mime_content_type('.'.$copy),0,5) === 'image')
                                    @php
                                        list($w, $h) = getimagesize('.'.$copy);
                                    @endphp
                                    <h4>{{ sprintf('%s (%sx%s)', $key, $w, $h) }}</h4>
                                @else
                                    <h4>{{ $key }}</h4>
                                @endif
                                <p><a href="{{ $copy }}" target="_blank" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></a> <a href="#" class="btn copy" data-clipboard-text="{{ $copy }}"><span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span></a></p>
                            </div>
                            </div>
                        </div>
                        @if(!($loop->iteration%3) && $loop->iteration != $loop->last)</div><div class="row">@endif
                    @endforeach
                    </div>
                @endif
			</div>
		</div>
    </div>

    <div class="col-lg-5 col-md-6">
        <div class="portlet light">
			<div class="portlet-title">
				<div class="caption">
					<span class="caption-subject font-blue sbold uppercase">{{ trans('mconsole::forms.tags.label') }}</span>
				</div>
			</div>
			<div class="portlet-body form">
                @if (isset($item))
                    @include('mconsole::forms.tags', [
                        'tags' => $item->tags,
                        'categories' => [0],
                    ])
                @else
                    @include('mconsole::forms.tags', [
                        'categories' => [0],
                    ])
                @endif
			</div>
		</div>
    </div>
    
</div>

{!! Form::close() !!}

@section('page.scripts')
    <script>
        new Clipboard('.copy');
    </script>
@endsection