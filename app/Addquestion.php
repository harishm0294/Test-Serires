<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Addquestion extends Model
{
    //
    protected $table = 'exam_question';

    protected $guarded = [];

    /**
     * Get the Exam that has a questions.
     */
    public function exam()
    { 
        return $this->belongsTo('App\Aexam', 'examcode', 'examcode');
    }
}
