<!DOCTYPE HTML>
<html>
<head>
	<title>@yield('title', 'Mconsole')</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- 	<meta property="image:removeUrl" content="{HOST}image/delete/" /> -->
	<link href="/massets/css/base.css?_=1" rel="stylesheet" type="text/css" />
	<link href="/massets/css/mconsole.css?_=1" rel="stylesheet" type="text/css" />
	<link href="/massets/css/forms.css?_=1" rel="stylesheet" type="text/css" />
	<link href="/massets/css/menueditor.css" rel="stylesheet" type="text/css" />
	<link href="/massets/css/pickmeup.css" rel="stylesheet" type="text/css" />
	<!-- <script type="text/javascript" src="http://code.jquery.com/jquery-2.0.3.min.js"></script> -->
	<script type="text/javascript" src="/massets/js/jquery-2.1.0.min.js"></script>
	
	<!-- maps edit -->
	<script type="text/javascript" src="http://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3&language=ru"></script>
    <script type="text/javascript" src="http://maps.api.2gis.ru/2.0/loader.js?pkg=basic" data-id="dgLoader"></script>
	<link href="/massets/css/mapi-admin.css" rel="stylesheet" type="text/css">
	<!-- maps edit -->

	<!-- mcedit -->
	<link href="/massets/css/jquery-ui.css" rel="stylesheet" type="text/css">
	<link href="/massets/css/mcedit/editor.css" rel="stylesheet" type="text/css" />
	<link href="/massets/css/mcedit/redactor.css" rel="stylesheet" type="text/css" />
	<link href="/massets/css/mcedit/codemirror.css" rel="stylesheet" type="text/css" />
	<link href="/massets/css/mcedit/neo.css" rel="stylesheet" type="text/css" />
	<!-- mcedit -->
</head>
<body class="option-mconsole option-ui option-menueditor option-mcedit">
	<div id="sidebar">
		<div class="logo">Mconsole</div>
		<div class="name">@yield('nav_title')</div>
		<div class="pref-button"></div>
	</div>
	<div id="pref-window">
		<div class="entry"><span class="capt">Проект</span>{{ Config::get('mconsole.name') }}</div>
		<div class="entry"><span class="capt">Профиль</span>{{ Auth::user()->email }}</div>
		<a class="change-pwd" href="/massets/admin/access/change_pass/">Сменить пароль</a>
		<a class="exit" href="/mconsole/logout">Выход</a>
		<div class="about">© Mconsole 3 | <a href="http://www.milax.com/" target="_blank">Студия Милакс</a></div>
	</div>

	<div id="menu">
		<div class="menu-child">
			@include('mconsole::partials.menu')
		</div>
	</div>

	<div id="content">
		@yield('content', '<h1>Root User, добро пожаловать в Mconsole!</h1>')
	</div>
	<script type="text/javascript" src="/massets/js/jquery.ui.min.js"></script>
	<script type="text/javascript" src="/massets/js/jquery.transit.min.js"></script>
	<script type="text/javascript" src="/massets/js/jquery.pickmeup.min.js"></script>
	<script type="text/javascript" src="/massets/js/jquery.nestable.js"></script>
	<script type="text/javascript" src="/massets/js/base.min.js"></script>
	<script type="text/javascript" src="/massets/js/zeroclipboard/jquery.zclip.min.js"></script>
	<script type="text/javascript" src="/massets/js/mconsole.js"></script>
	<script type="text/javascript" src="/massets/js/jqmodalwin-1.2.js"></script>
	<script type="text/javascript" src="/massets/js/ui.js"></script>
	<script type="text/javascript" src="/massets/js/menueditor.js"></script>
	<script type="text/javascript" src="/massets/js/obj.DOM.js"></script>
	
	<!-- mcedit -->
	<script type="text/javascript" src="/massets/js/mcedit/assets/redactor.js"></script>
	<script type="text/javascript" src="/massets/js/mcedit/mcedit.js"></script>
	<script type="text/javascript" src="/massets/js/mcedit/codemirror.js"></script>
	<script type="text/javascript" src="/massets/js/mcedit/mode/javascript/javascript.js"></script>
	<script type="text/javascript" src="/massets/js/mcedit/mode/css/css.js"></script>
	<script type="text/javascript" src="/massets/js/mcedit/addon/edit/matchbrackets.js"></script>
	<script type="text/javascript" src="/massets/js/mcedit/mode/htmlmixed/htmlmixed.js"></script>
	<script type="text/javascript" src="/massets/js/mcedit/mode/xml/xml.js"></script>
	<script type="text/javascript" src="/massets/js/mcedit/mode/clike/clike.js"></script>
	<script type="text/javascript" src="/massets/js/mcedit/mode/php/php.js"></script>
	<script type="text/javascript" src="/massets/js/mcedit/lib/formatting.js"></script>
	<!-- mcedit -->
	
	<!-- maps edit -->
	<script type="text/javascript" src="/massets/js/mapi-admin.js"></script>
	<!-- maps edit -->
	<script>
		/**
		 * FIX: Открывает меню активной страницы.
		 * (В случае, когда из-за списка суб.параметров, не распознается активный пункт)
		 **/
		$(document).ready(function(){
			var Pairs	= "{{Request::path()}}".split( "/" );
			for ( var i = 0; i < Pairs.length; i++ ){
				var href	= (href||'') + '/' + Pairs[i];
				var Item	= $( "a.menu-item[href='"+href+"']" );
				if ( Item.length > 0 )
					if ( !Item.hasClass( "active" ) ) {
						Item.trigger( "click" ).addClass("active");
						Item.parents('.menu-child').find('a.menu-item-with-bundle').trigger( "click" ).addClass("active");
					}
			}
			$('form').on("keyup keypress", function(e) {
			  var code = e.keyCode || e.which; 
			  if (code  == 13) {               
				e.preventDefault();
				return false;
			  }
			});
		});
	</script>
</body>
</html>