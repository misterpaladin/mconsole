/************************************************************/
/************************************************************/
/************************************************************/
/** Инициализация спец. блока в fieldset */
var specfbox	= function () {
	var $specfbox	= $(".spec-functions-box-items");
	/** Запускаем обработчик количества элементов на странице */
	$specfbox.find("span.counter").each(specfbox.counter);
};

/** Обработчик преключателя количества элементов на странице */
specfbox.counter	= function () {
	var $select		= $(this).find("select"),
		$number		= $(this).find("span.number");
	/** Значение при инициализации */
	specfbox.counter.get($select, $number);
	/** Инициализация события */
	$select.on("change", function () {
		specfbox.counter.get($select, $number);
	});
};

/** Берем значение (для метода-переключателя) */
specfbox.counter.get	= function ($from, $to) {
	$to.html($from.val());
};


/** Метод инициализирует события на кнопках-субмитах */
var bsubmit	= function () {
	$document.on("click.submit", ".button.submit", function () {
		$(this).parents("form").submit();
	});
};

/** Изменени страницы ч/з инпут или prev|next. */
function set_range (newpage) {
	var	location	= decodeURIComponent( window.location.search.substr(1) ),
		pre			= location.split("&"),
		param		= [],
		params		= [],
		exist		= false;
	
	/** Обходим масив данных get */
	for (var key in pre) {
		param = pre[key].split("=");
		/** Если найден page — заменяем */
		if (param[0] == "page") {
			param[1] = newpage;
			exist = true;
		}
		params.push({ "name" : param[0], "value" : param[1] });
	}
	/** Добавляем page, если его небыло в get */
	if (!exist) { params.push({ "name" : "page", "value" : newpage }); }
	
	/** Переходим по измененному урлу */
	window.location = window.location.pathname + "?" + $.param(params);
	
	return false;
}

/** Изменени страницы ч/з инпут */
var choosepage = function () {
	$document.on("submit", ".choose-page", function () {
		var newpage		= $(this).find(".field-pagenow").val(),
			location	= window.location.search.substr(1),
			pre			= location.split("&"),
			param		= [],
			params		= [],
			exist		= false;
		
		/** Обходим масив данных get */
		for (var key in pre) {
			param	= pre[key].split("=");
			/** Если найден page — заменяем */
			if (param[0] == "page") {
				param[1]	= newpage;
				exist		= true;
			}
			params.push({ "name" : param[0], "value" : param[1] });
		}
		/** Добавляем page, если его небыло в get */
		if (!exist) { params.push({ "name" : "page", "value" : newpage }); }
		/** Переходим по измененному урлу */
		window.location = window.location.pathname + "?" + $.param(params);
		return false;
	});
};


/************************************************************/
/************************* + IMAGES *************************/
/************************************************************/


/** Метод инициализации блоков с картинками при загрузке страницы. */
var imgui	= function () {
	imgui.removeUrl	= $("meta[property='image:removeUrl']").attr("content");
	imgui.$els		= $(".image-box");
	imgui.$els.each(imgui.buildbox);
	if ( !imgui.set ) {
		imgui.set	= true;
		imgui.setEvent();
	}
};

imgui.set	= false;
imgui.tmpl	= {
	"remove" 				: "<div class='image-item-remove'/>",
	"sort" 					: "<div class='image-item-sort'/>",
	"size" 					: "<span class='image-item-size'/>",
	"picture"				: "<img class='image-item-picture' />",
	"link"					: "<a class='image-item-link' target='_blank'></a>"
};

imgui.setEvent	= function () {
	$document.on("click", ".image-item-remove", function () {
		var $parent	= $(this).parents(".image-item"),
			id		= $parent.data("id");
		imgui.remove( $parent, id );
	});
};

imgui.remove	= function ($element, id) {
	var removeURI	= $(imgui.$els).data("remove"),
		removeURI	= (typeof(removeURI) != "string" ) ? imgui.removeUrl : removeURI;
	if ( confirm("Вы хотите удалить?") == true ) {
	  	$.ajax({
	  		url		: removeURI + id,
	  		success	: function ( data ) {
				if (id == data.id) $element.remove();
	  		}
	  	});
	} else return false;
};

imgui.buildbox	= function () {
	var params				= {},
	$els					= $(".image-item", this);
	params["short"]			= ( $(this).hasClass("image-box-option-short") ) ? true : false;
	params["remove"]		= ( $(this).hasClass("image-box-option-remove") ) ? true : false;
	params["sort"]			= ( $(this).hasClass("image-box-option-sort") ) ? true : false;

	$els.each(function () {
		var $part;
		/** Изображение */
		$part	= $( imgui.tmpl["picture"] ).attr( "src", $(this).data("src") );
		$(this).append( $part );
		/** Ссылка */
		if ( typeof $(this).data("href") !== "undefined" ) {
			$part	= $( imgui.tmpl["link"] ).attr( "href", $(this).data("href") );
			$(this).append( $part );
		}
		/** Размер */
		if ( $(this).data("size") ) {
			$part	= $( imgui.tmpl["size"] ).text( $(this).data("size") );
			$(this).append( $part );
		}
		/** Remove */
		if ( params["remove"] ) {
			$part	= $( imgui.tmpl["remove"] )
			$(this).append( $part );
		}
		/** Sort */
		if ( params["sort"] ) {
			$part	= $( imgui.tmpl["sort"] )
			$(this).append( $part );
		}
	});
	
	/** Sortable */
	if ( params["sort"] ) {
		$( this ).sortable({
			handle	: ".image-item-sort"
	    });
	}
};
/************************************************************/
/*********************** - IMAGES ***************************/
/************************************************************/


/************************************************************/
/*********************** + DATEPICKER ***********************/
/************************************************************/

var datepicker = function () {
	
	$(".datepicker").pickmeup();

};

/************************************************************/
/*********************** - DATEPICKER ***********************/
/************************************************************/


/************************************************************/
/*********************** + COPYBUTTON ***********************/
/************************************************************/

var copybutton = function () {

	var $buttons 			= $(".field-copy");

	$buttons.each(function () {

		$(this).zclip({
			path 			: '/mconsole/js/zeroclipboard/zclip.swf',
			copy 			: copybutton.copyButton,
			afterCopy 		: function () { return false; }
		});

	});

};

copybutton.copyButton = function () {

	if ( $(this).attr("text-to-copy") )
		var content = $(this).attr("text-to-copy");

	if ( $(this).attr("name-to-copy") )
		var content = $( "[name=" + $(this).attr("name-to-copy") + "]" ).val();

	if ( typeof content == "undefined" )
		var content = $(this).text();

	return content;

};

/************************************************************/
/*********************** - COPYBUTTON ***********************/
/************************************************************/


/************************************************************/
/*********************** + FIELDSET *************************/
/************************************************************/

var fieldset = function () {

	/* Открытым блокам с возможностью скрытия присваиваем show, если нет */

	$("fieldset.openable:not(.hide)").each(function () {
		if ( !$(this).hasClass("show") ) $(this).addClass("show");
	});

	/* Events */

	$document.on("click", "fieldset.openable.hide, fieldset.openable:not(.hide) legend", fieldset.openable);

};

fieldset.openable = function () {

	var visible = ( $(this).hasClass( "hide" ) ) ? false : true;

	var $fieldset = ( visible ) ? $(this).parent() : $(this);

	if ( visible )
		$fieldset
			.addClass( "hide" )
			.removeClass( "show" );
	else
		$fieldset
			.removeClass( "hide" )
			.addClass( "show" );

};

/************************************************************/
/*********************** - FIELDSET *************************/
/************************************************************/


/************************************************************/
/*********************** + SUPPORT **************************/
/************************************************************/

var support = function () {

	$(".field-box .field-support").each( support.buildMarker );

	/* Events */

	$document.on("click", ".field-box.has-support .field-name", support.visibleToggle);

};

support.buildMarker = function () {

	var $fieldBox 	= $( this ).parent();

	if ( !$fieldBox.hasClass("has-support") ) $fieldBox.addClass("has-support");

	/* Находим template-key, если он есть */

	var $field 		= $( "input.field-text, textarea.field-textarea, select.field-select, textarea.field-htmlarea", $fieldBox );
	var templateKey = $field.eq(0).attr("template-key");

	if ( templateKey )
		$("<div class='template-key'>Ключ шаблона: " + templateKey + "</div>")
			.prependTo( $( this ) );

};

support.visibleToggle = function () {

	var $fieldBox = $( this ).parent();
	var $fieldSupport = $(".field-support", $fieldBox);

	$fieldSupport.toggle();

};

/************************************************************/
/*********************** - SUPPORT **************************/
/************************************************************/


/************************************************************/
/*********************** + LIST *****************************/
/************************************************************/

var list = function () {
	list.$list = $(".list-table");

	/* Events */
	list.$list.on("click", ".list-remove", list.remove);
};

list.remove = function () {
	if ( confirm("Вы хотите удалить?") == true )
	  	window.location	= $(this).attr( "href" );
	else
		return false;
		
	return false;
};

/************************************************************/
/*********************** - LIST *****************************/
/************************************************************/


/************************************************************/
/*********************** + CHOOSE OPTIONS BOX ***************/
/************************************************************/



/* Code ex.:
$("input").eq(0).each(function () {

	chooseOptions($(this), [
		{ "name" : "Первый пункт", "value" : "firstitem" },
		{ "name" : "Второй пункт", "value" : "seconditem" }
	], function ( value ) {
		console.info( value );
	}, "right");

});*/

var chooseOptions = function ( $element, options, callback, snap, attachWidth ) {

	chooseOptions.removeOld();

	snap = snap || chooseOptions.snap;

	var $menu = $( chooseOptions.tmpl["box"] );
	var $option;
	var offset = $element.offset();

	for (var key in options) {
		$option = $( chooseOptions.tmpl["option"] );
		$option
			.text( options[key].name )
			.data( "value", options[key].value )
			.data( "element", $element )
			.appendTo( $menu );
	}

	$menu
		.data( "callback", callback )
		.prependTo( $body );

	var elHeight = $element.outerHeight();
	var elWidth = $element.outerWidth();
	var menuWidth = $menu.outerWidth();

	var top = offset.top + elHeight + 2;
	var left = (snap == "left") ? offset.left : (offset.left + elWidth - menuWidth);

	$menu.css({
		"top"		: top,
		"left"		: left,
	});

	/* Задаем ширину меню в случае, если задано значение */
	if (attachWidth) $menu.css({
		"width" 	: attachWidth
	});

	$menu.each( chooseOptions.closeEvent );

};

chooseOptions.choose = function () {

	var $box = $(this).parent();
	var callback = $box.data("callback");
	var value = $(this).data("value");
	var $element = $(this).data("element");

	$box.remove();

	callback.call( $element, value );

};

chooseOptions.snap = "left";
chooseOptions.tmpl = {
	"box"				: "<div class='choose-options-container'></div>",
	"option"			: "<div class='choose-options-item'></div>"
};

chooseOptions.setEvents = function () {

	$document.on("click", ".choose-options-item", chooseOptions.choose);

	$document.on("click", function () {
		$(".choose-options-container").each(function () {
			if ( !$(this).hasClass("hover") && (chooseOptions.closeTimer) ) $(this).remove();
			return false;
		});
	});

};

chooseOptions.removeOld = function () {
	$(".choose-options-container").remove();
};

chooseOptions.closeEvent = function () {

	$(this).hover(function () {
		$(this).addClass("hover");
	}, function () {
		$(this).removeClass("hover");
	});

	chooseOptions.closeTimer = false;

	setTimeout(function () {
		chooseOptions.closeTimer = true;
	}, 1);

};

/************************************************************/
/*********************** - CHOOSE OPTIONS BOX ***************/
/************************************************************/


/************************************************************/
/*********************** + FIELD OPTIONS ********************/
/************************************************************/

var foptions = function () {

	for (var key in foptions.options) {
		if (typeof find == "undefined") var find = "";
			else find += ", ";

		find += ".field-box .field-text[" + key + "]";
	}

	var $elements = $(find);

	$elements.after( $( foptions.tmplButton ) );

	/* Events */

	$document.on("click", ".field-box .more-options", foptions.showOptions);

};

foptions.tmplButton = "<div class='more-options'></div>";

foptions.options = {
	"copy-from"			: {
		"name"				: "Копия из: ",
		"doing"				: function () {
			
			var $input		= $(this);
			var $form 		= $input.parents("form");
			var name 		= $input.attr("copy-from");
			var $source		= $("[name='" + name + "']", $form);

			$input.val( $source.val() );

		}
	},
	"translit-from"		: {
		"name"				: "Транслит из: ",
		"doing"				: function () {
			
			var $input		= $(this);
			var $form 		= $input.parents("form");
			var name 		= $input.attr("translit-from");
			var $source		= $("[name='" + name + "']", $form);

			$input.val( translit( $source.val() ) );

		}
	}
};

foptions.showOptions = function () {

	var $box = $(this).parent();
	var $input = $(".field-text", $box).eq(0);

	var attr;
	var data = [];
	
	for (var key in foptions.options) {
		attr = $input.attr( key );
		if ( attr ) 
			data.push({
				"name" : foptions.options[key].name + attr,
				"value" : key
			});
	}

	chooseOptions($(this), data, foptions.choose, "right");

};

foptions.choose = function (value) {

	$input = $(this).prev();

	foptions.options[value].doing.call( $input );

};

/************************************************************/
/*********************** - FIELD OPTIONS ********************/
/************************************************************/


/************************************************************/
/*********************** + PREREADY OPTION ******************/
/************************************************************/

var preready = function () {
	var $elements = $(".field-box .field-text[preready-value]");

	/* FIX: Функционал выпадающего списка создается только для тех полей, где в `preready-value` есть текст. */
	$elements.each(function(){
		if ( $(this).attr( "preready-value" ).length > 0 )
			$(this).after( $( preready.tmplButton ) );
	});

	/* Events */
	$document.on("click", ".field-box .preready-option", preready.showOptions);

};

preready.tmplButton = "<div class='preready-option'></div>";

preready.showOptions = function () {

	var $box 		= $(this).parent();
	var $input	 	= $(".field-text", $box).eq(0);

	var attr 		= $input.attr( "preready-value" );
	
	if ( attr.length < 1 ) return;
	
	var attrList	= attr.split(';');
	var value 		= [];
	
	for (var key in attrList) {
		/* FIX: Предотвращает создание пустых элементов. */
		if ( attrList[key].toString().length > 0 )
			value.push({
				"name" : attrList[key].toString().replace( "\x01", ";", "g" ),
				"value" : attrList[key].toString().replace( "\x01", ";", "g" )
			});
	}

	chooseOptions($input, value, preready.choose, "left", $input.innerWidth());

};

preready.choose = function (value) {

	$input = $(this);

	$input.val( value );

};

/************************************************************/
/*********************** - PREREADY OPTION ********************/
/************************************************************/



/************************************************************/
/*********************** + BATTLE TRAY **********************/
/************************************************************/

var bottletray = function () {

	$all = $(".bottletray");

	$all.each( bottletray.onStart );

	/* Events */

	$document.on("click", ".bottletray-item-remove", bottletray.remove);

	$document.on("click", ".bottletray-plus", bottletray.add);

};

bottletray.tmpl = {
	"plus"				: "<div class='bottletray-plus'></div>",
	"remove"			: "<div class='bottletray-item-remove'></div>",
	"sort"				: "<div class='bottletray-item-sort'></div>",
	"item"				: "<div class='bottletray-item'></div>"
};

bottletray.onStart = function () {

	$(this).append( bottletray.tmpl["plus"] );

	$(".bottletray-template, .bottletray-item", $(this))
		.append( bottletray.tmpl["remove"] )
		.append( bottletray.tmpl["sort"] );

	$(".bottletray-list", $(this))
		.sortable({ 
			handle	: ".bottletray-item-sort",
			axis	: "y"
		});

};

bottletray.remove = function () {

	if ( confirm("Вы хотите удалить?") == true ) {
	  	$(this)
	  		.parents(".bottletray-item")
	  		.remove();
	} else return false;

};

bottletray.add = function () {

	$parent = $(this).parents(".bottletray");
	$template = $(".bottletray-template", $parent);
	$list = $(".bottletray-list", $parent);

	$item = $( bottletray.tmpl["item"] );

	$item
		.html( $template.html() )
		.appendTo( $list );

};

/************************************************************/
/*********************** - BATTLE TRAY **********************/
/************************************************************/


x.exe["option-ui"] = ["bsubmit()", "specfbox()", "choosepage()", "imgui()", "datepicker()", "copybutton()", "fieldset()", "support()", "foptions()", "chooseOptions.setEvents()", "bottletray()", "list()", "preready()"];