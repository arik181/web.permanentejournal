<?php 

class UserResponse extends Eloquent 
{
    use SoftDeletingTrait;
    protected $table = 'responses';
    protected $fillable = array('user_id', 'question_id');

    public function roles()
    {
        return $this->belongsTo('Question');
    }
}
