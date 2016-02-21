@section('main')

    {{ Form::open(array('url' => 'users', 'class'=>'user-auth show-grid-top-md')) }}

        <div class="form-group">
            {{ Form::label('first_name', 'First Name', array('class' => 'sr-only') ) }}
            {{ Form::text('first_name', Input::old('first_name'), array('class' => 'form-control input-responsive-lg input-transparent', 'placeholder' => 'First Name' )) }}
        </div>

        <div class="form-group">
            {{ Form::label('last_name', 'Last Name', array('class' => 'sr-only') ) }}
            {{ Form::text('last_name', Input::old('last_name'), array('class' => 'form-control input-responsive-lg input-transparent', 'placeholder' => 'Last Name' )) }}
        </div>

        <div class="form-group">
            {{ Form::label('email', 'Email', array('class' => 'sr-only') ) }}
            {{ Form::text('email', Input::old('email'), array('class' => 'form-control input-responsive-lg input-transparent', 'placeholder' => 'Email' )) }}
        </div>

        <div class="form-group">
            {{ Form::label('username', 'confide::confide.username', array('class' => 'sr-only') ) }}
            {{ Form::text('username', Input::old('username'), array('class' => 'form-control input-responsive-lg input-transparent', 'placeholder' => 'Username' )) }}
        </div>

        <div class="form-group">
            {{ Form::label('degree', 'Last Name', array('class' => 'sr-only') ) }}
            {{ Form::text('degree', Input::old('degree'), array('class' => 'form-control input-responsive-lg input-transparent', 'placeholder' => 'Degree' )) }}
        </div>

        <div class="form-group">
            {{ Form::label('password', Lang::get('confide::confide.password'), array('class' => 'sr-only') ) }}
            {{ Form::password('password', array('class' => 'form-control input-responsive-lg input-transparent', 'placeholder' => Lang::get('confide::confide.password'))) }}
        </div>

        <div class="form-group">
            {{ Form::label('password_confirmation', Lang::get('confide::confide.password_confirmation'), array('class' => 'sr-only') ) }}
            {{ Form::password('password_confirmation', array('class' => 'form-control input-responsive-lg input-transparent', 'placeholder' => Lang::get('confide::confide.password_confirmation'))) }}
        </div>

        <div class="form-group">
            <label for="is_physician" class="input-responsive-lg blue">Physician:
                <label for="yes" class="input-responsive-sm">Yes
                    <input id="yes" checked="checked" name="is_physician" type="radio" value="1">
                </label>
                <label for="no" class="input-responsive-sm">No
                    <input id="no" name="is_physician" type="radio" value="0">
                </label>
            </label>
        </div>
 
        @if (Session::get('error'))
        <div class="alert alert-error alert-danger">
            @foreach (Session::get('error') as $error)
            <div>{{{ $error }}}</div>
            @endforeach
        </div>
        @endif

        @if (Session::get('notice'))
        <div class="alert alert-success">{{{ Session::get('notice') }}}</div>
        @endif

        <div class="form-group">
            <div class="container action-group">
                {{ Form::submit(Lang::get('Create'), array('class'=>'btn btn-primary btn-block btn-lg')) }}
            </div>
        </div>

    {{ Form::close() }}

@stop
