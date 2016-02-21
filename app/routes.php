<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/* Bind custom user validator */
App::bind('confide.user_validator', 'UserValidatorOverride');

Route::filter('noadmin', function()
{
    if (Auth::user()->is_admin) {
        return Redirect::to('/admin/quiz');
    }
});

Route::pattern('user_id',       '[0-9]+');
Route::pattern('admin_id',      '[0-9]+');
Route::pattern('quiz_id',       '[0-9]+');
Route::pattern('article_id',    '[0-9]+');
Route::pattern('question_id',   '[0-9]+');

$user = Auth::user();
$is_admin = $user ? $user->is_admin : 0;

// Admin
if ($is_admin) {
    Route::get('/', array('before' => 'auth', function() { return Redirect::to('/admin/quiz');  }));
    Route::group( array('before' => 'auth', 'prefix' => 'admin', 'namespace' => 'admin'), function()
    {
        Route::get ('list'                                                  , 'AdminController@adminlist');
        Route::get ('create'                                                , 'AdminController@create');
        Route::get ('edit/{admin_id}'                                       , 'AdminController@edit');
        Route::post('edit/{admin_id?}'                                      , 'AdminController@editpost');
        Route::get ('delete/{admin_id}'                                     , 'AdminController@remove');

        Route::get ('quiz'                                                  , 'QuizController@quizlist');
        Route::get ('quiz/create'                                           , 'QuizController@create');
        Route::get ('quiz/{quiz_id}'                                        , 'QuizController@edit');
        Route::post('quiz/{quiz_id}'                                        , 'QuizController@editpost');
        Route::get ('quiz/delete/{quiz_id}'                                 , 'QuizController@remove');

        Route::get ('article/create/{article_id}'                           , 'ArticleController@create');
        Route::get ('article/{article_id}'                                  , 'ArticleController@edit');
        Route::post('article/{article_id}'                                  , 'ArticleController@editpost');
        Route::get ('article/delete/{quiz_id}/{article_id}'                 , 'ArticleController@remove');
        Route::get ('article/moveup/{quiz_id}/{article_id}'                 , 'ArticleController@moveup');
        Route::get ('article/movedown/{quiz_id}/{article_id}'               , 'ArticleController@movedown');
    });
}

if (!$is_admin) {
    Route::get('/', array('before' => 'auth', function() { return Redirect::to('/quiz/welcome'); }));
}

Route::get ('quiz'    , function() { return Redirect::to('/quiz/welcome'); } );
Route::get ('article' , function() { return Redirect::to('/article/list'); } );

Route::group( array('before' => 'auth|noadmin'), function()
{
    // Quiz
    Route::get ('quiz/welcome'                                          , 'QuizController@welcome');
    Route::get ('quiz/past'                                             , 'QuizController@past');
    Route::get ('quiz/about/{quiz_id}'                                  , 'QuizController@about');
    Route::get ('quiz/home/{quiz_id}'                                   , 'QuizController@home');
    Route::get ('quiz/summary/{quiz_id}/{article_id}'                   , 'QuizController@summary');
    Route::get ('quiz/complete/{quiz_id}'                               , 'QuizController@complete');
    Route::get ('quiz/skip/{quiz_id}/{article_id}/{skip_article_id?}'   , 'QuizController@skip');
    Route::get ('quiz/{quiz_id}/{article_id}/{question_id}'             , 'QuizController@question');
    Route::post('quiz/{quiz_id}/{article_id}/{question_id}'             , 'QuizController@respond');
    Route::get ('quiz/results/{quiz_id}'                                , 'QuizController@results');
    Route::get ('quiz/retake/{quiz_id}'                                 , 'QuizController@retake');
    Route::post('quiz/send'                                             , 'QuizController@send_certificate');
    Route::get ('quiz/incorrect/{quiz_id}'                              , 'QuizController@incorrect');

    // Article
    Route::get ('article/list/{quiz_id}'                                , 'ArticleController@articleList');
    Route::get ('article/{article_id}'                                  , 'ArticleController@full');
    Route::get ('articlew/{article_id}'                                 , 'ArticleController@fullWrong');
    Route::get ('articleq/{article_id}'                                 , 'ArticleController@fullQuiz');

    // Profile
    Route::get ('profile'                                               , 'ProfileController@profile');
    Route::post('profile/{user_id?}'                                    , 'ProfileController@update');
});


// Confide routes
Route::get ('register'                                                  , 'UsersController@create');
Route::post('users'                                                     , 'UsersController@store');
Route::get ('login'                                                     , 'UsersController@login');
Route::post('login'                                                     , 'UsersController@doLogin');
Route::get ('users/confirm/{code}'                                      , 'UsersController@confirm');
Route::get ('forgot_password'                                           , 'UsersController@forgotPassword');
Route::post('forgot_password'                                           , 'UsersController@doForgotPassword');
Route::get ('users/reset_password/{token}'                              , 'UsersController@resetPassword');
Route::post('users/reset_password'                                      , 'UsersController@doResetPassword');
Route::get ('logout'                                                    , 'UsersController@logout');
