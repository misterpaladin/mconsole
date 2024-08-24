<form method="POST" action="{{ mconsole_url(isset($item) ? sprintf('languages/%s', $item->id) : 'languages') }}">
    @if (isset($item))@method('PUT')@endif
	@csrf
    <div class="row">
    	<div class="col-md-4 col-sm-6">
            <div class="portlet light">
                @include('mconsole::partials.portlet-title', [
                    'back' => mconsole_url('languages'),
                    'title' => trans('mconsole::languages.form.main'),
                ])
                <div class="portlet-body form">
            		<div class="form-body">
        				@include('mconsole::forms.text', [
        					'label' => trans('mconsole::languages.form.name'),
        					'name' => 'name',
        					'placeholder' => trans('mconsole::languages.form.placeholders.name'),
							'value' => $item->name ?? null,
        				])
                        @include('mconsole::forms.text', [
        					'label' => trans('mconsole::languages.form.key'),
        					'name' => 'key',
        					'placeholder' => trans('mconsole::languages.form.placeholders.key'),
							'value' => $item->key ?? null,
        				])
                    </div>
        			<div class="form-actions">
        				@include('mconsole::forms.submit')
        			</div>
                </div>
            </div>
    	</div>
    </div>
</form>