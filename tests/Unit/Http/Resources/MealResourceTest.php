<?php

namespace Tests\Unit\Http\Resources;

use App\Models\Allergen;
use Tests\TestCase;
use App\Models\Meal;
use App\Models\Ingredient;
use App\Http\Resources\MealResource;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MealResourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function aMealResourceMustHaveNecessaryFields()
    {
        $meal = factory(Meal::class)->create();

        // Link the ingredients to meal
        $ingredient1 = factory(Ingredient::class)->create();
        $ingredient2 = factory(Ingredient::class)->create();
        $ingredient3 = factory(Ingredient::class)->create();
        $meal->ingredients()->attach([
            $ingredient1->id,
            $ingredient2->id,
            $ingredient3->id
        ]);

        // Link the allergens to meal
        $allergen1 = factory(Allergen::class)->create();
        $allergen2 = factory(Allergen::class)->create();
        $allergen3 = factory(Allergen::class)->create();
        $meal->allergens()->attach([
            $allergen1->id,
            $allergen2->id,
            $allergen3->id
        ]);


        $mealResource = MealResource::make($meal)->resolve();

        $this->assertEquals($meal->id, $mealResource['id']);
        $this->assertEquals($meal->name, $mealResource['name']);
        $this->assertEquals($meal->description, $mealResource['description']);

        $this->assertEquals(3,
            $mealResource['ingredients']->count()
        );

        //Check if the associated meals are of the type 'App\Models\Meals'
        $this->assertInstanceOf('App\Models\Ingredient',
            $mealResource['ingredients']->shift()->resource
        );
        $this->assertInstanceOf('App\Models\Ingredient',
            $mealResource['ingredients']->shift()->resource
        );
        $this->assertInstanceOf('App\Models\Ingredient',
            $mealResource['ingredients']->shift()->resource
        );

        $this->assertEquals(3,
            $mealResource['allergens']->count()
        );

        //Check if the associated meals are of the type 'App\Models\Allergen'
        $this->assertInstanceOf('App\Models\Allergen',
            $mealResource['allergens']->shift()->resource
        );
        $this->assertInstanceOf('App\Models\Allergen',
            $mealResource['allergens']->shift()->resource
        );
        $this->assertInstanceOf('App\Models\Allergen',
            $mealResource['allergens']->shift()->resource
        );


    }
}
