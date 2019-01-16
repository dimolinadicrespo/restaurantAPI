<?php

namespace App\Models;

use App\Traits\HasMeals;
use Illuminate\Database\Eloquent\Model;

class Allergen extends Model
{
    use HasMeals;

    protected $fillable = ['name'];
}
