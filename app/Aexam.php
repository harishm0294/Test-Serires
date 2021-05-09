<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aexam extends Model
{
    protected $primaryKey = 'examcode';
    protected $table = 'exam';
    
    /**
     * Get the phone record associated with the user.
     */
    public function category()
    {
        return $this->hasOne('App\category', 'category', 'id');
    }
}
