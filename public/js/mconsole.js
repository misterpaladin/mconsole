/************************************************************
*************************************************************
************************************************************/

/** 
 * Транслит.
 */
var translit = function ( string ) {

	var text = $.trim( string.toLowerCase() );

	var space = "-";

	var result = '';
	var curent_sim = '';

	for(i=0; i < text.length; i++) {
		/* Если символ найден в массиве то меняем его */
		if(translit.chars[text[i]] != undefined) {
			if(curent_sim != translit.chars[text[i]] || curent_sim != space) {
				result += translit.chars[text[i]];
				curent_sim = translit.chars[text[i]];
			}                                                                             
		}
		/* Если нет, то оставляем так как есть */
		else {
			result += text[i];
			curent_sim = text[i];
		}                              
	}          

	return result;

};

translit.chars = {
  'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'e', 'ж': 'zh', 'з': 'z', 'и': 'i', 'й': 'y', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'kh', 'ц': 'ts', 'Ч': 'Ch', 'ч': 'ch', 'ш': 'sh', 'щ': 'sch', 'ь': '', 'ы': 'y', 'ъ': '', 'э': 'e', 'ю': 'yu', 'я': 'ya', ' ': '-', '-': '-', '_': '-', '`': '', '~': '', '!': '', '@': '', '#': '', '$': '', '%': '', '^': '', '&': '', '*': '', '(': '', ')': '', '\=': '', '+': '', '[': '', ']': '', '\\': '', '|': '', '/': '','.': '', ',': '', '{': '', '}': '', '\'': '', '"': '', ';': '', ':': '', '?': '', '<': '', '>': '', '№':''
};


/************************************************************
*************************************************************
************************************************************/


/************************************************************
*************************************************************
************************************************************/

/** 
 * Управление префами.
 */
var pref = function () {
	pref.$button = $("#sidebar .pref-button");
	pref.$window = $("#pref-window");

	pref.setShow();

	pref.$window.on("mouseenter", function () {
		$(this).addClass("hovered");
	}).on("mouseleave", function () {
		$(this).removeClass("hovered");
	});
};

pref.setShow = function () {
	pref.$button.on("click.prefShow", function () {
		pref.$button.off("click.prefShow");
		var height = pref.$window.outerHeight();
		$(this).addClass("active");
		
		pref.$window.show().css({top : (-1) * height}).animate({top:44}, pref.setHide);
	});
};

pref.setHide = function () {
	$document.on("click.prefHide", function () {
		if (!pref.$window.hasClass("hovered")) pref.hide(pref.setShow);
	});
};

pref.hide = function (callback) {
	$document.off("click.prefHide");
	pref.$button.removeClass("active");
	var height = pref.$window.outerHeight();
	pref.$window.animate({top: (-1) * height}, callback);
};


/************************************************************
*************************************************************
************************************************************/

/**
 * Работа с меню.
 */
var menu = function () {
	
	menu.$items = $(".menu-item");

	/** Помечаем выпадающие пункты отдельным классом + ивентами */
	menu.$items.each(function () {

		var $next = $(this).next();

		if ($next.hasClass("menu-bundle")) {
			$(this).addClass("menu-item-with-bundle");
			$(this).on("click", function () {
				if (!$(this).hasClass("active")) 
					menu.showBundle($(this));
				else
					menu.hideBundle($(this));
				return false;
			});
		}
		
		if ($next.find(".active").length) {
			$(this).addClass("active");
			$next.show();
		}

	});

};

menu.showBundle = function ($item) {
	
	var opennew = function () {
		var $next = $item.next();
		$item.addClass("active");
		$next.stop().slideDown(150);
	}

	var $opened = menu.$items.filter(".menu-item-with-bundle.active");

	if ($opened.length)
		menu.hideBundle($opened, opennew);
	else 
		opennew();


};

menu.hideBundle = function ($item, callback) {
	callback = callback || function () {};
	var $next = $item.next();
	$item.removeClass("active");
	$next.stop().slideUp(150, callback);
};

/************************************************************
*************************************************************
************************************************************/

/**
 * Страница авторизации и все, что с ней связано.
 */
var login = function () {

	login.$signin = $("#signin");
	login.$accessdenied = $("#accessdenied");

	/** Позиционирование окошек */
	login.$signin.add(login.$accessdenied).verticalCenter({onResize : true});
	
	/** Показываем нужное окошко */
	if (login.support()) {
		login.$signin.show();
		login.set();
	} else
		login.$accessdenied.show();

};

/**
 * Инициализация формы авторизации.
 */
login.set = function () {
	
	login.$form = $("#signin form");
	login.$uncorrectNotice = $("#signin .uncorrect-info");
	login.$inputs = $("input[name=login], input[name=password]");
	login.$button = $(".login-button");

	var timeout = 0;
	
	/** Валидация формы */
	login.$inputs.on("keyup paste", function () {
		
		/** Таймаут требуется для работы onPaste */
		clearTimeout(timeout);
		timeout = setTimeout(function () {

			var result = true;
			login.$inputs.each(function () {
				if (!$(this).val()) result = false;
			});

			if (result)
				login.$button.removeClass("disabled");
			else
				login.$button.addClass("disabled");

		}, 30);

	});
	
	/** Обрабатываем клик только от активной кнопки */
	$document.on("click", ".login-button:not(.disabled)", login.request);

};

/**
 * Проверяется логин и пароль. 
 * Если верно — перезагружаем страницу.
 * Если не верно — выводим сообщение.
 */
login.request = function () {
	
	$.ajax({
		url				: login.$form.attr("action"),
		data			: login.$form.serialize(),
		type			: "post",
		dataType		: "json",
		success			: function (data) {
			if ( typeof data == "object" && typeof data["status"] == "string" && data["status"] == "ok" )
				window.location = data.location;
			else {
				var text = ( typeof data["message"] == "string" )
							? data["message"] : "Проверьте правильность введенного логина и пароля";
				login.$uncorrectNotice.html( text );
				login.unsuccess();
			}
		}
	});

}
/**
 * Авторизация не успешна. Выводим сообщение.
 */
login.unsuccess = function () {
	login.$uncorrectNotice.fadeIn(160);
	setTimeout(function () {
		login.$uncorrectNotice.fadeOut(160);
	}, 4000);
}

/**
 * Метод сообщает поддерживается ли данный браузер.
 * @return boolean true/false
 */
login.support = function () {
	
	/** Определяем точную версию */
	var versionCut = function (v) {
		v = v + "";
		v = v.substr(0, v.indexOf("."));
		return (v*1);
	};
	
	/** Значения по-умолчанию */
	login.support.browser = "undefined";
	login.support.version = "undefined";
	login.support.access = false;
	
	/** Разрешенные версии браузеров */
	var support = [
		{name : "webkit",	min : 25},
		{name : "mozilla",	min : 20},
		{name : "msie",		min : 10}
	];

	/** Алгоритм определения доступа и версий */
	for (var key in support) {
		if ($.browser[support[key]["name"]]) {
			login.support.browser = support[key]["name"];
			login.support.version = versionCut($.browser.version);
			if (login.support.version >= support[key]["min"]) login.support.access = true;
		}
	}

	return login.support.access;

};

/************************************************************
*************************************************************
************************************************************/

x.exe["option-default"] = [];
x.exe["option-login"] = ["login()"];
x.exe["option-mconsole"] = ["pref()", "menu()"];