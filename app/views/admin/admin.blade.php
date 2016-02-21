@section('head')
<script src="{{ URL::asset('assets/js/admin_user_delete_confirm.js') }}"></script>
<script src="{{ URL::asset('assets/js/bootstrap/modal.js') }}"></script>
@stop

@section('main')

    @if($errors->has())
    <div class="alert alert-warning">
        @foreach ($errors->all() as $error)
        {{ $error }}<br/>
        @endforeach
    </div>
    @endif


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
            <p>Are you sure you want to delete this admin?</p>
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