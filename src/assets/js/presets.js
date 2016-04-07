var Presets = function () {
    this.json = $('input[name="operations"]');
    this.add = $('.preset-add-operation');
    this.list = $('.operations-list');
    
    if (this.json.val().length > 5) {
        var json = JSON.parse(this.json.val());
        for (var i in json) {
            this.appendPresetOperation(json[i]);
        }
    }
    
    this.add.on('click', function () {
        this.appendPresetOperation();
    }.bind(this));
    
    this.list.on('keyup change click', 'input, select', this.evalJSON.bind(this));
    
}

Presets.prototype.evalJSON = function () {
    var json = [];
    this.list.find('form').map(function (i, form) {
        var data = {};
        var serialized = $(form).serializeArray();
        for (var i in serialized) {
            data[serialized[i].name] = serialized[i].value;
        }
        json.push(data);
    });
    this.json.val(JSON.stringify(json));
}

/**
 * Insert new operation
 */
Presets.prototype.appendPresetOperation = function (options) {
    var preset = new PresetOperation(this.evalJSON.bind(this), options);
    this.list.append(preset.selector);
}

/**
 * PresetOperation class
 */
var PresetOperation = function (updateCallback, options) {
    this.updateCallback = updateCallback;
    this.templates = $('.preset-operation-template');
    this.selector = this.makeElement(options);
    this.selector.find('select[name="operation"]').on('change', this.switchType.bind(this));
}

/**
 * Create new DOM element
 * 
 * @return Object
 */
PresetOperation.prototype.makeElement = function (options) {
    var element = $(this.templates.find('div[data-type="types"]')).clone();
    
    if (options) {
        element.find('select[name="operation"]').val(options.operation);
        this.switchType(element.find('select[name="operation"]'), options);
    }
    
    element.on('click', '.remove-operation', function () {
        this.selector.remove();
        if (this.updateCallback)
            this.updateCallback();
    }.bind(this));
    
    return element;
}

PresetOperation.prototype.switchType = function (e, options) {
    var $select = (e.target) ? $(e.target) : $(e);
    console.log($select);
    var $optionsContainer = $select.parent().next();
    $optionsContainer.html('');
    var $options = $(this.templates.find('div[data-type="' + $select.val() + '"]')).clone();
    
    if (options) {
        for (var key in options) {
            $options.find('[name="' + key + '"]').val(options[key]);
        }
    }
    
    if ($options.length > 0) {
        $options.find('.popovers').popover();
        $optionsContainer.html($options);
    }
}

$(function () {
    var presets = new Presets();
});