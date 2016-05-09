@if (isset($item))
    {!! Form::model($item, ['method' => 'PUT', 'url' => mconsole_url(sprintf('users/%s', $item->id))]) !!}
@else
    {!! Form::open(['method' => 'POST', 'url' => mconsole_url('users')]) !!}
@endif
    <div class="row">
    	<div class="col-md-4 col-sm-6">
            <div class="portlet light">
                @include('mconsole::partials.portlet-title', [
                    'back' => mconsole_url('users'),
                    'title' => trans('mconsole::users.form.main'),
                ])
                <div class="portlet-body form">
        				@include('mconsole::forms.text', [
        					'label' => trans('mconsole::users.form.name'),
        					'name' => 'name',
        					'placeholder' => trans('mconsole::users.form.placeholder.name')
        				])
        				@include('mconsole::forms.text', [
        					'label' => trans('mconsole::users.form.email'),
        					'name' => 'email',
        					'placeholder' => trans('mconsole::users.form.placeholder.email')
        				])
        				@include('mconsole::forms.select', [
        					'label' => trans('mconsole::users.form.language'),
        					'name' => 'lang',
        					'options' => [
        						'ru' => 'ru',
        						'en' => 'en',
        					],
        				])
        				
                        @if (Auth::user()->role->key == 'root')
                            @if (!isset($item) || (isset($item->id) && $item->id != Auth::id()))
                                @include('mconsole::forms.select', [
                					'label' => trans('mconsole::users.form.role'),
                					'name' => 'role_id',
                					'options' => $roles->toArray(),
                				])
                            @endif
                        @endif
                        
        				@if (!isset($item))
        					@include('mconsole::forms.password', [
        						'label' => trans('mconsole::users.form.password'),
        						'name' => 'password',
        						'placeholder' => trans('mconsole::users.form.placeholder.password'),
        					])
                        @elseif (Auth::id() == $item->id)
                            @include('mconsole::forms.password', [
        						'label' => trans('mconsole::users.form.changepassword'),
        						'name' => 'password',
        						'placeholder' => trans('mconsole::users.form.placeholder.changepassword'),
        					])
        				@endif
            			<div class="form-actions">
            				@include('mconsole::forms.submit')
            			</div>
                    </div>
                </div>
            </div>
            @if (isset($item->id) && Auth::id() == $item->id)
                <div class="col-md-8 col-sm-6">
                    <div class="portlet light">
                        @include('mconsole::partials.portlet-title', [
                            'title' => trans('mconsole::users.form.quickmenu'),
                        ])
                        @foreach (app('API')->quickmenu->get() as $qmItem)
                            <div class=""><input name="menu[]" type="hidden" value="{{ $qmItem['link'] }}" />{{ $qmItem['text'] }}</div>
                        @endforeach
                    </div>
                </div>
            @endif
    	</div>
    </div>
{!! Form::close() !!}