<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'stock',
        'description',
        'price_min',
        'price_max',
        'type_id',
    ];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withTimestamps();
    }

    public function providers()
    {
        return $this->belongsToMany(Provider::class)->withTimestamps();
    }
}
