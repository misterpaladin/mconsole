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
		<title>{{ (isset($pageTitle)) ? $pageTitle : 'Mconsole' }}</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1" name="viewport" />
		<!-- BEGIN GLOBAL MANDATORY STYLES -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
		<link href="/massets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<link href="/massets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
		<link href="/massets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="/massets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
		<link href="/massets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
		<link href="/massets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="/massets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <link href="/massets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="/massets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
		<!-- END GLOBAL MANDATORY STYLES -->
		<!-- BEGIN THEME GLOBAL STYLES -->
		<link href="/massets/global/css/components-md.min.css" rel="stylesheet" id="style_components" type="text/css" />
		<link href="/massets/global/css/plugins-md.min.css" rel="stylesheet" type="text/css" />
		<!-- END THEME GLOBAL STYLES -->
		<!-- BEGIN PAGE LEVEL PLUGINS -->
		<link href="/massets/css/links-editor.css" rel="stylesheet" type="text/css">
		<link href="/massets/global/plugins/jquery-ui-1.11.4.custom/jquery-ui.min.css" rel="stylesheet">
		<!-- END PAGE LEVEL PLUGINS -->
		<!-- BEGIN THEME LAYOUT STYLES -->
		<link href="/massets/layouts/layout3/css/layout.min.css" rel="stylesheet" type="text/css" />
		<link href="/massets/layouts/layout3/css/themes/default.min.css" rel="stylesheet" type="text/css" id="style_color" />
		<!-- END THEME LAYOUT STYLES -->
		<link rel="shortcut icon" href="favicon.ico" />
	</head>
	<!-- END HEAD -->
	<body class="page-container-bg-solid page-boxed page-md">
		<!-- BEGIN HEADER -->
		<div class="page-header">
			<!-- BEGIN HEADER TOP -->
			<div class="page-header-top">
				<div class="container">
					<!-- BEGIN LOGO -->
					<div class="page-logo">
						
					</div>
					<!-- END LOGO -->
					<!-- BEGIN RESPONSIVE MENU TOGGLER -->
					<a href="javascript:;" class="menu-toggler"></a>
					<!-- END RESPONSIVE MENU TOGGLER -->
					<!-- BEGIN TOP NAVIGATION MENU -->
					<div class="top-menu">
						<ul class="nav navbar-nav pull-right">
							<!-- BEGIN USER LOGIN DROPDOWN -->
							<li class="dropdown dropdown-user dropdown-dark">
								<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
								<img alt="" class="img-circle" src="{{ Gravatar::get(Auth::user()->email, 40) }}">
								<span class="username username-hide-mobile">{{ Auth::user()->name }}</span>
								</a>
								<ul class="dropdown-menu dropdown-menu-default">
									<li>
										<a href="#">
										<i class="icon-settings"></i> {{ trans('mconsole::profile.links.settings') }} </a>
									</li>
									<li class="divider"> </li>
									<li>
										<a href="/mconsole/logout">
										<i class="icon-key"></i> {{ trans('mconsole::profile.links.logout') }} </a>
									</li>
								</ul>
							</li>
							<!-- END USER LOGIN DROPDOWN -->
						</ul>
					</div>
					<!-- END TOP NAVIGATION MENU -->
				</div>
			</div>
			<!-- END HEADER TOP -->
			<!-- BEGIN HEADER MENU -->
			<div class="page-header-menu">
				<div class="container">
					@include('mconsole::partials.menu')
				</div>
			</div>
			<!-- END HEADER MENU -->
		</div>
		<!-- END HEADER -->
		<!-- BEGIN CONTAINER -->
		<div class="page-container">
			<!-- BEGIN CONTENT -->
			<div class="page-content-wrapper">
				<!-- BEGIN CONTENT BODY -->
				<!-- BEGIN PAGE HEAD-->
				<div class="page-head">
					<div class="container">
						<!-- BEGIN PAGE TITLE -->
						<div class="page-title">
							<h1>{{ (isset($pageCaption)) ? $pageCaption : trans('mconsole::mconsole.text.welcome') }}
								<small>{{ (isset($pageSubcaption)) ? $pageSubcaption : trans('mconsole::mconsole.text.version', ['version' => version]) }}</small>
							</h1>
						</div>
						<!-- END PAGE TITLE -->
					</div>
				</div>
				<!-- END PAGE HEAD-->
				<!-- BEGIN PAGE CONTENT BODY -->
				<div class="page-content">
					<div class="container">
						<!-- BEGIN PAGE CONTENT INNER -->
						<div class="page-content-inner">
							
							@include('mconsole::partials.messages')
							
							@if (isset($filterable))
							<div class="portlet light">
								<div class="portlet-title">
									<div class="caption">
										<i class="icon-magnifier font-grey-gallery"></i>
										<span class="caption-subject bold font-grey-gallery uppercase">{{ trans('mconsole::traits.filterable.filter') }}</span>
									</div>
									<div class="tools">
										<a href="" class="{{ ($filtered) ? 'collapse' : 'expand' }}"> </a>
									</div>
								</div>
								<div class="portlet-body {{ ($filtered) ? null : 'portlet-collapsed' }}">
									@include('mconsole::traits.filterable')
								</div>
							</div>
							@endif
							
							@yield('content', trans('mconsole::mconsole.text.welcome'))
							
							@if (isset($paging))
							<div class="row">
								<div class="col-xs-12 text-center">
									{!! $paging->appends(Request::query())->links() !!}
								</div>
							</div>
							@endif
							
						</div>
						<!-- END PAGE CONTENT INNER -->
					</div>
				</div>
				<!-- END PAGE CONTENT BODY -->
				<!-- END CONTENT BODY -->
			</div>
			<!-- END CONTENT -->
		</div>
		<!-- END CONTAINER -->
		<!-- BEGIN FOOTER -->
		<!-- BEGIN INNER FOOTER -->
		<div class="page-footer">
			<div class="container"> @datetime('Y') &copy; <a href="http://www.milax.com/" target="_blank">Milax</a></div>
		</div>
		<div class="scroll-to-top">
			<i class="icon-arrow-up"></i>
		</div>
		<!-- END INNER FOOTER -->
		<!-- END FOOTER -->
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
		<script src="/massets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="/massets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
        <script src="/massets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <script src="/massets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
        <script src="/massets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
		<script src="/massets/global/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
		<script src="/massets/global/plugins/ckeditor/config.js" type="text/javascript"></script>
		<!-- END CORE PLUGINS -->
		<!-- BEGIN PAGE LEVEL PLUGINS -->
		<script src="/massets/global/plugins/jquery-ui-1.11.4.custom/jquery-ui.min.js" type="text/javascript"></script>
		<!-- END PAGE LEVEL PLUGINS -->
		<!-- BEGIN THEME GLOBAL SCRIPTS -->
		<script src="/massets/global/scripts/app.min.js" type="text/javascript"></script>
		<!-- END THEME GLOBAL SCRIPTS -->
		<!-- BEGIN PAGE LEVEL SCRIPTS -->
		<script src="/massets/js/date-pickers.js" type="text/javascript"></script>
		<script src="/massets/js/links-editor.js" type="text/javascript"></script>
		<!-- END PAGE LEVEL SCRIPTS -->
		<!-- BEGIN THEME LAYOUT SCRIPTS -->
		<script src="/massets/layouts/layout3/scripts/layout.min.js" type="text/javascript"></script>
		<script src="/massets/layouts/layout3/scripts/demo.min.js" type="text/javascript"></script>
		<script src="/massets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
		<!-- END THEME LAYOUT SCRIPTS -->
	</body>
</html>
