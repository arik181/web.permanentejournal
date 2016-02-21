<?php 

class Question extends Eloquent 
{
    protected $table = 'questions';

    public function roles()
    {
        return $this->belongsTo('Article');
    }

    public function answers()
    {
        return $this->hasMany('Answer');
    }

    public function responses()
    {
        return $this->hasMany('UserResponse');
    }
}
