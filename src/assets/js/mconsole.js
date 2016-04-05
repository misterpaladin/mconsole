var Mconsole = function () {
    
    this.notifications = {
        badge: $('.notifications-count'),
        container: $('.notifications-container'),
        items: 0,
    };
    
    var self = this;
    self.getNotifications();
    setInterval(function () {
        self.getNotifications();
    }, 10000);
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