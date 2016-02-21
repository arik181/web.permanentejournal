@section('head')
<script src="{{ URL::asset('assets/js/retake.js') }}"></script>
<script src="{{ URL::asset('assets/js/quiz_disable_certificate.js') }}"></script>
<script>
    var quiz_id = {{ $quiz->id }} ;
    var passed  = <?php echo $passed ? '1' : '0' ; ?> ;
</script>
@stop

@section('main')
<div class="row">
    <div class="col-xs-12 text-center">
        <h2 class="{{ $passed ? 'blue-accent' : 'red-accent' }}">{{ $percent_correct }}% correct</h2>
        <p>{{ 
            $passed ? 
            'You passed certification.<br/>Your Credit Certificate emailed to: ' . $cert->email : 
            'You did not pass certification.'
           }}
        </p>
    </div>
</div>
@stop

@section('footer')
<footer class="container-fluid">
    <div class="row">
        <div class="col-xs-12 text-center">
            <div class="container action-group">
                <?php /*
                @if( $passed )
                <div id="send_trigger" class="btn btn-primary btn-block btn-lg" style="margin-bottom: 18px">Get Credit Certificate</div>
                @endif
                 */ ?>
                <a class="btn btn-primary btn-block btn-lg disabled" href="{{ URL::to('/quiz/retake/' . $quiz->id ) }}" role="button">Retake Quiz</a>
                <a class="btn btn-primary btn-block btn-lg" href="{{ URL::to('/quiz/incorrect/' . $quiz->id ) }}" role="button">See What I Got Wrong</a>
                <a class="btn btn-primary btn-block btn-lg" href="{{ URL::to('/quiz/welcome') }}" role="button">Back to CME Home</a>
            </div>
        </div>
    </div>
</footer>
@stop
