<div class="col-lg-7 col-md-6">
    <div class="portlet light">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">{{ trans('mconsole::uploads.form.name') }}</span>
            </div>
        </div>
        <div class="portlet-body form">
            {!! Form::open(['method' => 'POST', 'url' => mconsole_url('uploads')]) !!}
                <div class="form-body">
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
                    @include('mconsole::forms.upload', [
                        'type' => MconsoleUploadType::Any,
                        'multiple' => true,
                        'group' => 'upload',
                        'selector' => true,
                        'presets' => $presets,
                        'id' => null,
                        'model' => '',
                    ])
                </div>
                <div class="form-actions">
                    @include('mconsole::forms.submit')
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="col-lg-5 col-md-6">
    <div class="portlet light">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">{{ trans('mconsole::uploads.form.help.name') }}</span>
            </div>
        </div>
        <div class="portlet-body form">
            {{ trans('mconsole::uploads.form.help.text') }}
        </div>
    </div>
</div>

@section('page.scripts')
    <script>
        new Clipboard('.copy');
    </script>
@endsection