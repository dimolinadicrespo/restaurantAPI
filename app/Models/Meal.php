<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    // Allow mass Assignment
    protected $fillable = ['name', 'description'];

    //Relations

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function ingredients()
    {
        return $this->morphedByMany(Ingredient::class, 'assigned_meal');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function allergens()
    {
        return $this->morphedByMany(Allergen::class, 'assigned_meal');
    }
}
