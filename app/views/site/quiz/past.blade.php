@section('head')
@stop

@section('main')
@if ( count($quizzes) !== 0 )
<div class="row">
    <ul class="list-group nav">
        @foreach( $quizzes as $quiz )
        <li class="list-group-item">
        @if ( $quiz->passed )
            <span>{{ $quiz->quiz_name ? $quiz->quiz_name : 'Un-named' }} <i class="pull-right fa fa-angle-right"></i></span>
        @else
            <a href="{{ URL::to('/quiz/about/' . $quiz->id ) }}">{{ $quiz->quiz_name ? $quiz->quiz_name : 'Un-named' }} <i class="pull-right fa fa-angle-right"></i></a>
        @endif
        </li>
        @endforeach
    </ul>
</div>
@else 
    No Articles Available
@endif
@stop

@section('footer')
@stop
