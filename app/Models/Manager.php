<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Manager extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'personal_phone',
        'home_phone',
        'address',
        'state',
        'role_id',
        'password'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function debts()
    {
        return $this->hasMany(Debt::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function getFullName()
    {
        return "$this->first_name $this->last_name";
    }

    public function hasRole(string $role)
    {
        return $this->role->name === $role;
    }


    
}
