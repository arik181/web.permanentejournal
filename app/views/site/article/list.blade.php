@section('head')
@stop

@section('main')
    @if ( count($articles) !== 0 )
    <div class="row">
        <ul class="list-group nav">
            @foreach( $articles as $article )
            <li class="list-group-item">
                <a href="{{ URL::to('/article/' . $article->id) }}">{{ $article->article_name }} <i class="pull-right fa fa-angle-right"></i></a>
            <span class=""></span></li>
            @endforeach
        </ul>
    </div>
    @else 
        No Articles Available
    @endif
@stop

@section('footer')
@stop
