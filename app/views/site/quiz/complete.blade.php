@section('head')
@stop

@section('main')
<header class="row">
    <div class="col-xs-12 text-center">
        <h2>You have finished the quiz</h2>
    </div>
</header>
@stop

@section('footer')
<footer class="container-fluid">
    <div class="row">
        <div class="col-xs-12 text-center">
            <div class="container action-group">
                <a class="btn btn-default btn-block btn-lg" href="{{ URL::to('/quiz/results/'. $quiz->id ) }}" role="button">Submit</a>
                <a class="btn btn-default btn-block btn-lg" href="{{ URL::to('/quiz/home/'. $quiz->id ) }}" role="button">Restart</a>
            </div>
        </div>
    </div>
</footer>
@stop
