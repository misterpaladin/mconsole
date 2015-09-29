/************************************************************/
/************************************************************/
/************************************************************/

var mcedit = function () {

	/** Список поддерживаемых классов */
	mcedit.classes = ["mcedit", "mcedit-html", "mcedit-javascript", "mcedit-css", "mcedit-php"];

	/** Массив для CodeMirror */
	mcedit.cm = [];

	/** Запуск первого метода */
	mcedit.init();

};

/** Поиск textarea у которых есть классы из массива mcedit.classes */
mcedit.init = function () {
	
	$('textarea').each(function () {
		for (var index in mcedit.classes) {
			if ($(this).hasClass(mcedit.classes[index])) {
				mcedit.generateContainer($(this));
				break;
			}
		}
	});
}

/** Настройки для редактора */
mcedit.generateContainer = function ($textarea) {

	/** Переменные для создания структуры */
	var $tabs, $container;
	var tabs = [];

	/** Получаем список классов textarea */
	var classes = $textarea.attr('class').split(' ');
	
	var size = new Object;
	
	size.width = $textarea.width();
	size.height = $textarea.height();
	
	/** Создаем вкладки каждому классу */
	for (var index in classes) {
		var taClass = classes[index];

		if (taClass != 'field-htmlarea') {

			/** Ищем подходящий класс и применяем настройки */
			switch (taClass) {
			case 'mcedit':
				tabs.push({
					"name": "Редактор",
					"class": "redactor"
				});
				break;

			case 'mcedit-html':
				tabs.push({
					"name": "HTML",
					"class": "html"
				});
				break;

			case 'mcedit-css':
				tabs.push({
					"name": "CSS",
					"class": "css"
				});
				break;

			case 'mcedit-javascript':
				tabs.push({
					"name": "JS",
					"class": "js"
				});
				break;

			case 'mcedit-php':
				tabs.push({
					"name": "PHP",
					"class": "php"
				});
				break;

			default:
				break;
			}
		}
	}

	$tabs = mcedit.createTabs(tabs);

	/** Собираем структуру и вставляем в документ */
	$container = $('<div>').addClass('mcedit-container').width(size.width).height(size.height);
	$textarea.parent().append($container);
	
	/** Вешаем на .mcedit-container resizable */
	$container.resizable({
		minWidth: $container.width(),
		minHeight: $container.height(),
		handles: "se", /** Ресайз только через правый нижний угол */
		resize: function () {
			
			/** Если есть CodeMirror, ресайзим вручную и обновляем окно редактора */
			if ($(this).find('.CodeMirror').length != 0) {
				$(this).find('.CodeMirror').width($(this).width()).height($(this).height());
			
				var $id = $(this).find('.cm-box').attr('cm-id');

				mcedit.cm[$id].setSize($(this).width(), $(this).height());
				mcedit.cm[$id].refresh();
			}
		}
	});
	
	$textarea.appendTo($textarea.parent().find($container));
	$tabs.insertBefore($textarea.parent());

	/** Вешаем обработчик смены табов */
	$tabs.children().on('click', function () {
		mcedit.switchEditor($(this));
	});

	/** Активируем последнюю вкладку */
	mcedit.switchEditor($tabs.children().first());

}

/** Метод смены редакторов через вкладки tab */
mcedit.switchEditor = function ($tab) {

	/** Останавливаем скрипт, если нажата уже активная вкладка */
	if ($tab[0] == $tab.parent().find('.active')[0]) return;

	/** Получаем класс элемента tab */
	var classes = $tab.attr('class').split(' ');
	var tabClass = classes[classes.length - 1];

	/** Делаем все вкладки неактивными */
	$tab.parent().children().each(function () {
		$(this).removeClass('active');
	});

	/** Делаем нажатую вкладку активной */
	$tab.addClass('active');

	var $textarea = $tab.parent().parent().find('textarea');
	var $id = $tab.parent().parent().find('.cm-box').attr('cm-id');

	/** Если существует CodeMirror, берем его значение и удаляем редактор */
	if ($tab.parent().parent().find('.cm-box').length != 0) {
		$tab.parent().parent().find('textarea').val(mcedit.cm[$id].getValue());
		$tab.parent().parent().find('.cm-box').remove();
	}

	/** Удаляем redactor, если существует */
	if ($tab.parent().parent().find('.redactor-box').length != 0) {
		$textarea.appendTo($tab.parent().parent().find('.mcedit-container'));
		$textarea.show();
		$tab.parent().parent().find('.redactor-box').remove();
	}

	switch (tabClass) {

		/** Активируем redactor */
	case 'redactor':
		mcedit.createRedactor($textarea);

		break;

	default:

		var taClasses = $textarea.attr('class').split(' ');
		var taClass = taClasses[$tab.index() + 1];
		var syntax = taClass.split('-')[1];

		mcedit.createCodeMirror($textarea, syntax);

		break;
	}

	//		$el.redactor({
	//			initCallback: function() {
	//				this.insert.set('<p>Hello world!</p>');
	//			}
	//		});

}

/** Метод для получения значения textarea в разных редакторах */
mcedit.getValue = function ($el) {

}

/** Метод для установки значения в textarea */
mcedit.setValue = function ($el) {

}

/** Создать CodeMirror редактор */
mcedit.createCodeMirror = function ($textarea, syntax) {

	switch (syntax) {
	case 'html':
		syntax = 'htmlmixed';
		break;

	default:
		break;
	}

	/** Генерируем случайное число как ключ массива с множеством CodeMirror редакторов */
	var $id = Math.floor(Math.random() * 999) + 1;
	while (typeof mcedit.cm[$id] != 'undefined') {
		var $id = Math.floor(Math.random() * 999) + 1;
	}

	$codemirror = $('<div>').addClass("cm-box").attr('cm-id', $id).insertAfter($textarea);

	mcedit.cm[$id] = CodeMirror($codemirror[0], {
		value: $textarea.val(),
		mode: syntax,
		lineNumbers: true,
		theme: "neo",
		indentWithTabs: true,
		lineWrapping: true
	});
	
	mcedit.cm[$id].on('change', function(){
		$textarea.val(mcedit.cm[$id].getValue());
	});
	
	mcedit.cm[$id].setSize({width: 100, height:$textarea.height()});
	mcedit.cm[$id].refresh();

// 	mcedit.cm[$id].autoFormatRange({line: 0, ch: 0}, {line: mcedit.cm[$id].lineCount()});
	mcedit.cm[$id].doc.setCursor({line: 0, ch: 0});

	var Pos = CodeMirror.Pos;

	/** Обработчик выделения линий в CodeMirror */
	mcedit.cm[$id].on("gutterClick", function (cm, line, gutter, e) {
		// Optionally look at the gutter passed, and ignore
		// if clicking in it means something else
		var others = e.ctrlKey || e.metaKey ? cm.listSelections() : [];
		var from = line,
			to = line + 1;

		function update() {
			var ours = {
				anchor: CodeMirror.Pos(from, to > from ? 0 : null),
				head: CodeMirror.Pos(to, 0)
			};
			cm.setSelections(others.concat([ours]), others.length, {
				origin: "*mouse"
			});
		}

		update();

		var move = function (e) {
			var curLine = cm.lineAtHeight(e.clientY, "client");
			if (curLine != to) {
				to = curLine;
				update();
			}
		};
		var up = function (e) {
			removeEventListener("mouseup", up);
			removeEventListener("mousemove", move)
		};
		addEventListener("mousemove", move);
		addEventListener("mouseup", up);
	})

	/** Сброс высоты у .mcedit-container */
	$textarea.parent().parent().find('.mcedit-container').height('auto');
	
	$textarea.hide();
}

/** Создать redactor у указанной textarea */
mcedit.createRedactor = function ($textarea) {
	$textarea.redactor({
		
		/** Фикс resizable-ui: при создании вкладки с редактором удаляем атрибут style у .mcedit-container, если высота реактора выше */
		focus: true,
		focusCallback: function() {resetStyles(this)},
		clickCallback: function() {resetStyles(this)},
		keydownCallback: function() {resetStyles(this)}
	});
	
	function resetStyles (redactor) {
		if (redactor.$box.height() > redactor.$box.parent().height())
			redactor.$box.parent().removeAttr('style');
	}
	
}

/** Генератор вкладок из объекта */
mcedit.createTabs = function (arr) {

	/** Создаем контейнер для вкладок */
	var $tabs = $("<div>").addClass('mcedit-tabs');

	/** Генерируем вкладки tab */
	for (var obj in arr) {
		$("<div>").html(arr[obj]['name']).addClass('tab').addClass(arr[obj]['class']).appendTo($tabs);
	}

	return $tabs;

}

/************************************************************/
/************************************************************/
/************************************************************/

x.exe["option-mcedit"] = ["mcedit()"];