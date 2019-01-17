<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Meal;
use App\Models\Ingredient;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddIngredientToMealTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function userCanSeeAllIngredientsAssociatesToAMeal()
    {
        //Given 4 ingredients in db and 1 meal
        $ingredient1 = factory(Ingredient::class)->create(['name' => 'Ingrediente 1']);
        $ingredient2 = factory(Ingredient::class)->create(['name' => 'Ingrediente 2']);
        $ingredient3 = factory(Ingredient::class)->create(['name' => 'Ingrediente 3']);
        $ingredient4 = factory(Ingredient::class)->create(['name' => 'Ingrediente 4']);
        $meal1       = factory(Meal::class)->create();

        //Associate ingredients with food
        $meal1->ingredients()->attach([
            $ingredient1->id,
            $ingredient2->id,
            $ingredient3->id,
            $ingredient4->id,
        ]);

        //Make get request to meals/{meal}/ingredients
        $response = $this->getJson(route('api.meals.ingredients.index',$meal1));

        //Then we get 4 ingredients with de id and name
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
    public function userCanSeeOneIngredientAssociateToMeal()
    {
        //Given 1 ingredient in db
        $ingredient = factory(Ingredient::class)->create(['id' => 1, 'name' => 'Ingrediente Picante']);
        $meal       = factory(Meal::class)->create();
        //Associate ingredients with food
        $meal->ingredients()->attach([
            $ingredient->id
        ]);
        //Make get request to 'api.meals.ingredients.show'
        $response = $this->getJson(route('api.meals.ingredients.show',[$meal,$ingredient]));
        //Assert that the response has a successful status code (statusCode >= 200 && code <= statusCode)
        $response->assertSuccessful();
        $this->assertCount(
            1,$response->json()["data"]
        );
        $this->assertArrayHasKey("id",$response->json()["data"][0]);
        $this->assertArrayHasKey("name",$response->json()["data"][0]);
    }

    /** @test */
    public function userCanAddIngredientsToAMeal()
    {
        //Given 4 ingredients in db and 1 meal
        $ingredient1 = factory(Ingredient::class)->create(['id' => '1', 'name' => 'Un ingrediente']);
        $meal1       = factory(Meal::class)->create(['id' => '1']);

        //Make get request to meals/{meal}/ingredients/{ingredient}
        $response = $this->postJson(route('api.meals.ingredients.store',[$meal1,$ingredient1]));

        //Then we get 4 ingredients with de id and name
        $response->assertStatus(201);        
        $response->assertJsonStructure([            
            'name','id' 
        ]);
        $this->assertEquals(
            $ingredient1->id,$response->json()["id"]
        );
        $this->assertEquals(
            $ingredient1->name,$response->json()["name"]
        );
    }


    /** @test */
    public function userCanDeleteIngredientsFromAMeal()
    {
        //Given 4 ingredients in db and 1 meal
        $ingredient1 = factory(Ingredient::class)->create(['name' => 'Ingrediente 1']);
        $ingredient2 = factory(Ingredient::class)->create(['name' => 'Ingrediente 2']);
        $ingredient3 = factory(Ingredient::class)->create(['name' => 'Ingrediente 3']);
        $ingredient4 = factory(Ingredient::class)->create(['name' => 'Ingrediente 4']);
        $meal1       = factory(Meal::class)->create();

        //Associate ingredients with meal
        $meal1->ingredients()->attach([
            $ingredient1->id,
            $ingredient2->id,
            $ingredient3->id,
            $ingredient4->id,
        ]);

        //Make delete request to 'meals/{meal}/ingredients/{ingredient}'
        $response = $this->deleteJson(route('api.meals.ingredients.delete',[$meal1,$ingredient1]));
        $response->assertStatus(204);

        $this->assertDatabaseMissing('assigned_meals',[
            'meal_id'          => $meal1,
            'assigned_meal'   => $ingredient1->id,
            'assigned_meal_type' => get_class($ingredient1)
        ]);
    }

}
