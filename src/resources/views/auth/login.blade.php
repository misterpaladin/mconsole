<!DOCTYPE html>
<!--[if IE 8]> 
<html lang="en" class="ie8 no-js">
<![endif]-->
<!--[if IE 9]> 
<html lang="en" class="ie9 no-js">
<![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<!-- BEGIN HEAD -->
	<head>
		<meta charset="utf-8" />
		<title>@yield('title', 'Mconsole')</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1" name="viewport" />
		<meta content="" name="description" />
		<meta content="" name="author" />
		<!-- BEGIN GLOBAL MANDATORY STYLES -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
		<link href="/massets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<link href="/massets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
		<link href="/massets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="/massets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
		<link href="/massets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
		<!-- END GLOBAL MANDATORY STYLES -->
		<!-- BEGIN PAGE LEVEL PLUGINS -->
		<link href="/massets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
		<link href="/massets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
		<!-- END PAGE LEVEL PLUGINS -->
		<!-- BEGIN THEME GLOBAL STYLES -->
		<link href="/massets/global/css/components-md.min.css" rel="stylesheet" id="style_components" type="text/css" />
		<link href="/massets/global/css/plugins-md.min.css" rel="stylesheet" type="text/css" />
		<!-- END THEME GLOBAL STYLES -->
		<!-- BEGIN PAGE LEVEL STYLES -->
		<link href="/massets/pages/css/login.min.css" rel="stylesheet" type="text/css" />
		<!-- END PAGE LEVEL STYLES -->
		<!-- BEGIN THEME LAYOUT STYLES -->
		<!-- END THEME LAYOUT STYLES -->
		<link rel="shortcut icon" href="favicon.ico" />
	</head>
	<!-- END HEAD -->
	<body class=" login">
		<!-- BEGIN LOGO -->
		<div class="logo">
			<a href="{{ mconsole_url() }}"></a>
		</div>
		<!-- END LOGO -->
		<!-- BEGIN LOGIN -->
		<div class="content">
			<!-- BEGIN LOGIN FORM -->
			{!! Form::open(['method' => 'POST', 'url' => '/mconsole/login', 'class' => 'login-form']) !!}
				<h3 class="form-title font-green">{{ trans('mconsole::login.headings.signin') }}</h3>
				
                @if (env('APP_DEMO'))
                    <div class="alert alert-warning">
                        <p>Email: <strong>demo@milax.com</strong></p>
                        <p>{{ trans('mconsole::login.inputs.password') }}: <strong>demo</strong></p>
                    </div>
                @endif
                
				@if ($errors->any())
					<div class="alert alert-danger">
						<button class="close" data-close="alert"></button>
						@if (count($errors->all()) == 1)
							{{ $errors->all()[0] }}
						@else
							<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
							</ul>
						@endif
					</div>
				@endif
                
                @if (Session::has('status'))
                    <div class="alert alert-success">
                        <p>{{ Session::get('status')}}</p>
                    </div>
                @endif
				
				<div class="alert alert-danger display-hide">
					<button class="close" data-close="alert"></button>
					<span> {{ trans('mconsole::login.errors.login_password_empty') }} </span>
				</div>
				<div class="form-group">
					<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
					<label class="control-label visible-ie8 visible-ie9">Email</label>
					<input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="login" value="{{ old('login') }}" /> 
				</div>
				<div class="form-group">
					<label class="control-label visible-ie8 visible-ie9">{{ trans('mconsole::login.inputs.password') }}</label>
					<input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="{{ trans('mconsole::login.inputs.password') }}" name="password" /> 
				</div>
				<div class="form-actions">
					{!! Form::submit(trans('mconsole::login.buttons.login'), ['class' => 'btn green uppercase col-xs-12']) !!}
                    <div class="checkbox-list col-xs-12">
					<label class="rememberme check checkbox-inline"><input type="checkbox" name="remember" value="1" />{{ trans('mconsole::login.inputs.remember') }}</label>
                    <a href="javascript:;" id="forget-password" class="forget-password">{{ trans('mconsole::login.links.forgot') }}</a>
                    </div>
					
				</div>
			</form>
			<!-- END LOGIN FORM -->
			<!-- BEGIN FORGOT PASSWORD FORM -->
			<form class="forget-form" action="/password/email" method="post">
                {!! csrf_field() !!}
				<h3 class="font-green">{{ trans('mconsole::login.headings.forgot') }}</h3>
				<p> {{ trans('mconsole::login.text.forgot_enter_email') }} </p>
                <div class="form-group">
					<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" /> 
				</div>
				<div class="form-actions">
					<button type="button" id="back-btn" class="btn btn-default">{{ trans('mconsole::login.buttons.back') }}</button>
					{!! Form::submit(trans('mconsole::login.buttons.restore'), ['class' => 'btn btn-success uppercase pull-right']) !!}
				</div>
			{!! Form::close() !!}
			<!-- END FORGOT PASSWORD FORM -->
		</div>
		<div class="copyright"> @datetime('Y') © <a href="http://www.milax.com/" target="_blank">Milax</a> </div>
		<!--[if lt IE 9]>
		<script src="/massets/global/plugins/respond.min.js"></script>
		<script src="/massets/global/plugins/excanvas.min.js"></script> 
		<![endif]-->
		<!-- BEGIN CORE PLUGINS -->
		<script src="/massets/global/plugins/jquery.min.js" type="text/javascript"></script>
		<script src="/massets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="/massets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
		<script src="/massets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
		<script src="/massets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
		<script src="/massets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
		<script src="/massets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
		<script src="/massets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
		<!-- END CORE PLUGINS -->
		<!-- BEGIN PAGE LEVEL PLUGINS -->
		<script src="/massets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
		<script src="/massets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
		<script src="/massets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
		<!-- END PAGE LEVEL PLUGINS -->
		<!-- BEGIN THEME GLOBAL SCRIPTS -->
		<script src="/massets/global/scripts/app.min.js" type="text/javascript"></script>
		<!-- END THEME GLOBAL SCRIPTS -->
		<!-- BEGIN PAGE LEVEL SCRIPTS -->
		<script src="/massets/pages/scripts/login.min.js" type="text/javascript"></script>
		<!-- END PAGE LEVEL SCRIPTS -->
		<!-- BEGIN THEME LAYOUT SCRIPTS -->
		<!-- END THEME LAYOUT SCRIPTS -->
	</body>
</html>