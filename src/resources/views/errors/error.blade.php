
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>{{ $status }} | Mconsole</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="/massets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="/massets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="/massets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="/massets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="/massets/global/css/components-md.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="/massets/global/css/plugins-md.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="/massets/pages/css/error.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->

    <body class=" page-404-3">
        <div class="page-inner">
            <img src="/massets/pages/img/errors/earth.jpg" class="img-responsive" alt=""> </div>
        <div class="container error-404">
            <h1>{{ $text[$status]['title'] }}</h1>
            {!! $text[$status]['text'] !!}
            @if (URL::previous() == Request::url())
                <p><a href="/mconsole/" class="btn red btn-outline"> {{ $text['home'] }} </a><br></p>
            @else
                <p><a href="{{ URL::previous() }}" class="btn red btn-outline"> {{ $text['back'] }} </a><br></p>
            @endif
        </div>
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
        <script src="/massets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="/massets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-37564768-1', 'keenthemes.com');
  ga('send', 'pageview');
</script>
</body>


</html>