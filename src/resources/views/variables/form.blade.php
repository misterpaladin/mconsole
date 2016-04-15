@extends('mconsole::app')

@section('content')

<div class="row">
	<div class="col-xs-12">
        {!! Form::open(['method' => 'POST', 'url' => '/mconsole/variables']) !!}
		<div class="form-body">
			<div class="row">
                <div class="col-xs-12">
                    <div class="portlet light">
        				@include('mconsole::partials.portlet-title', [
                            'title' => trans('mconsole::variables.menu.name'),
                        ])
        				<div class="portlet-body">
                            @include('mconsole::partials.note', [
                                'title' => trans('mconsole::variables.form.info.title'),
                                'text' => trans('mconsole::variables.form.info.text'),
                            ])
                            <div class="variables-template hide">
                                <div class="row">
                                    <div class="col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label>{{ trans('mconsole::variables.form.key') }}</label>
                                            <input data-name="key" class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label>{{ trans('mconsole::variables.form.value') }}</label>
                                            <input data-name="value" class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xs-12">
                                        <div class="form-group">
                                            <label>{{ trans('mconsole::variables.form.description') }}</label>
                                            <input data-name="description" class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-1 col-xs-12 text-right">
                                        <span class="btn btn-xs btn-danger remove-variable"><i class="fa fa-remove"></i></span>
                                    </div>
                                    <div class="col-xs-12">
                                        <hr/>
                                    </div>
                                </div>
                            </div>
                            <div class="variables-list">
                                @forelse ($variables as $key => $variable)
                                    <div class="row">
                                        <div class="col-sm-4 col-xs-12">
                                            @include('mconsole::forms.text', [
                                                'label' => trans('mconsole::variables.form.key'),
                                                'name' => sprintf('variables[%s][key]', $key),
                                                'value' => $variable->key,
                                            ])
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            @include('mconsole::forms.text', [
                                                'label' => trans('mconsole::variables.form.value'),
                                                'name' => sprintf('variables[%s][value]', $key),
                                                'value' => $variable->value,
                                            ])
                                        </div>
                                        <div class="col-sm-3 col-xs-12">
                                            @include('mconsole::forms.text', [
                                                'label' => trans('mconsole::variables.form.description'),
                                                'name' => sprintf('variables[%s][description]', $key),
                                                'value' => $variable->description,
                                            ])
                                        </div>
                                        <div class="col-sm-1 col-xs-12 text-right">
                                            <span class="btn btn-xs btn-danger remove-variable"><i class="fa fa-remove"></i></span>
                                        </div>
                                        <div class="col-xs-12">
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
		{!! Form::close() !!}
	</div>
</div>

@endsection

@section('page.scripts')
    <script src="/massets/js/variables.js" type="text/javascript">
@endsection