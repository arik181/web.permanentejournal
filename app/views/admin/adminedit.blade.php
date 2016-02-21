@section('main')

    @if($errors->has())
    <div class="alert alert-warning">
        @foreach ($errors->all() as $error)
        {{ $error }}<br/>
        @endforeach
    </div>
    @endif

@if (Session::get('error'))
<div class="alert alert-error alert-danger">
    @if (is_array(Session::get('error')))
    {{ head(Session::get('error')) }}
    @endif
</div>
@endif

@if (Session::get('notice'))
<div class="alert">{{ Session::get('notice') }}</div>
@endif

@if (Session::get('success'))
<div class="alert alert-success">{{{ Session::get('success') }}}</div>
@endif

<h2>Edit Admin</h2>

{{ Form::open(array('url' => 'admin/edit/' . $user->id, 'class'=>'admin-edit-form')) }}
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                {{ Form::label('first_name', 'First Name') }}
                {{ Form::text('first_name', $user->first_name, ['size'=>'30x3', 'class'=>'form-control', 'placeholder'=>'first name', 'tabindex' => 1] ) }}
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                {{ Form::label('username', 'Username') }}
                {{ Form::text('username', $user->username, ['size'=>'30x3', 'class'=>'form-control', 'placeholder'=>'Username', 'tabindex' => 5] ) }}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                {{ Form::label('last_name', 'Last Name') }}
                {{ Form::text('last_name', $user->last_name, ['size'=>'30x3', 'class'=>'form-control', 'placeholder'=>'last name', 'tabindex' => 2] ) }}
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                {{ Form::label('password', 'Password') }}
                {{ Form::password('password', array('size'=>'30x3', 'class'=>'form-control', 'placeholder'=>'Password', 'tabindex' => 6) ) }}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                {{ Form::label('email', 'Email') }}
                {{ Form::text('email', $user->email, ['size'=>'30x3', 'class'=>'form-control', 'placeholder'=>'email', 'tabindex' => 3] ) }}
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                {{ Form::label('password_confirmation', 'Confirm Password') }}
                {{ Form::password('password_confirmation', array('size'=>'30x3', 'class'=>'form-control', 'placeholder'=>'Confirm Password', 'tabindex' => 7) ) }}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                {{ Form::label('degree', 'Degree') }}
                {{ Form::text('degree', $user->degree, ['size'=>'30x3', 'class'=>'form-control', 'placeholder'=>'degree', 'tabindex' => 4] ) }}
            </div>
        </div>
        <div class="col-xs-6"></div>
    </div>

<div class="row">
    <div class="col-xs-6 text-right">
        {{ Form::submit('Save', array('class'=>'btn btn-default')) }}
    </div>
    <div class="col-xs-6">
        {{ HTML::link( URL::to('/admin/list'), 'Cancel', array('class'=>'btn btn-default') ) }}
    </div>
</div>
{{ Form::close() }}

@stop


