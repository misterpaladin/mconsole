var Variables = function (container) {
    this.container = container;
    this.add = $('.add-variable');
    this.submit = $('.submit');
    
    this.toggleSubmit();
    this.container.on('click', '.remove-variable', this.removeVariable.bind(this));
    this.add.on('click', this.appendVariable.bind(this));
}

/**
 * Insert new variable form
 * 
 * @return void
 */
Variables.prototype.appendVariable = function () {
    var next = this.container.find('.row').length + 1;
    var item = $('.variables-template .row').clone();
    for (var i in item.find('input')) {
        var input = item.find('input').eq(i);
        input.attr('name', 'variables[' + next + '][' + input.data('name') + ']');
    }
    this.container.append(item);
    this.toggleSubmit();
}

/**
 * Remove variable
 * 
 * @param  Event e
 * @return void
 */
Variables.prototype.removeVariable = function (e) {
    var row = $(e.target).closest('.row').remove();
}

/**
 * Show / hide submit button
 * 
 * @return void
 */
Variables.prototype.toggleSubmit = function () {
    if (this.container.find('.row').length > 0) {
        this.submit.removeClass('hide');
    } else {
        this.submit.addClass('hide');
    }
}

$(function () {
    var container = $('.variables-list');
    if (container.length > 0) {
        var variables = new Variables(container);
    }
});