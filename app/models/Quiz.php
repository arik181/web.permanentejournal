<?php 

class Quiz extends Eloquent 
{
    use SoftDeletingTrait;

    protected $table = 'quizzes';
    protected $dates = ['deleted_at'];

    public function articles()
    {
        return $this->hasMany('Article');
    }
}
