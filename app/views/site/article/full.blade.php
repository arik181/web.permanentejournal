@section('head')
@stop

@section('main')
<div class="row">
    <div class="col-xs-12">
        <h3>{{ Str::title($article->article_name); }}</h3>
        <p>{{ $article->content }}</p>
    </div>
</div>
@stop

@section('footer')
<footer class="container-fluid">
    <div class="row">
        <div class="col-xs-12 text-center">
            <div class="container action-group">
                @if( $wrong === true )
                <a class="btn btn-primary btn-block btn-lg" onclick="window.history.back()">See What I Got Wrong</a>
                @elseif ( $quiz === true )
                <a class="btn btn-primary btn-block btn-lg" onclick="window.history.back()">Back to Quiz</a>
                @else
                <a class="btn btn-primary btn-block btn-lg" href="{{ URL::to('/quiz/home/' . $article->quiz_id ) }}">Start Quiz</a>
                @endif
            </div>
        </div>
    </div>
</footer>
@stop
