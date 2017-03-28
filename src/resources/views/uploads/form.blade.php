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
                    @if (app('API')->options->getByKey('textareatype') == 'ckeditor')
                        @include('mconsole::forms.ckeditor', [
                            'label' => trans('mconsole::uploads.form.description'),
                            'name' => 'description',
                        ])
                    @else
                        @include('mconsole::forms.textarea', [
                            'label' => trans('mconsole::uploads.form.description'),
                            'name' => 'description',
                            'size' => '50x4',
                        ])
                    @endif
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