<?php 

class Answer extends Eloquent 
{
    protected $table = 'answers';

    public function roles()
    {
        return $this->belongsTo('Question');
    }
}
