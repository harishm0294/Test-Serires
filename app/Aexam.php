<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aexam extends Model
{
    protected $primaryKey = 'examcode';
    protected $table = 'exam';
    
    /**
     * Get the category record associated with the exam.
     */
    public function category()
    {
        return $this->hasOne('App\category', 'category', 'id');
    }
    
    /**
     * Get the phone record associated with the user.
     */
    public function subject()
    {
        return $this->hasMany('App\examsubject', 'examcode', 'examcode');
    }
}
