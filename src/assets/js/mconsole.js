var Mconsole = function () {
    
    this.notifications = {
        badge: $('.notifications-count'),
        container: $('.notifications-container'),
        items: 0,
    };
    
    this.search = {
        form: $('.search-form'),
        results: $('.search-results'),
        icon: $('.search-form').find('.submit i'),
        ajax: null,
    }
    
    $(document).on('click', ':not(.search-form), :not(.search-results)', function ($el) {
        this.search.results.hide();
    }.bind(this));
    
    this.search.form.find('input').on('click', function () {
        this.search.results.show();
    }.bind(this));
    
    this.search.form.on('submit', function () {
        return false;
    });
    
    this.search.form.on('keyup', this.handleSearch.bind(this));
    
    var self = this;
    self.getNotifications();
    setInterval(function () {
        self.getNotifications();
    }, 10000);
}

Mconsole.prototype.handleSearch = function () {
    if (this.search.form.find('input').val().length < 3) {
        return;
    }
    
    if (this.search.ajax) {
        this.search.ajax.abort();
    }
    
    this.search.icon.removeClass('icon-magnifier').addClass('fa fa-spin fa-spinner');
    
    this.search.ajax = $.ajax({
        method: 'GET',
        url: '/mconsole/api/search',
        data: this.search.form.serialize(),
    });
    
    this.search.ajax.success(this.handleSearchResults.bind(this));
}

Mconsole.prototype.handleSearchResults = function (data) {
    this.search.results.show().html('');
    if (data.length == 0) {
        this.search.results.text('No search results');
    } else {
        var results = [];
        for (var i in data) {
            var $result = $('<a href="' + data[i].link + '">' + data[i].text + '</a>');
            this.search.results.append($result);
        }
    }
    this.search.icon.removeClass('fa fa-spin fa-spinner').addClass('icon-magnifier');
}

Mconsole.prototype.getNotifications = function () {
    $.get('/mconsole/api/notifications', this.handleNotifications.bind(this));
}

Mconsole.prototype.handleNotifications = function (data) {
    this.notifications.container.html('');
    var messages = [];
    
    if (data.length == 0) {
        messages.push($(
            '<li>\
                <a href="javascript:;">\
                    <span class="details">Нет новых уведомлений</span>\
                </a>\
            </li>'
        ));
        this.notifications.badge.text('');
    } else {
        messages = data.map(function (message) {
            var link = (message.link.length > 0) ? message.link : 'javascript:;';
            var aClass = (message.link.length > 0) ? 'target="_blank"' : '';
            var icon = (message.link.length > 0) ? '<span class="pull-right label label-sm label-icon label-success"><i class="fa fa-external-link"></i> </span>' : '';
            $li = $('<li data-id="' + message.id + '"><a href="' + link + '" ' + aClass + '><span class="details">' + message.text + icon + '</span></a></li>');
            $li.on('click', function ($li) {
                $li.remove();
                this.notifications.badge.text(this.notifications.badge - 1);
                $.get('/mconsole/api/notifications/' + message.id + '/seen');
            });
            return $li;
        }.bind(this));
        this.notifications.badge.text(data.length);
    }
    
    for (var i in messages) {
        this.notifications.container.append(messages[i]);
    }
    
}

$(document).ready(function () {
    var MC = new Mconsole();
});