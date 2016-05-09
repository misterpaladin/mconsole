<div class="row">
	<div class="col-md-4 col-sm-6">
        <div class="portlet light">
            @include('mconsole::partials.portlet-title', [
                    'back' => '/mconsole/tags',
                    'title' => trans('mconsole::tags.form.main'),
                ])
            <div class="portlet-body form">
            		<div class="form-body">
                        @if (isset($item))
                			{!! Form::model($item, ['method' => 'PUT', 'url' => mconsole_url(sprintf('tags/%s', $item->id))]) !!}
                		@else
                			{!! Form::open(['method' => 'POST', 'url' => mconsole_url('tags')]) !!}
                		@endif
        				@include('mconsole::forms.text', [
        					'label' => trans('mconsole::tags.form.name'),
        					'name' => 'name',
        					'placeholder' => trans('mconsole::tags.form.placeholder')
        				])
                        
                        @include('mconsole::forms.colorpicker', [
                            'label' => trans('mconsole::tags.form.color'),
                            'name' => 'color',
                        ])
                        
                    </div>
                    
        			<div class="form-actions">
        				@include('mconsole::forms.submit')
        			</div>
                </div>
            </div>
        </div>
		{!! Form::close() !!}
	</div>
</div>