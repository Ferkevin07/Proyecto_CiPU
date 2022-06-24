<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'direction',
        'description',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }
}
