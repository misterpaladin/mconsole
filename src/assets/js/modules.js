var Module = function (module) {
    this.module = module;
    $(this.module).on('click', '.show-module-info', this.toggleInfo.bind(this));
    $(this.module).on('click', '.install-module, .uninstall-module, .extend-module', this.toggleModuleInstallation.bind(this));
}

/**
 * Toggle module info
 * @return void
 */
Module.prototype.toggleInfo = function () {
    var info = $(this.module).find('.module-info');
    if (info.hasClass('hide')) {
        info.removeClass('hide');
    } else {
        info.addClass('hide');
    }
}

/**
 * Install or uninstall module
 * @return {void}
 */
Module.prototype.toggleModuleInstallation = function (e) {
    var identifier = $(this.module).data('identifier');
    var button = $(e.target);
    if ($(e.target).hasClass('install-module')) {
        var otherButton = $(this.module).find('.uninstall-module');
        var url = 'install';
    } else if ($(e.target).hasClass('uninstall-module')) {
        var otherButton = $(this.module).find('.install-module');
        var url = 'uninstall';
    } else {
        var otherButton = null;
        var url = 'extend';
    }
    
    var allButtons = $('.extend-module, .uninstall-module, .install-module');
    var text = button.data('lang-process');
    
    if (button.hasClass('disabled')) {
        return false;
    }
    
    if (url == 'uninstall') {
        var $modal = this.uninstallDialog(button.data('modal-title'), button.data('modal-content'), button.data('modal-cancel'), button.data('modal-uninstall'));
        $('body').append($modal);
        $modal.modal({
            show: true,
        });
        $modal.on('click', '.uninstall-confirm', startRequest.bind(this));
    } else {
        startRequest();
    }
    
    function startRequest() {
        if ($modal) {
            $modal.modal('hide');
            setTimeout(1000, $modal.remove);
        }
        var oldHtml = button.html();
        allButtons.addClass('disabled');
        button.addClass('disabled').html('<i class="fa fa-spin fa-spinner"></i> ' + text);
        $.get('/mconsole/modules/' + identifier + '/' + url, function (data) {
            if (button.hasClass('extend-module')) {
                return location.reload();
            }
            button.html(oldHtml);
            button.addClass('hide');
            if (otherButton) {
                otherButton.removeClass('hide');
            }
            allButtons.removeClass('disabled');
        });
    }
}

Module.prototype.uninstallDialog = function (title, content, cancel, ok) {
    return $('<div class="modal fade" tabindex="-1" role="dialog">\
<div class="modal-dialog">\
<div class="modal-content">\
<div class="modal-header">\
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
<h4 class="modal-title">' + title + '</h4>\
</div>\
<div class="modal-body">\
<p>' + content + '</p>\
</div>\
<div class="modal-footer">\
<button type="button" class="btn btn-default" data-dismiss="modal">' + cancel + '</button>\
<button type="button" class="btn btn-danger uninstall-confirm">' + ok + '</button>\
</div>\
</div>\
</div>\
</div>');
}

$(function () {
    var rows = $('#modules-table tbody tr');
    rows.each(function (i, row) {
        new Module(row);
    });
});