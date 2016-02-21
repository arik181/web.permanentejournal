<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
        <title></title>
        <link rel="stylesheet" type="text/css" media="screen, projection" href="{{ URL::asset('assets/css/screen.css') }}" />
        <link rel="stylesheet" type="text/css" media="print" href="{{ URL::asset('assets/css/print.css') }}" />
        <!--[if IE]>
        <link rel="stylesheet" type="text/css" media="screen, projection" href="{{ URL::asset('assets/css/ie.css') }}" />
        <script src="{{ URL::asset('assets/js/jquery-1.11.2.min.js') }}"></script>
        <script>
        $(document).ready(function ()
        {
            alert("This browser is either out of date or not supported. For best performance, please update Internet Explorer to version 11 or later.");
        });
        </script>
        <![endif]-->

        <!--[if !IE] -->
        <script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
        <!-- <![endif] -->

        <script src="{{ URL::asset('assets/js/bootstrap.js') }}"></script>
        <script src="{{ URL::asset('assets/js/browser.js') }}"></script>
        <script src="{{ URL::asset('assets/js/html5labels.js') }}"></script>

        @section('head')
        @show
    </head>
    <body class="{{{ isset($body_class) ? $body_class : '' }}}">
        <main class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    @yield('main')
                </div>
            </div>
        </main>
    </body>
</html>
