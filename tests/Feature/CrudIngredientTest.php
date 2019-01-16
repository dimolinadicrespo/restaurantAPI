<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Ingredient;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CrudIngredientTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function userCanSeeAllIngredientsOrderByDateCreation()
    {
        //Given 4 ingredients in db
        $meal1 = factory(Ingredient::class)->create(['created_at' => now()->subDays(4)]);
        $meal2 = factory(Ingredient::class)->create(['created_at' => now()->subDays(3)]);
        $meal3 = factory(Ingredient::class)->create(['created_at' => now()->subDays(2)]);
        $meal4 = factory(Ingredient::class)->create(['created_at' => now()->subDays(1)]);

        //Make get request to api/ingredients
        $response = $this->getJson('api/ingredients');

        //Then we get 4 ingredients order by date creation
        $response->assertJson([
            'meta' => ['total' => 4]
        ]);
        $response->assertJsonStructure([
            'data','links' => ['first','last','next','prev']
        ]);

        $this->assertEquals(
            $meal4->name,
            $response->json()["data"][0]["name"]
        );
    }

    /** @test */
    public function userCanSeeOneIngredient()
    {
        //Given 1 ingredient in db
        $ingredient = factory(Ingredient::class)->create();

        //Make get request to 'api/ingredients/{ingredients->id}'
        $response = $this->getJson(route('api.ingredients.show',$ingredient->id));

        //Assert that the response has a successful status code (statusCode >= 200 && code <= statusCode)
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name'
            ]
        ]);
    }

    /** @test */
    public function userCanCreateOneIngredient()
    {
        //Make post request to ingredients
        $response = $this->postJson(route('api.ingredients.store'),[
                'name' => 'Ingrediente',
            ]
        );
        // Assert that response and the db has the given data
        $response->assertStatus(201);
        $response->assertJson([
            'name' => 'Ingrediente'
        ]);
        $this->assertDatabaseHas('ingredients',[
            'name' => 'Ingrediente'
        ]);
    }

    /** @test */
    public function userCanUpdateMeal()
    {
        //Given 1 ingredients in db
        $ingredient = factory(Ingredient::class)->create([
            'id'          => '1',
            'name'        => 'Ingrediente 1',
        ]);

        $this->assertDatabaseHas('ingredients',[
            'name' => 'Ingrediente 1',
        ]);

        //Data to update ingredients
        $data = [
            'name' => 'Ingrediente de buena caliadad',
        ];

        //Make put request to 'api/ingredients/{ingredients->id}'
        $response = $this->putJson(route('api.ingredients.update',$ingredient->id), $data);

        $response->assertSuccessful();
        $response->assertJson([
            'name'         => 'Ingrediente de buena caliadad',
        ]);
    }

    /** @test */
    public function userCanDeleteIngredient()
    {
        //Given 1 ingredients in db
        $ingredient = factory(Ingredient::class)->create();

        //Make delete request to 'ingredients/{ingredients}'
        $response = $this->deleteJson(route('api.ingredients.delete',$ingredient));
        $response->assertStatus(204);

        $this->assertDatabaseMissing('ingredients',[$ingredient->id]);
    }
}
