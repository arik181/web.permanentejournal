@section('head')
<script src="{{ URL::asset('assets/js/agree.js') }}"></script>
@stop

@section('main')
<div class="row show-grid-top-sm">
    <div class="col-xs-12">
        <p style="text-indent: 2em">
        The Kaiser Permanente National CME Program is accredited by the Accreditation Council for Continuing Medical Education (ACCME) to provide continuing medical education for physicians.
        </p>
        <p style="text-indent: 2em">
        The Kaiser Permanente National CME Program designates this journal-based CME activity for a maximum of <em>4 AMA PRA Category 1 Credits™</em>. Physicians should claim only the credit commensurate with the extent of their participation in the activity.
        </p>
        <p style="text-indent: 2em">
        Physicians and other clinicians for whom CME is acceptable in meeting educational requirements may report up to 4 hours of participation upon receipt of the completion certificate. Participants must answer at least 50% of questions correctly to receive credit.
        </p>
    </div>
</div>
@stop

@section('footer')
<footer class="container-fluid">
    <div class="row">
        <div class="col-xs-12 text-center">
            <div class="container action-group">
                <a id="agree" class="btn btn-primary btn-block btn-lg">I agree</a>
                <a class="btn btn-primary btn-block btn-lg disabled" href="{{ URL::to('/article/list/' . $quiz->id) }}">Read Articles</a>
                <a class="btn btn-primary btn-block btn-lg disabled" href="{{ URL::to('/quiz/home/' . $quiz->id) }}">Take Quiz</a>
            </div>
        </div>
    </div>
</footer>
@stop
