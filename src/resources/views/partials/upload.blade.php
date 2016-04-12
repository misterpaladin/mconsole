<div class="uploadable" action="/mconsole/api/images/upload" method="POST" enctype="multipart/form-data">
    <input type="hidden" class="uploadable-preset" name="uploadable[{{ $group }}][preset]" value="{{ $preset }}"/>
    <input type="hidden" class="uploadable-class" name="uploadable[{{ $group }}][related_class]" value="{{ $model }}"/>
    <input type="hidden" class="uploadable-id" name="related_id" value="{{ $id }}" />
    <input type="hidden" class="uploadable-group" name="group" value="{{ $group }}" />
    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
    <div class="row fileupload-buttonbar">
        <div class="col-xs-12">
            <!-- The fileinput-button span is used to style the file input field as button -->
            <span class="btn btn-xs green fileinput-button">
                <i class="fa fa-plus"></i>
                <span> {{ trans('mconsole::uploader.add') }} </span>
                <input type="file" name="files[]" @if (isset($multiple) && $multiple === true) multiple="" @endif> </span>
            <button type="submit" class="btn btn-xs blue start hide">
                <i class="fa fa-upload"></i>
                <span> {{ trans('mconsole::uploader.upload') }} </span>
            </button>
            <button type="button" class="btn btn-xs blue description">
                <i class="fa fa-info-circle"></i>
                <span> {{ trans('mconsole::uploader.description') }} </span>
            </button>
            <button type="reset" class="btn btn-xs warning cancel">
                <i class="fa fa-ban-circle"></i>
                <span> {{ trans('mconsole::uploader.cancel') }} </span>
            </button>
            <button type="button" class="btn btn-xs red delete">
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
    <div class="row fileupload-buttonbar">
        <!-- The global progress information -->
        <div class="col-xs-12 fileupload-progress fade">
            <!-- The extended global progress information -->
            <div class="progress-extended help-block"> &nbsp; </div>
            <!-- The global progress bar -->
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar progress-bar-success" style="width:0%;"> </div>
            </div>
        </div>
    </div>
    <!-- The table listing the files available for upload/download -->
    <table role="presentation" class="table table-striped clearfix">
        <tbody class="files sortable"></tbody>
    </table>
    <div class="row">
        <div class="col-xs-12">
            <p class="help-block">{{ trans('mconsole::uploader.help', ['width' => $presets->where('key', $preset)->first()->min_width, 'height' => $presets->where('key', $preset)->first()->min_height]) }}</p>
        </div>
    </div>
</div>
<div id="blueimp-gallery-{{ $group }}" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
    <div class="slides"> </div>
    <h3 class="title"></h3>
    <a class="prev"> ‹ </a>
    <a class="next"> › </a>
    <a class="close white"> </a>
    <a class="play-pause"> </a>
    <ol class="indicator"> </ol>
</div>
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<script id="template-upload-{{ $group }}" type="text/x-tmpl"> {% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td width="1%" colspan="2">
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger label label-danger"></strong>
            <p class="size">{{ trans('mconsole::uploader.processing') }}</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                <div class="progress-bar progress-bar-success" style="width:0%;"></div>
            </div>
        </td>
        <td width="1%"> {% if (!i && !o.options.autoUpload) { %}
            <button class="btn btn-xs blue start" disabled>
                <i class="fa fa-upload"></i>
                <span>{{ trans('mconsole::uploader.upload') }}</span>
            </button> {% } %} {% if (!i) { %}
            <button class="btn btn-xs red cancel">
                <i class="fa fa-ban"></i>
                <span>{{ trans('mconsole::uploader.cancel') }}</span>
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
        <td width="1%">
            <span class="preview"> {% if (file.thumbnailUrl) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery>
                    <img src="{%=file.thumbnailUrl%}">
                </a> {% } %} </span>
        </td>
        <td>
            <input type="hidden" class="uploadable-language-id" value="{%=file.language_id%}">
            <input type="hidden" class="uploadable-filename" name="uploadable[{{ $group }}][files][]" value="{%=file.name%}">
            <p class="name"> {% if (file.url) { %}
                <span class="size">{%=o.formatFileSize(file.size)%}</span>
                <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl? 'data-gallery': ''%}>{%=file.name%}</a> {% } else { %}
                <span>{%=file.name%}</span> {% } %} </p> {% if (file.error) { %}
            <div class="help-block">
                <span class="label label-danger">Error</span> {%=file.error%}</div> {% } %}
                <div class="description hide">
                    <div class="form-group">
                        {!! Form::select(sprintf('uploadable[%s][language_id][]', $group), $languages, null, ['class' => 'form-control input-sm']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::text(sprintf('uploadable[%s][title][]', $group), '{%=file.title%}', ['class' => 'form-control input-sm', 'placeholder' => trans('mconsole::uploader.title')]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::text(sprintf('uploadable[%s][description][]', $group), '{%=file.description%}', ['class' => 'form-control input-sm', 'placeholder' => trans('mconsole::uploader.description')]) !!}
                    </div>
                </div>
        </td>
        <td class="controls"><div class="btn btn-xs blue drag"><i class="fa fa-bars"></i></div>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-xs btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}" {% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}' {%
            } %}><i class="fa fa-trash"></i></button>
            {% } else { %}
            <button class="btn yellow cancel btn-xs">
                <i class="fa fa-ban"></i>
                <span>Cancel</span>
            </button> {% } %}</td>
    </tr> {% } %} </script>