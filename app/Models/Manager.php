<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

    public function debts()
    {
        return $this->hasMany(Debt::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
