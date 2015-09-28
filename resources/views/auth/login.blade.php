<!DOCTYPE HTML>
<html>
<head>
<title>Mconsole</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/massets/css/base.css" rel="stylesheet" type="text/css" />
<link href="/massets/css/mconsole.css" rel="stylesheet" type="text/css" />
<link href="/massets/css/forms.css" rel="stylesheet" type="text/css" />
</head>

<body class="option-login">
	
	<div id="login-logo">Mconsole</div>

	<div id="signin">
		<form action="/mconsole/login" method="POST">
			{!! csrf_field() !!}
			<input class="logininp" name="login" placeholder="Эл. почта (логин)">
			<input class="logininp" name="password" type="password" placeholder="Пароль">
			<div class="login-button disabled">Войти</div>
		</form>
		<div class="uncorrect-info">Проверьте правильность введенного логина и пароля.</div>
	</div>

	<div id="accessdenied">Ваш браузер не поддерживается. Для корректной работы системы Mconsole требуется последняя версия одного из браузеров:
		<br><br><a href="http://www.opera.com/" target="_blank">Opera</a> (v.18 и выше)<br><a href="http://www.firefox.com/" target="_blank">Firefox</a> (v.20 и выше)<br><a href="https://www.google.com/intl/ru/chrome/browser/" target="_blank">Google Chrome</a> (v.25 и выше, <b>реком-ем</b>)
	</div>
	<script type="text/javascript" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
	<script type="text/javascript" src="/massets/js/jquery.browser.min.js"></script>
	<script type="text/javascript" src="/massets/js/jquery.transit.min.js"></script>
	<script type="text/javascript" src="/massets/js/jquery.vcenter.min.js"></script>
	<script type="text/javascript" src="/massets/js/base.min.js"></script>
	<script type="text/javascript" src="/massets/js/mconsole.js"></script>
</body>
</html>