<?php 

class Certificate extends Eloquent 
{
    use SoftDeletingTrait;
    protected $table = 'certificates';
    protected $fillable = array('user_id', 'quiz_id');

    public function roles()
    {
        return $this->belongsTo('User');
    }
}
