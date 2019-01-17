<?php

namespace App\Traits;

use App\Models\Meal;

trait HasMeals
{
    //Relations
    public function meals()
    {
        return $this->morphToMany(Meal::class, 'assigned_meal');
    }
}
