<?php

namespace Tests\Unit\Http\Models;

use Tests\TestCase;
use App\Models\Meal;
use App\Models\Ingredient;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MealTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function aMealCanHaveManyIngredients()
    {
        $ingredient1 = factory(Ingredient::class)->create(['name' => 'Plato 1']);
        $ingredient2 = factory(Ingredient::class)->create(['name' => 'Plato 2']);
        $ingredient3 = factory(Ingredient::class)->create(['name' => 'Plato 3']);

        $meal = factory(Meal::class)->create();

        $meal->ingredients()->attach([
            $ingredient1->id,
            $ingredient2->id,
            $ingredient3->id,
        ]);

        $this->assertInstanceOf(Ingredient::class, $meal->ingredients->shift());
        $this->assertInstanceOf(Ingredient::class, $meal->ingredients->shift());
        $this->assertInstanceOf(Ingredient::class, $meal->ingredients->shift());
    }
}
