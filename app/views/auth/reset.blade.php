@section('main')

    {{ Form::open(array('url' => 'users/reset_password', 'class'=>'user-auth show-grid-top-md')) }}
        <div class="form-group form-desc">
            <p>Please enter your new password.</p>
        </div>

        <div class="form-group">
            {{ Form::label('password', Lang::get('confide::confide.password'), array('class' => 'sr-only') ) }}
            {{ Form::text('password', Input::old('password'), array('class' => 'form-control input-responsive-lg input-transparent', 'placeholder' => 'Password' )) }}
            {{ Form::text('password_confirmation', Input::old('password_confirmation'), array('class' => 'form-control input-responsive-lg input-transparent', 'placeholder' => 'Password Confirmation' )) }}
            {{ Form::hidden('token', $token) }}
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
