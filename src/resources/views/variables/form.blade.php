@extends('mconsole::app')

@section('content')

<div class="row">
	<div class="col-xs-12">
        <form method="POST" action="{{ mconsole_url('variables') }}">
            @csrf
		<div class="form-body">
			<div class="row">
                <div class="col-xs-12">
                    <div class="portlet light">
                        @include('mconsole::partials.portlet-title', [
                            'title' => trans('mconsole::variables.tabs.main'),
                            'fullscreen' => true,
                        ])
        				<div class="portlet-body">
                            @include('mconsole::partials.note', [
                                'title' => trans('mconsole::variables.form.info.title'),
                                'text' => trans('mconsole::variables.form.info.text'),
                            ])
                            <div class="variables-template hide">
                                <div class="row">
                                    <div class="col-sm-2 col-xs-12">
                                        <div class="form-group">
                                            <label>{{ trans('mconsole::variables.form.key') }}</label>
                                            <input data-name="key" class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>{{ trans('mconsole::variables.form.value') }}</label>
                                            <textarea data-name="value" class="form-control" rows="4"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label>{{ trans('mconsole::variables.form.description') }}</label>
                                            <input data-name="description" class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 text-right">
                                        <span class="btn btn-xs blue-soft copy-variable"><i class="fa fa-copy"></i> {{ trans('mconsole::variables.form.copy.single') }}</span>
                                        <span class="btn btn-xs btn-danger remove-variable"><i class="fa fa-remove"></i> {{ trans('mconsole::variables.form.delete') }}</span>
                                        <hr/>
                                    </div>
                                </div>
                            </div>
                            <div class="variables-list">
                                @forelse ($variables as $key => $variable)
                                    <div class="row">
                                        <div class="col-sm-2 col-xs-12">
                                            @include('mconsole::forms.text', [
                                                'label' => trans('mconsole::variables.form.key'),
                                                'name' => sprintf('variables[%s][key]', $key),
                                                'value' => $variable->key,
                                            ])
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                            @include('mconsole::forms.textarea', [
                                                'label' => trans('mconsole::variables.form.value'),
                                                'name' => sprintf('variables[%s][value]', $key),
                                                'value' => $variable->value,
                                                'size' => '12x4',
                                            ])
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            @include('mconsole::forms.text', [
                                                'label' => trans('mconsole::variables.form.description'),
                                                'name' => sprintf('variables[%s][description]', $key),
                                                'value' => $variable->description,
                                            ])
                                        </div>
                                        <div class="col-xs-12 text-right">
                                            <span class="btn btn-xs blue-soft copy-variable"><i class="fa fa-copy"></i> {{ trans('mconsole::variables.form.copy.single') }}</span>
                                            <span class="btn btn-xs blue-soft copy-variable multiline"><i class="fa fa-copy"></i> {{ trans('mconsole::variables.form.copy.multiline') }}</span>
                                            <span class="btn btn-xs btn-danger remove-variable"><i class="fa fa-remove"></i> {{ trans('mconsole::variables.form.delete') }}</span>
                                            <hr/>
                                        </div>
                                    </div>
                                @empty
                                    <p>{{ trans('mconsole::tables.notfound') }}</p>
                                @endforelse
                            </div>
                            <div class="form-actions">
                    			<div class="row">
                                    <div class="col-sm-4 hide submit">
                                        @include('mconsole::forms.submit')
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="btn green-jungle form-control add-variable">{{ trans('mconsole::variables.buttons.add')}}</span>
                                    </div>
                                </div>
                    		</div>
        				</div>
        			</div>
                </div>
            </div>
		</div>
		</form>
	</div>
</div>

@endsection

@section('page.scripts')
    <script src="/massets/js/variables.js" type="text/javascript"></script>
@endsection