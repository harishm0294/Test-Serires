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
     * Get the subject record associated with the exam.
     */
    public function subject()
    {
        return $this->hasMany('App\examsubject', 'examcode', 'examcode');
    }

    /**
     * Get the question record associated with the exam.
     */
    public function question()
    {
        return $this->hasMany('App\Addquestion', 'examcode', 'examcode');
    }
}
