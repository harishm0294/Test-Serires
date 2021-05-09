<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $table = 'category';

    /**
     * Get the Exam that has a category.
     */
    public function exam()
    {
        return $this->belongsTo('App\Aexam', 'id', 'category');
    }
}
