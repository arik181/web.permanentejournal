<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <link rel="stylesheet" type="text/css" media="screen, projection" href="{{ URL::asset('assets/css/screen.css') }}" />
        <link rel="stylesheet" type="text/css" media="print" href="{{ URL::asset('assets/css/print.css') }}" />
        <!--[if IE]>
        <link rel="stylesheet" type="text/css" media="screen, projection" href="{{ URL::asset('assets/css/ie.css') }}" />
        <![endif]-->

        <script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ URL::asset('assets/js/bootstrap.js') }}"></script>
        <script src="{{ URL::asset('assets/js/browser.js') }}"></script>

        @section('head')
        @show
    </head>
    <body class="{{{ isset($body_class) ? $body_class : '' }}}">
        <nav class="navbar navbar-gradient navbar-fixed-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-3">
                    <?php 
                    if ( ! (isset($question_number) && $question_number == 1)): ?>
                        <a class="back" onclick="window.history.back()"><i class="fa fa-angle-left"></i> Back</a>
                    <?php endif ?>
                    </div>

                    <div class="col-xs-6 text-center">
                        <h1>{{ $nav_title or '' }}</h1>
                    </div>

                    <div class="col-xs-3">
                        <div class="pull-right">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div id="navbar" class="collapse">
                        <ul class="nav">
                            <li><a href="{{ URL::to('/') }}"><i class="pull-left fa fa-home"></i> CME Home <i class="pull-right fa fa-angle-right"></i></a></li>
                            <li><a href="{{ URL::to('/profile') }}"><i class="pull-left fa fa-user"></i> My Profile <i class="pull-right fa fa-angle-right"></i></a></li>
                            <li><a href="mailto:permanente.journal@kp.org"><i class="pull-left fa fa-envelope-o"></i> Email Editorial Office <i class="pull-right fa fa-angle-right"></i></a></li>
                            @if (!empty($article->author_email))
                            <li><a href="mailto:{{{$article->author_email}}}?bcc=permanente.journal@kp.org"><i class="pull-left fa fa-envelope-o"></i> Email Author <i class="pull-right fa fa-angle-right"></i></a></li>
                            @endif
                            <li><a href="{{ URL::to('/logout') }}"><i class="pull-left fa fa-lock"></i> Logout <i class="pull-right fa fa-angle-right "></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <main class="container-fluid">
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
