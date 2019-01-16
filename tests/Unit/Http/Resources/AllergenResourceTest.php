<?php

namespace Tests\Unit\Http\Resources;

use Tests\TestCase;
use App\Models\Meal;
use App\Models\Allergen;
use App\Http\Resources\AllergenResource;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AllergenResourceTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function ingredientResourceMustHaveNecessaryFields()
    {
        $allergen = factory(Allergen::class)->create();

        $meal1 = factory(Meal::class)->create();
        $meal2 = factory(Meal::class)->create();
        $meal3 = factory(Meal::class)->create();

        $allergen->meals()->attach([
            $meal1->id,
            $meal2->id,
            $meal3->id
        ]);

        $allergenResource = AllergenResource::make($allergen)->resolve();

        $this->assertEquals($allergen->id, $allergenResource['id']);
        $this->assertEquals($allergen->name, $allergenResource['name']);

        $this->assertEquals(3,
            $allergenResource['meals']->count()
        );

        //Check if the associated meals are of the type 'App\Models\Meals'
        $this->assertInstanceOf('App\Models\Meal',
            $allergenResource['meals']->shift()->resource
        );
        $this->assertInstanceOf('App\Models\Meal',
            $allergenResource['meals']->shift()->resource
        );
        $this->assertInstanceOf('App\Models\Meal',
            $allergenResource['meals']->shift()->resource
        );
    }
}
