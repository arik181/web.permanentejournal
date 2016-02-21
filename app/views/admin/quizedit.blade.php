@section('head')
<script src="{{ URL::asset('assets/js/article_delete_confirm.js') }}"></script>
<script src="{{ URL::asset('assets/js/bootstrap/modal.js') }}"></script>
@stop

@section('main')

    @if($errors->has())
    <div class="alert alert-warning">
        @foreach ($errors->all() as $error)
        {{ $error }}<br />
        @endforeach
    </div>
    @endif

    @if (Session::get('success'))
    <div class="alert alert-success">{{{ Session::get('success') }}}</div>
    @endif

    <h2>{{ $quiz->quiz_name }}</h2>

    {{ Form::open(array('url' => 'admin/quiz/' . $quiz->id, 'class'=>'admin-edit-form show-grid-md')) }}
        <div class="row">
            <div class="col-xs-6">
                {{ Form::label('quiz_name', 'Quiz Name') }}
                <div class="input-group">
                    {{ Form::text('quiz_name', $quiz->quiz_name, array('class' => 'form-control', 'placeholder' => 'Quiz Name' )) }}
                    <span class="input-group-btn">
                        {{ Form::submit('Update', array('class'=>'btn btn-primary')) }}
                    </span>
                </div>
            </div>
            <div class="col-xs-6">
                <a href="{{ URL::to('/admin/article/create/' . $quiz->id ) }}" class="btn btn-primary btn-md pull-right">Add New Article</a>
            </div>
        </div>
    {{ Form::close() }}

    @include('admin._list')

    @if (Session::get('error'))
    <div class="alert alert-error alert-danger">{{{ Session::get('error') }}}</div>
    @endif

    @if (Session::get('notice'))
    <div class="alert">{{{ Session::get('notice') }}}</div>
    @endif

@stop

@section('footer')
<footer class="container-fluid">
    <div id="modal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <p>Are you sure you want to delete this article?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            <button type="button" id="modal_delete" class="btn btn-primary">Yes</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</footer>
@stop
