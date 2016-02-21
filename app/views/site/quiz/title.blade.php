@section('head')
<script src="{{ URL::asset('assets/js/skip.js') }}"></script>
<script src="{{ URL::asset('assets/js/bootstrap/modal.js') }}"></script>

<script>
    // used in skip.js
    var quiz_id = {{ $quiz->id }} ;
    var skip_id = 30 ;
</script>
@stop

@section('main')
<div class="row">
    <div class="col-xs-12">
        <h3>{{ Str::title($quiz->quiz_name); }}</h3>
        <p>{{ $article->preview_content }}</p>
    </div>
</div>
@stop

@section('footer')
<footer class="container-fluid">
    <div class="row">
        <div class="col-xs-12 text-center">
            <div class="container action-group">
                <a class="btn btn-primary btn-block btn-lg" href="{{ URL::to('/quiz/summary/' . $quiz->id . '/' . $first_question->id) }}">Continue</a>
                <div id="modal_trigger" class="btn btn-primary btn-block btn-lg">Skip Questions</div>
            </div>
        </div>
    </div>
    <div id="modal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <p>Are you sure you want to skip this article?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            <button type="button" id="modal_skip" class="btn btn-primary">Yes</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</footer>
@stop
