@section('main')

    {{ Form::open(array('url' => 'forgot_password', 'class'=>'user-auth show-grid-top-md')) }}
        <div class="form-group form-desc">
            <p>Enter your email address if you forgot your password.</p>
        </div>

        <div class="form-group">
            {{ Form::label('email', Lang::get('confide::confide.e_mail'), array('class' => 'sr-only') ) }}
            {{ Form::text('email', Input::old('email'), array('class' => 'form-control input-responsive-lg input-transparent', 'placeholder' => 'Email Address' )) }}
        </div>

        @if (Session::get('error'))
        <div class="alert alert-error alert-danger">{{{ Session::get('error') }}}</div>
        @endif

        @if (Session::get('notice'))
        <div class="alert alert-success">{{{ Session::get('notice') }}}</div>
        @endif

        <div class="form-group">
            <div class="container action-group">
            {{ Form::submit('Submit', array('class'=>'btn btn-primary btn-block btn-lg')) }}
            </div>
        </div>

    {{ Form::close() }}

@stop
