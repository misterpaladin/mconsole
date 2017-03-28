<div class="uploadable" action="{{ mconsole_url('api/uploads/upload') }}" method="POST" enctype="multipart/form-data">
    <input type="hidden" class="uploadable-id" value="{{ $id }}" />
    <input type="hidden" class="uploadable-group" value="{{ $group }}" />
    <input type="hidden" class="uploadable-type" name="uploads[{{ $type }}][{{ $group }}][type]" value="{{ $type }}" />
    <input type="hidden" class="uploadable-class" name="uploads[{{ $type }}][{{ $group }}][related_class]" value="{{ $model }}"/>
    
    @if ((isset($presets) && $presets->count() == 0) || (isset($type) && isset($presets) && $presets->where('type', $type)->count() == 0  && $type != MconsoleUploadType::Any))
        <div class="alert alert-danger">
            <p>{{ trans('mconsole::uploader.errors.nopresets.text')}}</p>
            <p><a href="{{ mconsole_url('presets/create') }}" class="btn btn-xs blue">{{ trans('mconsole::uploader.errors.nopresets.link') }}</a></p>
        </div>
    @else
        @if (isset($presets) && isset($selector) && $selector === true)
            @include('mconsole::forms.select', [
                'label' => trans('mconsole::uploader.selector'),
                'name' => sprintf('uploads[%s][%s][preset]', $type, $group),
                'options' => isset($type) && $type != MconsoleUploadType::Any ? $presets->where('type', $type)->pluck('name', 'id')->toArray() : $presets->pluck('name', 'id')->toArray(),
                'value' => isset($preset) ? $presets->where('key', $preset)->first()->id : null,
            ])
        @else
            <input type="hidden" class="uploadable-preset" name="uploads[{{ $type }}][{{ $group }}][preset]" value="{{ $preset }}"/>
        @endif
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="col-xs-12 buttons-set">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-xs green fileinput-button disabled">
                    <i class="fa fa-plus"></i>
                    <span> {{ trans('mconsole::uploader.add') }} </span>
                    <input type="file" name="files[]" @if (isset($multiple) && $multiple === true) multiple="" @endif> </span>
                <button type="submit" class="btn btn-xs blue start hide disabled">
                    <i class="fa fa-upload"></i>
                    <span> {{ trans('mconsole::uploader.upload') }} </span>
                </button>
                <button type="button" class="btn btn-xs blue description disabled">
                    <i class="fa fa-info-circle"></i>
                    <span> {{ trans('mconsole::uploader.description') }} </span>
                </button>
                <button type="button" class="btn btn-xs red delete disabled">
                    <i class="fa fa-trash"></i>
                    <span> {{ trans('mconsole::uploader.delete') }} </span>
                </button>
                <input type="checkbox" class="toggle">
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 text-center">
                <span class="fileupload-process"> </span>
            </div>
        </div>
        <div class="text-center loader" style="font-size: 20px; margin-top: 20px;"><i class="fa fa-spin fa-spinner"></i></div>
        <div class="row fileupload-buttonbar">
            <!-- The global progress information -->
            <div class="col-xs-12 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-success" style="width:0%;"> </div>
                </div>
            </div>
        </div>
    @endif
    <!-- The table listing the files available for upload/download -->
    <table role="presentation" class="clearfix" style="width: 100%;">
        <tbody class="files sortable"></tbody>
    </table>
</div>
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<script id="template-upload-{{ $group }}" type="text/x-tmpl"> {% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="file-info" colspan="3">
            <div class="name">{%=file.name%}</div>
            <strong class="error label label-danger"></strong>
            <p class="size">{{ trans('mconsole::uploader.processing') }}</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                <div class="progress-bar progress-bar-success" style="width:0%;"></div>
            </div>
        </td>
        <td> {% if (!i && !o.options.autoUpload) { %}
            <button class="btn btn-xs blue start" disabled>
                <i class="fa fa-upload"></i>
            </button> {% } %} {% if (!i) { %}
            <button class="btn btn-xs red cancel">
                <i class="fa fa-ban"></i>
            </button> {% } %} </td>
    </tr> {% } %} </script>
<!-- The template to display files available for download -->
<script id="template-download-{{ $group }}" type="text/x-tmpl"> {% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade sortable-item">
        {% if (file.deleteUrl) { %}
        <td width="1%">
            <input type="checkbox" name="delete" value="1" class="toggle">
        </td>
        {% } %}
        @if ($type == 'image')
            <td>
                <span class="preview">
                    {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery>
                        <img src="{%=file.thumbnailUrl%}">
                    </a>
                    {% } %}
                </span>
            </td>
        @endif
        <td class="file-info">
            <input type="hidden" class="uploadable-language-id" value="{%=file.language_id%}">
            <input type="hidden" class="uploadable-filename" name="uploads[{{ $type }}][{{ $group }}][files][]" value="{%=file.name%}">
            <div class="name"> {% if (file.url) { %}
                <span class="size">{%=o.formatFileSize(file.size)%}</span><br/>
                <span>{%=file.name%}</span> {% } %} </div> {% if (file.error) { %}
            <div class="help-block">
                <span class="label label-danger">Error</span> {%=file.error%}</div> {% } %}
                <div class="description hide">
                    <div class="form-group">
                        {!! Form::select(sprintf('uploads[%s][%s][language_id][]', $type, $group), $languages, null, ['class' => 'form-control input-sm']) !!}
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control input-sm" name="{{ sprintf('uploads[%s][%s][title][]', $type, $group) }}" value="{%=file.title%}" placeholder="{{ trans('mconsole::uploader.title') }}">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control input-sm" name="{{ sprintf('uploads[%s][%s][description][]', $type, $group) }}" value="{%=file.description%}" placeholder="{{ trans('mconsole::uploader.description') }}">
                    </div>
                </div>
        </td>
        <td class="controls">
            <div class="btn btn-xs blue drag"><i class="fa fa-bars"></i></div>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-xs btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}" {% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}' {%
            } %}><i class="fa fa-trash"></i></button>
            {% } else { %}
            <button class="btn yellow cancel btn-xs">
                <i class="fa fa-ban"></i>
            </button> {% } %}</td>
    </tr> {% } %} </script>