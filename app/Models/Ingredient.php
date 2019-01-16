<?php

namespace App\Models;

use App\Traits\HasMeals;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasMeals;

    // Allow mass Assignment
    protected $fillable = ['name'];

}
