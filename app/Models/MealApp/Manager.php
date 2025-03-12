<?php

namespace App\Models\MealApp;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Manager extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\ManagerFactory> */
    use HasFactory, Notifiable, HasApiTokens;
    protected $guard = 'manager';

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    protected $fillable = ['name', 'meal_name', 'email', 'password', 'reset_token'];

    public function users(){
        return $this->hasMany(User::class);
    }
    public function balance()
    {
       return $this->hasMany(Balance::class, 'manager_id');
    }
    public function expenses(){

        return $this->hasMany(Expense::class,'manager_id','id');
    }
}
