@section('head')
@stop

@section('main')
    <div class="row">
        <ul class="list-unstyled list-striped list-group">
            @foreach( $wrongs as $wrong )
            <li class="list-group-item">
                <p>
                    <span class="blue-accent">Q{{ $wrong->article_number }}.{{ $wrong->question_number }}</span>
                    {{ $wrong->question_text }}
                </p>
                <p class="wrong-answer">
                    <span class="red-accent"><i class="fa fa-times"></i></span> <span class="blue-accent">{{ $wrong->answer_character }}. </span>{{ $wrong->answer_text }}<br />
                </p>
                <div class="text-right"><a href="{{ URL::to('/articlew/' . $wrong->article_id ) }}">SEE ARTICLE<strong><i class="fa fa-angle-right"></i></strong></a></div>
            </li>
            @endforeach
        </ul>
    </div>
@stop

@section('footer')
@stop
