@section('head')
@stop

@section('main')
<header class="row">
    <div class="col-xs-12 text-center">
        <h2>The Permanente Journal<br /><span class="large">{{ $quiz->quiz_name }}</span></h2>
    </div>
</header>
@stop

@section('footer')
<footer class="container-fluid">
    <div class="row">
        <div class="col-xs-12 text-center">
            <div class="container action-group">
                @if( $article )
                <a class="btn btn-default btn-block btn-lg" href="{{ URL::to('/quiz/summary/' . $quiz->id . '/' . $article->id ) }}" role="button">Continue</a>
                @else
                Quiz contains no articles
                @endif
            </div>
        </div>
    </div>
</footer>
@stop
