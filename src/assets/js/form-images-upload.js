var FormImagesUpload = function (selector) {
    this.element = selector;
    this.init();
}

FormImagesUpload.prototype.init = function () {
    
    var element = this.element;
    var multiple = element.find('input[type="file"]').prop('multiple');
    
    // Make images sortable
    this.element.find('tbody.files').sortable({
		axis: 'y',
		handle: '.drag',
	});
    
    // Configuration
    var config = {
        disableImageResize: true,
        autoUpload: true,
        maxNumberOfFiles: 50,
        disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator.userAgent),
        maxFileSize: 30000000,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        singleFileUploads: false,
        url: '/mconsole/api/images/upload',
        uploadTemplateId: 'template-upload-' + this.element.find('input.uploadable-group').val(),
        downloadTemplateId: 'template-download-' + this.element.find('input.uploadable-group').val(),
    }
    
    // Make single file selector if needed
    if (!multiple) {
        config.maxNumberOfFiles = 1;
    }
    
    // Initialize the jQuery File Upload widget:
    this.element.fileupload(config);
    
    // Handle element deletion
    this.element.bind('fileuploaddestroy', function (e, data) {
        e.preventDefault();
        var row = $(data.context.context).parents('tr');
        var button = row.find('button.delete');
        var filename = row.find('input.uploadable-filename').val();
        if (!button.hasClass('disabled')) {
            button.html('<i class="fa fa-spin fa-spinner"></i>');
            button.addClass('disabled');
            $.ajax({
                type: data.type,
                url: data.url,
            }).success(function () {
                row.fadeOut('normal', function () {
                    this.remove();
                });
            });
        }
    });
    
    if (!multiple) {
        this.element.find('input[type="file"]').on('change', function () {
            var filename = this.value;
            element.find('tbody.ui-sortable tr').map(function (i, row) {
                if ($(row).find('p.name').text() != filename) {
                    $(row).remove();
                }
            });
        });
    }
    
    // Load & display existing files:
    if (this.element.find('input.uploadable-id').val().length > 0) {
        this.element.addClass('fileupload-processing');
        $.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: '/mconsole/api/images/get/',
            data: {
                related_class: this.element.find('input.uploadable-class').val(),
                related_id: this.element.find('input.uploadable-id').val(),
                group: this.element.find('input.uploadable-group').val(),
            },
            dataType: 'json',
            context: this.element[0]
        }).always(function () {
            $(this).removeClass('fileupload-processing');
        }).done(function (result) {
            $(this).fileupload('option', 'done').call(this, $.Event('done'), {result: result});
        });
    }
}

$(function() {
    var elements = $('.uploadable');
    if (elements.length > 0) {
        elements.map(function (i) {
            var f = new FormImagesUpload(elements.eq(i));
        });
    }
});