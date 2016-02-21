@section('head')
<script src="{{ URL::asset('assets/js/welcome.js') }}"></script>
<script>
    var passed  = <?php echo $passed ? '1' : '0' ; ?> ;
</script>
@stop

@section('main')
<header class="row">
    <div class="col-xs-12 text-center">
        <h2>The Permanente Journal <br /> <span class="large">Welcome</span></h2>
    </div>
</header>

<div class="row">
    @if (Session::has('error'))
    <div class="col-xs-4"></div>
    <div class="col-xs-4 text-center alert alert-error alert-danger">{{{ Session::get('error') }}}</div>
    <div class="col-xs-4"></div>
    @endif

    @if (Session::has('notice'))
    <div class="col-xs-4"></div>
    <div class="col-xs-4 text-center alert alert-success">{{{ Session::get('notice') }}}</div>
    <div class="col-xs-4"></div>
    @endif

    @if (Session::has('message'))
    <div class="col-xs-4"></div>
    <div class="col-xs-4 text-center alert alert-success">{{{ Session::get('message') }}}</div>
    <div class="col-xs-4"></div>
    @endif
</div>

@stop

@section('footer')
<footer class="container-fluid">
    <div class="row">
        <div class="col-xs-12 text-center">
            <div class="container action-group">
                @if ( $current_quiz )
                <a class="btn btn-default btn-block btn-lg disabled" href="{{ URL::to('/quiz/about/' .  $current_quiz->id ) }}" role="button">Current Quiz</a>
                <a class="btn btn-default btn-block btn-lg" href="{{ URL::to('/quiz/past') }}" role="button">Past Quizzes</a>
                @endif
            </div>
        </div>
    </div>
</footer>
@stop
