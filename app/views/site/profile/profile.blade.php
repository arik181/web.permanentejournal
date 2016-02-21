@section('main')

    {{ Form::open(array('url' => 'profile', 'class'=>'user-auth show-grid-top-md')) }}

        <div class="form-group">
            {{ Form::label('first_name', 'First Name', array('class' => 'sr-only') ) }}
            {{ Form::text('first_name', $user->first_name, array('class' => 'form-control input-responsive-lg input-transparent', 'placeholder' => 'First Name' )) }}
        </div>

        <div class="form-group">
            {{ Form::label('last_name', 'Last Name', array('class' => 'sr-only') ) }}
            {{ Form::text('last_name', $user->last_name, array('class' => 'form-control input-responsive-lg input-transparent', 'placeholder' => 'Last Name' )) }}
        </div>

        <div class="form-group">
            {{ Form::label('email', 'Email', array('class' => 'sr-only') ) }}
            {{ Form::text('email', $user->email, array('class' => 'form-control input-responsive-lg input-transparent', 'placeholder' => 'Email' )) }}
        </div>

        <div class="form-group">
            {{ Form::label('username', 'confide::confide.username', array('class' => 'sr-only') ) }}
            {{ Form::text('username', $user->username, array('class' => 'form-control input-responsive-lg input-transparent', 'placeholder' => 'Username' )) }}
        </div>

        <div class="form-group">
            {{ Form::label('degree', 'Degree', array('class' => 'sr-only') ) }}
            {{ Form::text('degree', $user->degree, array('class' => 'form-control input-responsive-lg input-transparent', 'placeholder' => 'Degree' )) }}
        </div>

        <div class="form-group">
            {{ Form::label('password', Lang::get('confide::confide.password'), array('class' => 'sr-only') ) }}
            {{ Form::password('password', array('class' => 'form-control input-responsive-lg input-transparent', 'placeholder' => Lang::get('confide::confide.password'))) }}
        </div>

        <div class="form-group">
            {{ Form::label('password_confirmation', Lang::get('confide::confide.password_confirmation'), array('class' => 'sr-only') ) }}
            {{ Form::password('password_confirmation', array('class' => 'form-control input-responsive-lg input-transparent', 'placeholder' => Lang::get('confide::confide.password_confirmation'))) }}
        </div>

        @if (Session::get('error'))
            <div class="alert alert-error alert-danger">
            @foreach (Session::get('error') as $error)
            <div>{{{ $error }}}</div>
            @endforeach
            </div>
        @endif

        @if (Session::get('notice'))
        <div class="alert">{{{ Session::get('notice') }}}</div>
        @endif

        <div class="form-group">
            <div class="container action-group">
                {{ Form::submit('Update', array('class'=>'btn btn-primary btn-block btn-lg')) }}
            </div>
        </div>

    {{ Form::close() }}

@stop
