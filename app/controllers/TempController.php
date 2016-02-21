<?php namespace root;
/**
 * Created by JetBrains PhpStorm.
 * User: HollenB-MBA
 * Date: 1/14/15
 * Time: 11:28 AM
 * Placeholder for developing views for future controllers
 */

class TempController extends BaseController {
    protected $layout = 'layouts.main';

    public function login()
    {
        View::share('body_id', 'quiz-home');
        $this->layout->content = View::make('quiz/index');
    }

}
