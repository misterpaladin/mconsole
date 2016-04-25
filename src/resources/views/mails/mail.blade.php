<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Letter</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        body {
            margin: 0 !important;
        }
        
        * {
            font-family: "Helvetica Neue", Arial;
            color: #333;
            font-size: 14px;
            font-weight: normal;
            line-height: 1.4;
        }
        
        a {
            color: #14428a;
        }
        
        img {
            border: none !important;
        }
        
        h1 {
            font-weight: bold;
            font-size: 22px;
            margin: 0;
            /* padding: 0 0 20px 0;*/
            line-height: 1;
        }
        
        .bg {
            text-align: center;
            width: 100%;
            background: #f5f5f5 url(http://letter.layout.milax.com/bg.gif) repeat;
            border-collapse: collapse;
            height: 100%;
        }
        
        .bg .bg-inside {
            padding: 30px 0 0 0;
        }
        
        .main {
            width: 640px;
            margin: 0 auto;
            text-align: left;
            /*padding: 0 30px;*/
        }
        
        .main .box {
            border-collapse: collapse;
            padding: 0;
            background-color: #fff;
            -webkit-box-shadow: 0px 0px 3px 0px rgba(0, 0, 0, 0.3);
            -moz-box-shadow: 0px 0px 3px 0px rgba(0, 0, 0, 0.3);
            box-shadow: 0px 0px 3px 0px rgba(0, 0, 0, 0.3);
            -webkit-border-radius: 6px;
            -moz-border-radius: 6px;
            border-radius: 6px;
        }
        
        .head,
        .head td,
        .head tr {
            border-collapse: collapse;
            padding: 0;
            border-spacing: 0;
        }
        
        .head .logo {
            padding-left: 30px;
            width: 290px;
        }
        
        .head .logo img {
            display: block;
        }
        
        .head .name {
            /*border-spacing: 18px;*/
            width: 320px;
        }
        
        .head .name td {
            padding-left: 20px;
            border-left: 1px solid #e5e5e5;
            height: 60px;
            /*border-bottom: 14px solid #fff; border-top: 15px solid #fff;*/
            font-size: 10px;
        }
        
        .head .name a {
            font-size: 12px;
            font-weight: bold;
        }
        
        .head-v2 {
            border-bottom: 1px solid #e5e5e5;
        }
        
        .image,
        .image td {
            border-spacing: 0;
            padding: 0;
            border-collapse: collapse;
        }
        
        .image img {
            display: block;
        }
        
        .content-block p {
            padding: 0 0 14px 0;
            margin: 0;
        }
        
        .content-block .caption {
            border: 30px solid #fff;
            border-bottom-width: 20px;
        }
        
        .content-block .text {
            border: 30px solid #fff;
            border-top: none;
        }
        
        .content-block .but {
            /*padding-top: 9px;*/
            border-bottom: 30px solid #fff;
            border-left: 30px solid #fff;
        }
        
        .content-block .but a {
            display: block;
            height: 50px;
            text-align: center;
            color: #fff;
            background-color: #377cb5;
            text-decoration: none;
            line-height: 3.4;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
        }
        
        .content-block .standart-but a {
            width: 200px;
        }
        
        .content-block .content-table td {
            border-bottom: 8px solid #fff;
            vertical-align: top;
        }
        
        .content-block .content-table .first {
            width: 200px;
            font-weight: bold;
        }
        
        .content-block content-table .second {
            width: 380px;
        }
        
        .footer td {
            width: 290px;
            padding: 9px 30px 30px 30px;
            /*border-bottom: none;*/
        }
        
        .footer a {
            font-size: 12px;
            font-weight: bold;
        }
        
        .footer .links {
            text-align: right;
        }
        
        .footer .links a {
            padding-left: 18px;
        }
    </style>

</head>

<body>
    <table class="bg">
        <tr>
            <td class="bg-inside">

                <table class="main">
                    <tr>
                        <td class="box">
                            <table class="head head-v2">
                                <tr>
                                    <td class="logo">
                                        <a href="#"><img src="http://placehold.it/240x96" alt="" /></a>
                                    </td>
                                    <td class="name">
                                        <table>
                                            <tr>
                                                <td>
                                                    Наш сайт
                                                    <br /><a href="{{ app('API')->options->get('project_url') }}">{{ app('API')->options->get('project_url') }}</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <table>
                                <tr>
                                    <td>
                                        <table class="content-block" cellpadding="0" cellspacing="0">
                                            
                                            @if (isset($heading))
                                                <tr>
                                                    <td class="caption">
                                                        <h1>{{ $heading }}</h1></td>
                                                </tr>
                                            @endif
                                            
                                            @if (isset($text))
                                                <tr>
                                                    <tr>
                                                        <td class="text">
                                                            {{ $text }}
                                                        </td>
                                                    </tr>
                                                </tr>
                                            @endif
                                            
                                            @if (isset($table))
                                                <tr>
                                                    <td class="text">
                                                        <table class="content-table">
                                                            @foreach ($table as $input)
                                                                <tr>
                                                                    <td class="first">{{ $input['key'] }}</td>
                                                                    <td class="second">{{ $input['value'] }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </table>
                                                    </td>
                                                </tr>
                                            @endif
                                            
                                            @if (isset($action))
                                                <tr>
                                                    <td class="but standart-but">
                                                        <a href="{{ $action['link'] }}">{{ $action['name'] }}</a>
                                                    </td>
                                                </tr>
                                            @endif
                                            
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>