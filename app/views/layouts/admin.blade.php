<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>

        <link rel="stylesheet" type="text/css" media="screen, projection" href="{{ URL::asset('assets/css/screen.css') }}" />
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/3cfcc339e89/integration/bootstrap/3/dataTables.bootstrap.css" />
        <link rel="stylesheet" type="text/css" media="print" href="{{ URL::asset('assets/css/print.css') }}" />

        <!--[if IE]>
        <link rel="stylesheet" type="text/css" media="screen, projection" href="{{ URL::asset('assets/css/ie.css') }}" />
        <![endif]-->

        <script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ URL::asset('assets/js/bootstrap.js') }}"></script>
        <script src="{{ URL::asset('assets/js/browser.js') }}"></script>
        <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/plug-ins/3cfcc339e89/integration/bootstrap/3/dataTables.bootstrap.js"></script>

        @section('head')
        @show
    </head>
    <body class="{{{ isset($body_class) ? $body_class : '' }}}">
        <header class="container text-center">
            {{ HTML::image('/assets/images/logo-permanente-journal.png', 'logo' ) }}
        </header>
        <nav class="navbar admin-nav">
            <div class="container text-center">
                <ul class="list-inline">
                    <li><a href="{{ URL::to('/admin/quiz') }}">Quiz Manager</a></li>
                    <li><a href="{{ URL::to('/admin/list') }}">Admin Manager</a></li>
                    <li><a href="{{ URL::to('/logout') }}">Logout</a></li>
                </ul>
            </div>
        </nav>
        <main class="container admin">
            <div class="row">
                <div class="col-xs-12">
                    @yield('main')
                </div>
            </div>
            <footer class="sticky-foot row"></footer>
        </main>
        @section('footer')
        @show
    </body>
</html>
