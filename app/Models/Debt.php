<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use HasFactory;

    protected $fillable = [
        'to_pay',
        'to_collect',
        'price',
        'details',
        'user_id',
        'state',
    ];

    public function user()
    {
         return $this->belongsTo(User::class);
    }

    
}
