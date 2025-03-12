<?php

namespace App\Models\MealApp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Expense extends Model
{
    use HasFactory,HasApiTokens;
    protected $fillable = ['manager_id','amount','description','date'];
    public function manager(){
        return $this->belongsTo(Manager::class);
    }
}
