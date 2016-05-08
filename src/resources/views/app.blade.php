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
		<title>{{ (isset($pageTitle)) ? sprintf('%s / Mconsole', $pageTitle, app('API')->options->getByKey('project_name')) : sprintf('%s / Mconsole', app('API')->options->getByKey('project_name')) }}</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta name="_token" content="{{ csrf_token() }}" />
		<!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700&subset=all' rel='stylesheet' type='text/css'>
		<link href="/massets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<link href="/massets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
		<link href="/massets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="/massets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <link href="/massets/global/plugins/bootstrap-colorpicker/css/colorpicker.css" rel="stylesheet" type="text/css" />
        <link href="/massets/global/plugins/jquery-minicolors/jquery.minicolors.css" rel="stylesheet" type="text/css" />
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
        <link href="/massets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="/massets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="/massets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css" />
		<link href="/massets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
		<!-- BEGIN THEME LAYOUT STYLES -->
		<link href="/massets/layouts/layout3/css/layout.min.css" rel="stylesheet" type="text/css" />
		<link href="/massets/layouts/layout3/css/themes/default.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="/massets/css/mconsole.css" rel="stylesheet" type="text/css" />
        <link href="/massets/css/blade-helper.css" rel="stylesheet" type="text/css" />
        
        @yield('page.styles')
        
		<!-- END THEME LAYOUT STYLES -->
		<link rel="shortcut icon" href="favicon.ico" />
	</head>
	<!-- END HEAD -->
	<body class="page-container-bg-solid page-boxed page-md page-header-menu-fixed">
        
        @include('mconsole::helpers.blade')
        
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
                                        <h3>{{ trans('mconsole::mconsole.quickmenu.title') }}</h3>
                                        <span class="pull-right"><a href="/mconsole/users/{{ Auth::id() }}/edit">Edit</a></span>
                                    </li>
                                    <li>
                                        <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                            @forelse (app('API')->quickmenu->get() as $qmItem)
                                                <li>
                                                    <a href="{{ $qmItem['link'] }}">
                                                        <span class="details">
                                                            @if (isset($qmItem['icon']))
                                                                <i class="{{ $qmItem['icon'] }}"></i>
                                                            @endif
                                                            {{ $qmItem['text'] }} </span>
                                                    </a>
                                                </li>
                                            @empty
                                                <li><a href="javascript:;"><span class="details">{{ trans('mconsole::mconsole.quickmenu.noelements') }}</span></a></li>
                                            @endforelse
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="{{ app('API')->options->getByKey('project_url') }}" target="_blank" class="dropdown-toggle popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="{{ trans('mconsole::mconsole.links.website') }}">
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
										<a href="/mconsole/users/{{ Auth::id() }}/edit">
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
                    @if (Auth::user()->role->key == 'root' || Auth::user()->role->search)
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
                    @endif
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
                            @yield('content')
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
                <div class="pull-right"><a href="https://github.com/milaxcom/mconsole/releases/tag/{{ app('API')->info->version }}" target="_blank">mconsole {{ app('API')->info->version }}</a></div>
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
		<script src="/massets/global/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
		<script src="/massets/global/plugins/ckeditor/config.js" type="text/javascript"></script>
        <script src="/massets/js/clipboard.min.js" type="text/javascript"></script>
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
        <script src="/massets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
		<script src="/massets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
		<script src="/massets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
		<script src="/massets/js/confirm.js" type="text/javascript"></script>
		<script src="/massets/js/mconsole.js" type="text/javascript"></script>
		<script src="/massets/global/scripts/app.js" type="text/javascript"></script>
        <script src="/massets/js/helpers.js" type="text/javascript"></script>
		<script src="/massets/js/search.js" type="text/javascript"></script>
		<script src="/massets/js/form-multi-upload.js" type="text/javascript"></script>
		<script src="/massets/js/date-pickers.js" type="text/javascript"></script>
		<script src="/massets/js/links-editor.js" type="text/javascript"></script>
		<script src="/massets/js/tags.js" type="text/javascript"></script>
		<script src="/massets/js/notifications.js" type="text/javascript"></script>
        <script src="/massets/js/blade-helper.js" type="text/javascript"></script>
		<!-- BEGIN THEME LAYOUT SCRIPTS -->
		<script src="/massets/layouts/layout3/scripts/layout.min.js" type="text/javascript"></script>
		<script src="/massets/layouts/layout3/scripts/demo.min.js" type="text/javascript"></script>
		<!-- END THEME LAYOUT SCRIPTS -->
        @yield('page.scripts')
        @include('mconsole::partials.messages')
	</body>
</html>
