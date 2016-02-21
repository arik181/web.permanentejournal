@section('head')
<script src="{{ URL::asset('assets/js/skip.js') }}"></script>
<script src="{{ URL::asset('assets/js/bootstrap/modal.js') }}"></script>

<script>
    // used in skip.js
    var quiz_id    = {{ $quiz->id }} ;
    var article_id = {{ $article->id }} ;
    @if( $next_article )
        var skip_article_id = {{ $next_article->id }} ;
    @else
        var skip_article_id = null ;
    @endif
</script>
@stop

@section('main')
<div class="row">
    <div class="col-xs-12">
        <h3>{{ Str::title($article->article_name); }}</h3>
        <p>{{ $article->preview_content }}</p>
    </div>
</div>
@stop

@section('footer')
<footer class="container-fluid">
    <div class="row">
        <div class="col-xs-12 text-center">
            <div class="container action-group">
                <a class="btn btn-primary btn-block btn-lg" href="{{ URL::to('/quiz/' . $quiz->id . '/' . $article->id . '/' . $first_question->id ) }}">Continue</a>
                <div id="modal_trigger" class="btn btn-primary btn-block btn-lg">Skip Questions</div>
                <a class="btn btn-primary btn-block btn-lg" href="{{ URL::to('/articleq/' . $article->id ) }}">Read Article</a>
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
