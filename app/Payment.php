<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'payments';

    protected $fillable = ['user_id', 'examcode', 'category', 'checksum', 'status', 'payment', 'payment_mode', 'bank_name']; 
}
