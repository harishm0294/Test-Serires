<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class examsubject extends Model
{
    protected $table = 'exam_subject';

    /**
     * Get the Exam that has a subject.
     */
    public function exam()
    { 
        return $this->belongsTo('App\Aexam', 'examcode', 'examcode');
    }
}
