<?php 

class Article extends Eloquent 
{
    use SoftDeletingTrait;

    protected $table = 'articles';
    protected $dates = ['deleted_at'];

    public function roles()
    {
        return $this->belongsTo('Quiz');
    }

    public function questions()
    {
        return $this->hasMany('Question');
    }

    public function userResponses()
    {
        return $this->hasManyThrough('UserResponse', 'Question');
    }
}
