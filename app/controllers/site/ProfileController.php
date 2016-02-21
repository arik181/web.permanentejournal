<?php

class ProfileController extends BaseController
{
    protected $layout = 'layouts.main';

    public function profile()
    {
        View::share('nav_title', 'My Profile');
        View::share('body_class', 'register');

        $user = Auth::user();
        
        $this->layout->content = View::make('site.profile.profile', array( 'user' => $user ));
    }

    public function update()
    {
        View::share('nav_title', 'My Profile');
        View::share('body_class', 'register');

        $this->layout->content = View::make('site.profile.profile');

        $user = User::find(Auth::id());

        $user->first_name            = Input::get('first_name');
        $user->username              = Input::get('username');
        $user->last_name             = Input::get('last_name');
        $user->email                 = Input::get('email');
        $user->degree                = Input::get('degree');
        $user->password              = Input::get('password');
        $user->password_confirmation = Input::get('password_confirmation');

        $user->save();

        $id = $user->id;

        $error = $user->errors()->all(':message');

        return Redirect::action('ProfileController@profile')->with('error', $error);
    }
}
