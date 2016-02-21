@section('head')
<script src="{{ URL::asset('assets/js/continue.js') }}"></script>
@stop

@section('main')
{{ Form::open(array("/quiz/$quiz->id/$article->id/$question->id")) }}

@if ( $question->question_type == 'article' )
    <div class="row show-grid-top-sm show-grid-md">
        <div class="col-xs-12">
            <p>
                <span class="blue-accent">{{ $question_char }}{{ $article_number }}.{{ $question_number }}</span>
                {{ $question->question_text }}
            </p>
        </div>
    </div>
@endif

<div class="row">
    <div class="col-xs-12">
        @if ( $question->question_type == 'article' )
        @foreach( $answers as $answer )
            @if ( $answer->answer_text !== '' )
            <div class="form-group">
                <label class="answer-label">
                    <input type="radio" name="response" id="optionsRadios{{ $answer->answer_value }}" value="{{ strval($answer->answer_value) }}" {{ $answer->response ? 'checked' : '' }} >
                    <span class="blue-accent">{{ Str::Title($answer->answer_char) }}.</span> 
                    {{ $answer->answer_text }}
                </label>
            </div>
            @endif
        @endforeach
        @else
            <div class="row show-grid-top-sm show-grid-md">
                <div class="col-xs-12">
                    <p>
            @if ( $question_number === 3 ) 
                Objective 1: Referring to this CME article, how likely is it that within the next 3 months you will: Integrate learned knowledge and increase competence/confidence to support improvement and change in specific practices, behaviors, and performance?
            @endif
            @if ( $question_number === 4 ) 
                Objective 2: Referring to this CME article, how likely is it that within the next 3 months you will: Lead in further developing “Patient-Centered Care” activities by acquiring new skills and methods to overcome barriers, improve physician/patient relationships, better identify diagnosis and treatment of clinical conditions, as well as efficiently stratify health needs of varying patient populations?
            @endif
            @if ( $question_number === 5 ) 
                Objective 3: Referring to this CME article, how likely is it that within the next 3 months you will: Implement changes and apply updates in services and practice/policy guidelines, incorporate systems and quality improvements, and effectively utilize evidence-based medicine to produce better patient outcomes?
            @endif
                    </p>
                </div>
            </div>
            <div class="form-group">
                {{ Form::select('response', 
                                    array('0' => '-- Select A Response --',
                                          '1' => 'Highly Likely',
                                          '2' => 'Likely',
                                          '3' => 'Unsure',
                                          '4' => 'Unlikely',
                                          '5' => 'Highly Unlikely',
                                          '6' => 'I already did this'),
                                    $question->choice_value,
                                    array( 'id' => 'continue_trigger' )) }}
            </div>
        @endif
    </div>
</div>

@stop

@section('footer')
<footer class="container-fluid">
    <div class="row">
        <div class="col-xs-12 text-center">
            <div class="container action-group">
            <?php 
            if (isset($question_number) && $question_number > 2): ?>
             {{ Form::submit('Continue', array('class' => 'btn btn-primary btn-block btn-lg disabled' )) }}
            <?php else: ?>
             {{ Form::submit('Continue', array('class' => 'btn btn-primary btn-block btn-lg' )) }}
            <?php endif ?>
            </div>
        </div>
    </div>
</footer>
{{ Form::close() }}
@stop
