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
    
    if ($(e.target).hasClass('fa')) {
        var button = $(e.target).parent();
    } else {
        var button = $(e.target);
    }
    
    if (button.hasClass('install-module')) {
        var url = 'install';
    } else if (button.hasClass('uninstall-module')) {
        var url = 'uninstall';
    } else {
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
        allButtons.addClass('disabled');
        button.addClass('disabled').html('<i class="fa fa-spin fa-spinner"></i> ' + text);
        $.get('/mconsole/modules/' + identifier + '/' + url, function (data) {
            return location.reload();
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
    
    var reloadTranslations = $('.reload-translations');
    reloadTranslations.on('click', function (e) {
        if ($(this).hasClass('disabled'))
            return false;
        
        var text = $(this).data('lang-process');
        
        $(this).addClass('disabled').html('<i class="fa fa-spin fa-spinner"></i> ' + text);
        
        $.get('/mconsole/modules/reloadtrans', function (data) {
            return location.reload();
        });
        
        return false;
    });
});