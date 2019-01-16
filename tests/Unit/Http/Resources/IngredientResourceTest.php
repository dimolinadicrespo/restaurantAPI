<?php

namespace Tests\Unit\Http\Resources;

use Tests\TestCase;
use App\Models\Meal;
use App\Models\Ingredient;
use App\Http\Resources\IngredientResource;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IngredientResourceTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function ingredientResourceMustHaveNecessaryFields()
    {
        $ingredient = factory(Ingredient::class)->create();

        $meal1 = factory(Meal::class)->create();
        $meal2 = factory(Meal::class)->create();
        $meal3 = factory(Meal::class)->create();

        $ingredient->meals()->attach([
            $meal1->id,
            $meal2->id,
            $meal3->id
        ]);

        $ingredientResource = IngredientResource::make($ingredient)->resolve();

        $this->assertEquals($ingredient->id, $ingredientResource['id']);
        $this->assertEquals($ingredient->name, $ingredientResource['name']);

        $this->assertEquals(3,
            $ingredientResource['meals']->count()
        );

        //Check if the associated meals are of the type 'App\Models\Meals'
        $this->assertInstanceOf('App\Models\Meal',
            $ingredientResource['meals']->shift()->resource
        );
        $this->assertInstanceOf('App\Models\Meal',
            $ingredientResource['meals']->shift()->resource
        );
        $this->assertInstanceOf('App\Models\Meal',
            $ingredientResource['meals']->shift()->resource
        );
    }
}
