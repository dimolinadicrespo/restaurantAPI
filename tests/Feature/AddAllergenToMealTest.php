<?php

namespace Tests\Feature;

use App\Models\Meal;
use Tests\TestCase;
use App\Models\Allergen;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddAllergenToMealTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function userCanSeeAllAllergensAssociatesToAMeal()
    {
        //Given 4 allergens in db and 1 meal
        $allergen1 = factory(Allergen::class)->create(['name' => 'Alérgeno 1']);
        $allergen2 = factory(Allergen::class)->create(['name' => 'Alérgeno 2']);
        $allergen3 = factory(Allergen::class)->create(['name' => 'Alérgeno 3']);
        $allergen4 = factory(Allergen::class)->create(['name' => 'Alérgeno 4']);
        $meal1     = factory(Meal::class)->create();

        //Associate allergens with food
        $meal1->allergens()->attach([
            $allergen1->id,
            $allergen2->id,
            $allergen3->id,
            $allergen4->id,
        ]);

        //Make get request to meals/{meal}/allergens
        $response = $this->getJson(route('api.meals.allergens.index',$meal1));

        //Then we get 4 allergens with de id and name
        $response->assertJsonStructure([
            'data'
        ]);
        $this->assertCount(
            4,$response->json()["data"]
        );
        $this->assertArrayHasKey("id",$response->json()["data"][0]);
        $this->assertArrayHasKey("name",$response->json()["data"][0]);
    }

    /** @test */
    public function userCanSeeOneAllergenAssociateToMeal()
    {
        //Given 1 allergen in db
        $allergen = factory(Allergen::class)->create(['id' => 1, 'name' => 'Alérgeno Peligroso']);
        $meal     = factory(Meal::class)->create();

        //Associate allergens with food
        $meal->allergens()->attach([
            $allergen->id
        ]);

        //Make get request to 'api.meals.allergens.show'
        $response = $this->getJson(route('api.meals.allergens.show',[$meal,$allergen]));
        //Assert that the response has a successful status code (statusCode >= 200 && code <= statusCode)
        $response->assertSuccessful();
        $this->assertCount(
            1,$response->json()["data"]
        );
        $this->assertArrayHasKey("id",$response->json()["data"][0]);
        $this->assertArrayHasKey("name",$response->json()["data"][0]);
    }

    /** @test */
    public function userCanAddAllergensToAMeal()
    {
        //Given 4 allergens in db and 1 meal
        $allergen1 = factory(Allergen::class)->create(['id' => '1', 'name' => 'Un alérgeno']);
        $meal1     = factory(Meal::class)->create(['id' => '1']);

        //Make get request to meals/{meal}/allergens/{allergen}
        $response = $this->postJson(route('api.meals.allergens.store',[$meal1,$allergen1]));

        //Then we get 4 allergens with de id and name
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'name','id'
        ]);
        $this->assertEquals(
            $allergen1->id,$response->json()["id"]
        );
        $this->assertEquals(
            $allergen1->name,$response->json()["name"]
        );
    }


    /** @test */
    public function userCanDeleteAllergensFromAMeal()
    {
        //Given 4 allergens in db and 1 meal
        $allergen1 = factory(Allergen::class)->create(['name' => 'Alérgeno 1']);
        $allergen2 = factory(Allergen::class)->create(['name' => 'Alérgeno 2']);
        $allergen3 = factory(Allergen::class)->create(['name' => 'Alérgeno 3']);
        $allergen4 = factory(Allergen::class)->create(['name' => 'Alérgeno 4']);
        $meal1       = factory(Meal::class)->create();

        //Associate allergens with meal
        $meal1->allergens()->attach([
            $allergen1->id,
            $allergen2->id,
            $allergen3->id,
            $allergen4->id,
        ]);

        //Make delete request to 'meals/{meal}/allergens/{allergen}'
        $response = $this->deleteJson(route('api.meals.allergens.delete',[$meal1,$allergen1]));
        $response->assertStatus(204);

        $this->assertDatabaseMissing('assigned_meals',[
            'meal_id'          => $meal1,
            'assigned_meals'   => $allergen1->id,
            'assigned_meals_type' => get_class($allergen1)
        ]);
    }

}
