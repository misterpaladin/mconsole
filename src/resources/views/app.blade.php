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
        <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700&subset=all' rel='stylesheet' type='text/css'>
		<link href="/massets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<link href="/massets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
		<link href="/massets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="/massets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
		<link href="/massets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="/massets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <link href="/massets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="/massets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
		<!-- END GLOBAL MANDATORY STYLES -->
		<!-- BEGIN THEME GLOBAL STYLES -->
        <link href="/massets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" />
		<link href="/massets/global/css/components-md.min.css" rel="stylesheet" id="style_components" type="text/css" />
		<link href="/massets/global/css/plugins-md.min.css" rel="stylesheet" type="text/css" />
        <link href="/massets/global/plugins/jstree/dist/themes/default/style.min.css" rel="stylesheet" type="text/css" />
		<!-- END THEME GLOBAL STYLES -->
		<!-- BEGIN PAGE LEVEL PLUGINS -->
		<link href="/massets/css/sortable.css" rel="stylesheet" type="text/css">
		<link href="/massets/global/plugins/jquery-ui-1.11.4.custom/jquery-ui.min.css" rel="stylesheet">
        <link href="/massets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css">
        <link href="/massets/global/plugins/jquery-file-upload/blueimp-gallery/blueimp-gallery.min.css" rel="stylesheet" type="text/css" />
        <link href="/massets/global/plugins/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet" type="text/css" />
        <link href="/massets/global/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet" type="text/css" />
		<!-- END PAGE LEVEL PLUGINS -->
		<!-- BEGIN THEME LAYOUT STYLES -->
		<link href="/massets/layouts/layout3/css/layout.min.css" rel="stylesheet" type="text/css" />
		<link href="/massets/layouts/layout3/css/themes/default.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="/massets/css/mconsole.css" rel="stylesheet" type="text/css" />
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
                            <li class="dropdown dropdown-extended dropdown-notification dropdown-dark">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <i class="icon-plus"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="external">
                                        <h3>Быстрое меню</h3>
                                    </li>
                                    <li>
                                        <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                            @forelse (app('API')->quickmenu->get() as $qmItem)
                                                <li>
                                                    <a href="{{ $qmItem->link }}">
                                                        <span class="details">
                                                            @if ($qmItem->icon)
                                                            <span class="label label-sm label-icon {{ isset($qmItem->color) ? $qmItem->color : null }}"><i class="{{ $qmItem->icon }}"></i></span>
                                                            @endif
                                                            {{ $qmItem->text }} </span>
                                                    </a>
                                                </li>
                                            @empty
                                                <li><a href="javascript:;"><span class="details">Нет элементов меню</span></a></li>
                                            @endforelse
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <!-- BEGIN NOTIFICATION DROPDOWN -->
                            <li class="dropdown dropdown-extended dropdown-notification dropdown-dark" id="header_notification_bar">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <i class="icon-bell"></i>
                                    <span class="badge badge-default notifications-count"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="external">
                                        <h3>Уведомления</h3>
                                    </li>
                                    <li>
                                        <ul class="dropdown-menu-list scroller notifications-container" style="height: 250px;" data-handle-color="#637283"></ul>
                                    </li>
                                </ul>
                            </li>
                            <!-- END NOTIFICATION DROPDOWN -->
                            <li class="dropdown">
                                <a href="{{ app('API')->options->get('project_url') }}" target="_blank" class="dropdown-toggle popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="{{ trans('mconsole::mconsole.links.website') }}">
                                    <i class="icon-share-alt"></i>
                                </a>
                            </li>
                            <li class="droddown dropdown-separator">
                                <span class="separator"></span>
                            </li>
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
                    <!-- BEGIN HEADER SEARCH BOX -->
                    <form class="search-form" action="" method="GET" style="position: relative;">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="{{ trans('mconsole::mconsole.search.placeholder') }}" name="query">
                            <span class="input-group-btn">
                                <span class="btn submit">
                                    <i class="icon-magnifier"></i>
                                </span>
                            </span>
                        </div>
                        <ul class="search-results"></ul>
                    </form>
                    <!-- END HEADER SEARCH BOX -->
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
							<h1>{{ (isset($pageCaption)) ? $pageCaption : trans('mconsole::mconsole.text.heading') }}
								<small>{{ (isset($pageSubcaption)) ? $pageSubcaption : trans('mconsole::mconsole.text.version') }}</small>
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
							
							@if (isset($filters))
							<div class="portlet light">
								<div class="portlet-title">
									<div class="caption">
										<i class="icon-magnifier font-grey-gallery"></i>
										<span class="caption-subject bold font-grey-gallery uppercase">{{ trans('mconsole::traits.filters.filter') }}</span>
									</div>
									<div class="tools">
										<a href="" class="{{ ($filtered) ? 'collapse' : 'expand' }}"> </a>
									</div>
								</div>
								<div class="portlet-body {{ ($filtered) ? null : 'portlet-collapsed' }}">
									@include('mconsole::traits.filters')
								</div>
							</div>
							@endif
							
                            @yield('content', '<div class="row">
                                <div class="col-xs-12">
                                    <div class="portlet light">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-bulb font-dark"></i>
                                            <span class="caption-subject font-dark bold uppercase">Мудрость минуты</span>
                                        </div>
                                    </div>
                                        <div class="portlet-body form">
                                            <div class="table-scrollable table-scrollable-borderless">
                                                <blockquote>
                                                    <p>“ ' . app('API')->quotes->getText() . ' „</p>
                                                    <small><cite title="Source Title">' . app('API')->quotes->getAuthor() . '</cite></small>
                                                </blockquote>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </test>')
							
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
			<div class="container">@datetime('Y') &copy; <a href="http://www.milax.com/" target="_blank">Milax</a>
                <div class="pull-right"><a href="https://github.com/milaxcom/mconsole/releases/tag/{{ app_version }}" target="_blank">mconsole {{ app_version }}</a></div>
            </div>
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
        <script src="/massets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
        <script src="/massets/global/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js" type="text/javascript"></script>
        <script src="/massets/global/plugins/jquery-file-upload/js/vendor/tmpl.min.js" type="text/javascript"></script>
        <script src="/massets/global/plugins/jquery-file-upload/js/vendor/load-image.min.js" type="text/javascript"></script>
        <script src="/massets/global/plugins/jquery-file-upload/js/vendor/canvas-to-blob.min.js" type="text/javascript"></script>
        <script src="/massets/global/plugins/jquery-file-upload/blueimp-gallery/jquery.blueimp-gallery.min.js" type="text/javascript"></script>
        <script src="/massets/global/plugins/jquery-file-upload/js/jquery.iframe-transport.js" type="text/javascript"></script>
        <script src="/massets/global/plugins/jquery-file-upload/js/jquery.fileupload.js" type="text/javascript"></script>
        <script src="/massets/global/plugins/jquery-file-upload/js/jquery.fileupload-process.js" type="text/javascript"></script>
        <script src="/massets/global/plugins/jquery-file-upload/js/jquery.fileupload-image.js" type="text/javascript"></script>
        <script src="/massets/global/plugins/jquery-file-upload/js/jquery.fileupload-audio.js" type="text/javascript"></script>
        <script src="/massets/global/plugins/jquery-file-upload/js/jquery.fileupload-video.js" type="text/javascript"></script>
        <script src="/massets/global/plugins/jquery-file-upload/js/jquery.fileupload-validate.js" type="text/javascript"></script>
        <script src="/massets/global/plugins/jquery-file-upload/js/jquery.fileupload-ui.js" type="text/javascript"></script>
		<!-- END PAGE LEVEL PLUGINS -->
		<!-- BEGIN THEME GLOBAL SCRIPTS -->
		<script src="/massets/global/scripts/app.min.js" type="text/javascript"></script>
		<script src="/massets/js/mconsole.js" type="text/javascript"></script>
		<script src="/massets/js/form-images-upload.js" type="text/javascript"></script>
		<!-- END THEME GLOBAL SCRIPTS -->
		<!-- BEGIN PAGE LEVEL SCRIPTS -->
		<script src="/massets/js/date-pickers.js" type="text/javascript"></script>
		<script src="/massets/js/links-editor.js" type="text/javascript"></script>
		<!-- END PAGE LEVEL SCRIPTS -->
		<!-- BEGIN THEME LAYOUT SCRIPTS -->
		<script src="/massets/layouts/layout3/scripts/layout.min.js" type="text/javascript"></script>
		<script src="/massets/layouts/layout3/scripts/demo.min.js" type="text/javascript"></script>
		<!-- END THEME LAYOUT SCRIPTS -->
        @yield('page.scripts')
	</body>
</html>
