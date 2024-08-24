<div class="row">
	<div class="col-md-4 col-sm-6">
        <div class="portlet light">
            @include('mconsole::partials.portlet-title', [
                'back' => mconsole_url('menus'),
                'title' => trans('mconsole::menus.form.main'),
            ])
            <div class="portlet-body form">
        		<div class="form-body">
                    <form method="POST" action="{{ mconsole_url(isset($item) ? sprintf('menus/%s', $item->id) : 'menus') }}">
                        @if (isset($item))@method('PUT')@endif
                        @csrf
                        @include('mconsole::forms.text', [
                            'label' => trans('mconsole::menus.form.name'),
                            'name' => 'name',
                            'placeholder' => trans('mconsole::menus.form.placeholder'),
                            'value' => $item->name ?? null,
                        ])
                        @include('mconsole::forms.state', isset($item) ? $item : [])
                </div>
                
    			<div class="form-actions">
    				@include('mconsole::forms.submit')
    			</div>
            </div>
        </div>
    </div>
    <div class="col-md-8 col-sm-6">
        <div class="portlet light">
            @include('mconsole::partials.portlet-title', [
                'name' => 'tree',
                'title' => trans('mconsole::menus.form.tree'),
            ])
            <div class="portlet-body form">
        		<div class="form-body">
    				@include('mconsole::forms.hidden', [
    					'name' => 'tree',
                        'value' => $item->tree ?? null,
    				])
                    @jstrans([
                        'menu-editor-text' => trans('mconsole::menus.form.text'),
                        'menu-editor-add' => trans('mconsole::menus.form.add'),
                        'menu-editor-delete' => trans('mconsole::menus.form.delete'),
                        'menu-editor-link' => trans('mconsole::menus.form.link'),
                        'menu-editor-blank' => trans('mconsole::menus.form.blank'),
                    ])
                    <div class="tabbable-line">
						<ul class="nav nav-tabs">
                            @foreach ($languages as $key => $language)
    							<li @if ($key == 0) class="active" @endif>
    								<a href="#lang_{{ $language->id }}" data-toggle="tab"> {{ $language->name }}  </a>
    							</li>
                            @endforeach
						</ul>
						<div class="tab-content">
                            @foreach ($languages as $key => $language)
    							<div class="tab-pane fade @if ($key == 0) active @endif in" id="lang_{{ $language->id }}">
                                    <div class="menu-editor" data-lang="{{ $language->key }}"></div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	</form>
</div>