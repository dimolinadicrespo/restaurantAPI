<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Meal;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CrudMealTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function userCanSeeAllMealsOrderByDateCreation()
    {
        //Given 4 meal in db
        $meal1 = factory(Meal::class)->create(['created_at' => now()->subDays(4)]);
        $meal2 = factory(Meal::class)->create(['created_at' => now()->subDays(3)]);
        $meal3 = factory(Meal::class)->create(['created_at' => now()->subDays(2)]);
        $meal4 = factory(Meal::class)->create(['created_at' => now()->subDays(1)]);

        //Make get request to api/meals
        $response = $this->get('api/meals');

        //Then we get 4 meals order by date creation
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
    public function userCanSeeOneMeal()
    {
        //Given 1 meal in db
        $meal = factory(Meal::class)->create();

        //Make get request to 'api/meals/{meal->id}'
        $response = $this->get(route('api.meals.show',$meal->id));

        //Assert that the response has a successful status code (statusCode >= 200 && code <= statusCode)
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description'
            ]
        ]);
    }

    /** @test */
    public function userCanCreateOneMeal()
    {
        //Make post request to meals
        $response = $this->post(route('api.meals.store'),[
                'name' => 'Mi primer plato',
                'description' => 'Un plato muy rico con muchos ingredientes.'
            ]
        );

        // Assert that response and the db has the given data
        $response->assertStatus(201);
        $response->assertJson([
            'name' => 'Mi primer plato',
            'description' => 'Un plato muy rico con muchos ingredientes.'
        ]);
        $this->assertDatabaseHas('meals',[
            'name' => 'Mi primer plato',
            'description' => 'Un plato muy rico con muchos ingredientes.'
        ]);
    }

    /** @test */
    public function userCanUpdateMeal()
    {
        //Given 1 meal in db
        $meal = factory(Meal::class)->create([
            'id'          => '1',
            'name'        => 'Lentejas con arroz',
            'description' => 'Plato de legumbres con arroz ricas y nutritivas'
        ]);

        //Data to update meal
        $data = [
            'name' => 'Lentejas con arroz y con chorizo',
            'description' =>  'Lentejas con arroz y con chorizo.',
        ];

        //Make put request to 'api/meals/{meal->id}'
        $response = $this->put(route('api.meals.update',$meal->id), $data);

        $response->assertSuccessful();
        $response->assertJson([
            'name'         => 'Lentejas con arroz y con chorizo',
            'description'  =>  'Lentejas con arroz y con chorizo.',
        ]);
    }

    /** @test */
    public function userCanDeleteMeal()
    {
        //Given 1 meal in db
        $meal = factory(Meal::class)->create();

        //Make delete request to 'meals/{meal}'
        $response = $this->deleteJson(route('api.meals.delete',$meal));
        $response->assertStatus(204);

        $this->assertDatabaseMissing('meals',[$meal->id]);
    }
}
