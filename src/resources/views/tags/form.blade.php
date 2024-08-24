<div class="row">
	<div class="col-md-4 col-sm-6">
        <div class="portlet light">
            @include('mconsole::partials.portlet-title', [
                    'back' => mconsole_url('tags'),
                    'title' => trans('mconsole::tags.form.main'),
                ])
            <div class="portlet-body form">
            		<div class="form-body">
						<form method="POST" action="{{ mconsole_url(isset($item) ? sprintf('tags/%s', $item->id) : 'tags') }}">
							@if (isset($item))@method('PUT')@endif
							@csrf
							@include('mconsole::forms.text', [
								'label' => trans('mconsole::tags.form.name'),
								'name' => 'name',
								'placeholder' => trans('mconsole::tags.form.placeholder'),
								'value' => $item->name ?? null,
							])
							
							@include('mconsole::forms.colorpicker', [
								'label' => trans('mconsole::tags.form.color'),
								'name' => 'color',
								'value' => $item->color ?? null,
							])

							@include('mconsole::forms.select', [
								'label' => trans('mconsole::tags.form.category'),
								'name' => 'category',
								'options' => app('API')->tags->getCategories(),
								'value' => $item->category ?? null,
							])
                        
                    </div>
                    
        			<div class="form-actions">
        				@include('mconsole::forms.submit')
        			</div>
                </div>
            </div>
        </div>
		</form>
	</div>
</div>