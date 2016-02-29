var LinksEditor = function (input) {
	self = this;
	self.input = input;
	self.links = (input.val().length > 0) ? JSON.parse(input.val()) : [];
	self.init();
};

LinksEditor.prototype.factory = {};

/**
 * Make new or existing link item
 * @param  {object} item
 * @return {object}
 */
LinksEditor.prototype.generateItem = function (item) {
	var item = self.factory.linkItem(item);
	return self.factory.linkItemDOM(item);
};

/**
 * Initialize container
 * 
 * @return void
 */
LinksEditor.prototype.init = function () {
	var $container = $('<div class="links-editor-items"></div>');
	var $add = $('<div class="form-group"><div class="btn btn-sm blue form-control">+</div></div>');
	
	$add.on('click', function () {
		$container.append(self.generateItem());
	});
	
	for (var i in self.links) {
		$container.append(self.generateItem(self.links[i]));
	}
	
	$add.insertAfter(self.input);
	$container.insertAfter(self.input);
	
	$container.sortable({
		axis: 'y',
		handle: '.drag',
		stop: self.handleLinksChange,
	});
	
	self.container = $container;
	
};

/**
 * Handle links editor update
 * 
 * @return {void}
 */
LinksEditor.prototype.handleLinksChange = function () {
	if ($(this).hasClass('remove')) {
		$(this).closest('.links-editor-item').remove();
	}
	
	var $items = $(self.container).find('.links-editor-item');
	var value = [];
	
	if ($items.length > 0) {
		$items.map(function (key, item) {
			var object = {
				id: $(item).data('id'),
				title: $(item).find('input').eq(0).val(),
				url: $(item).find('input').eq(1).val(),
				order: key,
				enabled: $(item).find('input[type="checkbox"]:checked').length > 0,
			};
			if (object.title && object.url)
				value.push(object);
		});
	}
	
	self.input.val(JSON.stringify(value));
	
}

/**
 * Return existing link item or create empty
 * 
 * @param  {object} item
 * @return {object}
 */
LinksEditor.prototype.factory.linkItem = function (item) {
	return (item) ? item : {
		id: '',
		title: '',
		url: '',
		order: '',
		enabled: 1,
	};
};

/**
 * Make link item DOM element
 * 
 * @param  {object} item
 * @return {object}
 */
LinksEditor.prototype.factory.linkItemDOM = function (item) {
	var $container = $('<div class="ui-state-default links-editor-item" data-id="' + item.id + '">\
		<input class="form-control input-sm" placeholder="Title" type="text" value="' + item.title + '">\
		<div class="input-icon input-icon-sm"><i class="fa fa-link"></i><input class="form-control input-sm" placeholder="URL" type="text" value="' + item.url + '"></div>\
		<div class="btn btn-xs blue drag"><i class="fa fa-bars"></i></div>\
		<div class="btn btn-xs btn-danger remove"><i class="fa fa-trash"></i></div>\
		<label class="checkbox-inline"><input type="checkbox" value="1"> ENABLED </label>\
	</div>');
	
	if (item.enabled == 1)
		$container.find('input[type="checkbox"]').prop('checked', 'checked');
	
	$container.find('input').on('keyup click', self.handleLinksChange);
	$container.find('.remove').on('click', self.handleLinksChange);
	return $container;
};

/**
 * Declare jquery function
 * 
 * @return {object}
 */
$.fn.loadLinksEditor = function () {
	new LinksEditor(this);
};

/**
 * Search for links editor
 * 
 * @return {void}
 */
$(document).ready(function () {
	var class = '.links-editor';
	if ($(class).length > 0)
		$(class).map(function () {
			$(this).loadLinksEditor();
		});
});