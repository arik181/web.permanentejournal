@section('main')

    {{ Form::open(array('url' => 'login', 'class'=>'user-auth show-grid-top-md')) }}
        <header class="row">
            <div class="form-group">
                {{ HTML::image('/assets/images/logo-permanente-journal.png', 'logo', array('class'=>'img-responsive')) }}
            </div>
        </header>

        <div class="form-group">
            {{ Form::label('email', 'Username', array('class' => 'sr-only') ) }}
            {{ Form::text('email', Input::old('email'), array('class' => 'form-control input-responsive-lg input-transparent', 'placeholder' => 'Username' )) }}
        </div>

        <div class="form-group">
            {{ Form::label('password', Lang::get('confide::confide.password'), array('class' => 'sr-only') ) }}
            {{ Form::password('password', array('class' => 'form-control input-responsive-lg input-transparent', 'placeholder' => Lang::get('confide::confide.password'))) }}
            <p class="help-block text-right">
                <a href="{{ URL::to('/forgot_password') }}" class="white">Forgot Password <i class="fa fa-angle-right"></i></a>
            </p>
        </div>

        @if (Session::get('error'))
        <div class="alert alert-error alert-danger">{{{ Session::get('error') }}}</div>
        @endif

        @if (Session::get('notice'))
        <div class="alert alert-success">{{{ Session::get('notice') }}}</div>
        @endif

        <div class="form-group">
            <div class="container action-group">
            {{ Form::submit(Lang::get('confide::confide.login.submit'), array('class'=>'btn btn-default btn-block btn-lg')) }}
            </div>
        </div>

        <div class="form-group text-center login-actions">
            <span class="blue">New User?</span> <a href="{{ URL::to('/register') }}" class="white">Create An Account</a>
        </div>

        <!--
        <div class="checkbox">
            <label for="remember">
                <input type="hidden" name="remember" value="0">
                <input tabindex="4" type="checkbox" name="remember" id="remember" value="1"> {{{ Lang::get('confide::confide.login.remember') }}}
            </label>
        </div>
        -->
    {{ Form::close() }}

        <div id="browser-modal" class="modal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Unsupported Browser</h4>
              </div>
              <div class="modal-body">
                <p>This browser is either out of date or not supported. For best performance, please update your browser or download a supported browser from the following link: <a href="https://www.google.com/intl/en/chrome/browser/desktop/index.html">Google Chrome (Android)</a> Learn how to update your version of iOS to gain access to the latest version of Safari: <a href="https://support.apple.com/en-us/HT204204">Safari (iOS)</a> </p>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
@stop
